<?php

namespace App\Http\Controllers;

use App\Jobs\ExportTotal;
use App\Mail\ReportTotalEmail;
use App\Models\User;
use App\Repositories\CourseStudentRepository;
use App\Repositories\FeeDetailRepository;
use App\Repositories\FeeRepository;
use App\Repositories\LevelRepository;
use App\Repositories\MarkRepository;
use App\Repositories\MarkTypeDetailRepository;
use App\Repositories\RefundRepository;
use App\Repositories\SessionMarkRepository;
use App\Repositories\StudentRepository;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Laracasts\Flash\Flash;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Transliterator;
use ZipArchive;

class ReportController extends AppBaseController
{

    /**
     * @var CourseStudentRepository
     */
    private $courseStudentRepository;
    /**
     * @var FeeDetailRepository
     */
    private $feeDetailRepository;
    /**
     * @var StudentRepository
     */
    private $studentRepository;
    /**
     * @var FeeRepository
     */
    private $feeRepository;
    /**
     * @var RefundRepository
     */
    private $refundRepository;
    /**
     * @var MarkRepository
     */
    private $markRepository;
    /**
     * @var SessionMarkRepository
     */
    private $sessionMarkRepository;
    /**
     * @var MarkTypeDetailRepository
     */
    private $markTypeDetailRepository;
    /**
     * @var LevelRepository
     */
    private $levelRepository;


    public function __construct(CourseStudentRepository  $courseStudentRepository, FeeDetailRepository $feeDetailRepository,
                                StudentRepository        $studentRepository, FeeRepository $feeRepository, RefundRepository $refundRepository,
                                MarkRepository           $markRepository, SessionMarkRepository $sessionMarkRepository,
                                MarkTypeDetailRepository $markTypeDetailRepository, LevelRepository $levelRepository
    )
    {

        $this->courseStudentRepository = $courseStudentRepository;
        $this->feeDetailRepository = $feeDetailRepository;
        $this->studentRepository = $studentRepository;
        $this->feeRepository = $feeRepository;
        $this->refundRepository = $refundRepository;
        $this->markRepository = $markRepository;
        $this->sessionMarkRepository = $sessionMarkRepository;
        $this->markTypeDetailRepository = $markTypeDetailRepository;
        $this->levelRepository = $levelRepository;
    }

    public function ExportDebtList()
    {
        $date = Carbon::now()->firstOfMonth();

        $result = $this->courseStudentRepository->allQuery()->where([
            ['course_students.status', '=', 0],
            ['fee_status', '!=', 1],
        ])->leftJoin('courses', 'courses.id', '=', 'course_id')->select('course_students.*', 'courses.course', 'courses.fee')->get();

        $listIds = $result->pluck('id');

        $listMaxFees = $this->feeDetailRepository->allQuery()->selectRaw('course_student_id, Max(id) as key_id')->whereIn('course_student_id', $listIds)->groupBy('course_student_id')->pluck('key_id');
        $listFees = $this->feeDetailRepository->allQuery()->whereIn('id', $listMaxFees)->get();
        $courseDebt = $result->groupBy('student_id')->map(function ($items) use ($listFees, $date) {
            foreach ($items as $item) {
                $lastMonth = $listFees->where('course_student_id', '=', $item->id)->first();
                if ($lastMonth == null) {
                    $soThang = $date->diffInMonths($item->created_at, false);
                    $item->debt_status = true;
                    $item->debt_month_num = abs($soThang) + 1;
                    $item->debt_month_start = $item->created_at->firstOfMonth();
                    $item->debt_amount = $item->debt_month_num * $item->fee;

                } else {
                    $lastMonthValue = Carbon::create($lastMonth->year, $lastMonth->month, 1);

                    $soThang = $date->diffInMonths($lastMonthValue, false);

                    if ($soThang <= 0) {
                        $item->debt_status = true;
                        $item->debt_month_num = abs($soThang);
                        $item->debt_month_start = $lastMonthValue;
                        $item->debt_amount = $item->debt_month_num * $item->fee;
                    }
                    if ($lastMonth->status == 0) {
                        $item->debt_amount = $item->debt_amount + $lastMonth->remain;
                    }
                }

            }
            return $items;
        });
        $listStudentIds = $result->pluck('student_id');
        $students = $this->studentRepository->allQuery()->whereIn('id', $listStudentIds)->select('id', 'fullname', 'dob', 'parent_phone1', 'parent_phone2')->get();
        return view('fees.listDebtAll', compact('courseDebt', 'students'));
    }

    public function ReportCollect(Request $request)
    {
        $listUser = User::select('id', 'name')->get();
        $datetime = $request->datetime;
        if ($datetime === null) {
            $date = Carbon::now();
            $datetime = $date->format('d/m/Y') . ' - ' . $date->format('d/m/Y');
        }
        $parseDate = explode(' - ', $datetime);
        $startDate = Carbon::createFromFormat('d/m/Y', $parseDate[0]);
        $endDate = Carbon::createFromFormat('d/m/Y', $parseDate[1])->addDays(1);
        $selectedUsers = $request->selectedUsers ?? [];

        $data = $this->feeRepository->allQuery()->whereBetween('fees.created_at', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])->whereIn('fees.status', [0, 2]);

        if (count($selectedUsers) > 0) {
            $data = $data->whereIn('fees.user_id', $selectedUsers);
        }
        $data = $data->leftJoin('courses', 'courses.id', '=', 'fees.course_id')->leftJoin('students', 'students.id', '=', 'fees.student_id')->select('fees.*', 'fullname', 'course')->get();
        return view('reports.report_collect', compact('listUser', 'selectedUsers', 'datetime', 'data'));
    }

    public function ReportCollectRefund(Request $request)
    {
        $listUser = User::select('id', 'name')->get();
        $datetime = $request->datetime;
        if ($datetime === null) {
            $date = Carbon::now();
            $datetime = $date->format('d/m/Y') . ' - ' . $date->format('d/m/Y');
        }
        $parseDate = explode(' - ', $datetime);
        $startDate = Carbon::createFromFormat('d/m/Y', $parseDate[0]);
        $endDate = Carbon::createFromFormat('d/m/Y', $parseDate[1])->addDays(1);
        $selectedUsers = $request->selectedUsers ?? [];

        $data = $this->feeRepository->allQuery()->whereBetween('fees.created_at', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])->whereIn('fees.status', [0, 2]);

        $refunds = $this->refundRepository->allQuery()->whereBetween('refunds.created_at', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')]);
        if (count($selectedUsers) > 0) {
            $data = $data->whereIn('fees.user_id', $selectedUsers);
            $refunds = $refunds->whereIn('refunds.user_id', $selectedUsers);
        }
        //Collect
        $data = $data->leftJoin('courses', 'courses.id', '=', 'fees.course_id')->leftJoin('students', 'students.id', '=', 'fees.student_id')->select('fees.*', 'fullname', 'course')->get();

        //Refund
        $refunds = $refunds->leftJoin('students', 'students.id', '=', 'refunds.student_id')->select('refunds.*', 'students.fullname')->get();


        return view('reports.report_collect_refund', compact('listUser', 'selectedUsers', 'datetime', 'data', 'refunds'));
    }

    public function ReportCollectCancel(Request $request)
    {
        $listUser = User::select('id', 'name')->get();
        $datetime = $request->datetime;
        if ($datetime === null) {
            $date = Carbon::now();
            $datetime = $date->format('d/m/Y') . ' - ' . $date->format('d/m/Y');
        }
        $parseDate = explode(' - ', $datetime);
        $startDate = Carbon::createFromFormat('d/m/Y', $parseDate[0]);
        $endDate = Carbon::createFromFormat('d/m/Y', $parseDate[1])->addDays(1);
        $selectedUsers = $request->selectedUsers ?? [];

        $data = $this->feeRepository->allQuery()->whereBetween('fees.updated_at', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])->where('fees.status', '=', 1);

        if (count($selectedUsers) > 0) {
            $data = $data->whereIn('fees.user_id', $selectedUsers);
        }
        $data = $data->leftJoin('courses', 'courses.id', '=', 'fees.course_id')->leftJoin('students', 'students.id', '=', 'fees.student_id')->select('fees.*', 'fullname', 'course')->get();
        return view('reports.report_collect_cancel', compact('listUser', 'selectedUsers', 'datetime', 'data'));
    }


    public function ReportTotal($id, Request $request)
    {
        $data = $this->getReportStudent($id);
        $student = $data['student'];
        $markTypeDetails = $data['markTypeDetails'];
        $sessionMarks = $data['sessionMarks'];
        $courses = $data['courses'];
        $marks = $data['marks'];
        $date = $data['date'];

        if ($request->has('sendEmail')) {
            $mail = [];
            if ($student->parent_mail)
                $mail[] = $student->parent_mail;
            if ($student->email)
                $mail[] = $student->email;

            if (count($mail) == 0) {
                Flash::error('Chưa thiết lập email cho học viên/phụ huynh');
            } else {


                Mail::to($mail)->send(new ReportTotalEmail($markTypeDetails, $sessionMarks, $student, $courses, $marks));
                Flash::success('Đã gửi email thành công');
            }
            return redirect()->back();
        }

        return view('reports.report_total', compact('markTypeDetails', 'sessionMarks', 'student', 'courses', 'marks', 'date'));
    }

    function getReportStudent($id)
    {
        $student = $this->studentRepository->find($id);
        if (empty($student))
            return ;

        //StudentCourese
        $courses = $this->courseStudentRepository->getCoursesByStudent($id, [0])->keyBy('course_id');

        $marks = $this->markRepository->all([
            'student_id' => $id
        ])->sortByDesc('course_id')->sortByDesc('session_mark_id');

        //SesssionMark
        $sessionMarks = $this->sessionMarkRepository->allQuery()->whereIn('id', $marks->pluck('session_mark_id')->toArray())->get()->keyBy('id');

        //MarkTypeDetail
        $markTypeIds = $courses->pluck('mark_type_id')->toArray();

        $markTypeDetails = $this->markTypeDetailRepository->allQuery()->whereIn('mark_type_id', array_unique($markTypeIds))->get();

        //Fee
        $listIds = $courses->where('fee_status', '=', 0)->pluck('id')->toArray();
        $date = Carbon::now()->firstOfMonth();
        $listMaxFees = $this->feeDetailRepository->allQuery()->selectRaw('course_student_id, Max(id) as key_id')->whereIn('course_student_id', $listIds)->groupBy('course_student_id')->pluck('key_id');
        $listFees = $this->feeDetailRepository->allQuery()->whereIn('id', $listMaxFees)->get();
        foreach ($courses as $item) {
            if ($item->fee_status)
                continue;
            $lastMonth = $listFees->where('course_student_id', '=', $item->id)->first();
            if ($lastMonth == null) {
                $soThang = $date->diffInMonths($item->created_at, false);
                $item->debt_status = true;
                $item->debt_month_num = abs($soThang) + 1;
                $item->debt_month_start = $item->created_at->firstOfMonth();
                $item->debt_amount = $item->debt_month_num * $item->fee;

            } else {
                $lastMonthValue = Carbon::create($lastMonth->year, $lastMonth->month, 1);

                $soThang = $date->diffInMonths($lastMonthValue, false);

                if ($soThang <= 0) {
                    $item->debt_status = true;
                    $item->debt_month_num = abs($soThang);
                    $item->debt_month_start = $lastMonthValue;
                    $item->debt_amount = $item->debt_month_num * $item->fee;
                }
                if ($lastMonth->status == 0) {
                    $item->debt_amount = $item->debt_amount + $lastMonth->remain;
                }
            }
        }
        return [
            'student' => $student,
            'courses' => $courses,
            'markTypeDetails' => $markTypeDetails,
            'sessionMarks' => $sessionMarks,
            'marks' => $marks,
            'date' => $date
        ];;
    }

    function downloadTotalByLevel($id = 0){
        $level = $this->levelRepository->find($id);

        if (!$level)
            abort(404);
        if (!str_contains($level->file_download, 'done'))
            abort(404);
        $fileDownload = json_decode($level->file_download);
        return response()->download(storage_path($fileDownload->file))->deleteFileAfterSend(true);
    }
    function exportTotalByLevel($id = 0)
    {

        $level = $this->levelRepository->find($id);

        if (!$level)
            abort(404);

        $students = $this->studentRepository->all([
            'level_id' => $id,
            'status'=>0
        ]);

        if ($students->count()==0)
            return redirect()->back();
        $this->levelRepository->update([
            'file_download'=> json_encode([
                'status'=>'wait',
                'file'=>null
            ]),
            'last_gen'=>Carbon::now()
        ], $id);
        ExportTotal::dispatch($level, $students);

        Flash::success('File download đang trong quá trình tạo. Vui lòng quay lại sau ít phút');
        return redirect()->back();
        //ExportTotal::dispatch($this->studentRepository, $level, $students, $this->courseStudentRepository, $this->markRepository, $this->sessionMarkRepository, $this->markTypeDetailRepository, $this->feeDetailRepository);
        /*
        $name = 'level' . $id;
        Storage::makeDirectory('public/'.$name);
        foreach ($students as $student) {
            $data = $this->getReportStudent($student->id);
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.export_total', $data);
            $pdf->save(storage_path('app/public/' . $name . '/' . $student->fullname . '.pdf'));
        }
        $folderPath = storage_path('app/public/'.$name); // Thay 'your-folder-name' bằng tên thư mục bạn muốn nén và tải về
        $transliterator = Transliterator::createFromRules(
            ':: NFD; :: [:Nonspacing Mark:] Remove; :: NFC;',
            Transliterator::FORWARD
        );

        $asciiString = $transliterator->transliterate( $level->level);
        $zipFileName = $asciiString.'.zip';

        // Tạo file zip mới
        $zip = new ZipArchive;
        if ($zip->open(storage_path($zipFileName), ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($folderPath),
                RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $name => $file) {
                // Bỏ qua các thư mục
                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($folderPath) + 1);

                    $zip->addFile($filePath, $relativePath);
                }
            }

            $zip->close();
        }

        // Tải file zip đã tạo
        return response()->download(storage_path($zipFileName))->deleteFileAfterSend(true);
           */
    }
}
