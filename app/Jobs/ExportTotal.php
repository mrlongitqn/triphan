<?php

namespace App\Jobs;

use App\Models\CourseStudent;
use App\Models\FeeDetail;
use App\Models\Level;
use App\Models\Mark;
use App\Models\MarkTypeDetail;
use App\Models\SessionMark;
use App\Repositories\StudentRepository;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Symfony\Polyfill\Intl\Idn\Info;
use Transliterator;
use ZipArchive;

class ExportTotal implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private $students;
    private $level;
    private $courseStudent;


    public function __construct($level, $students)
    {
        $this->level = $level;
        $this->students = $students;
        $this->courseStudent = CourseStudent::class;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
          $name = 'level' . $this->level->id;
        Storage::deleteDirectory('public/' . $name);
        Storage::makeDirectory('public/' . $name);
        foreach ($this->students as $student) {
            $data = $this->getReportStudent($student);
            if (!$data)
                continue;
            if(!is_array($data))
                continue;
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.export_total', $data);
            $pdf->save(storage_path('app/public/' . $name . '/' . $student->fullname . '.pdf'));
        }
        $folderPath = storage_path('app/public/' . $name); // Thay 'your-folder-name' bằng tên thư mục bạn muốn nén và tải về
        $transliterator = Transliterator::createFromRules(
            ':: NFD; :: [:Nonspacing Mark:] Remove; :: NFC;',
            Transliterator::FORWARD
        );

        $asciiString = $transliterator->transliterate($this->level->level);
        $zipFileName = $asciiString . '.zip';

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
        $lv = Level::find($this->level->id);
        $lv->update(['file_download'=>json_encode([
            'status'=>'done',
            'file'=>$zipFileName
        ])]);
    }

    function getReportStudent($student)
    {
        $id = $student->id;
        //StudentCourese
        $courses = CourseStudent::leftJoin('courses', 'courses.id', '=', 'course_id')
            ->where('student_id', $id)
            ->whereIn('course_students.status', [0])
            ->select(['course_students.id', 'course_id', 'course', 'fee', 'course_students.created_at', 'fee_status', 'student_id', 'mark_type_id'])->get()->keyBy('course_id');
        if (count($courses) == 0)
            return;

        $marks = Mark::where(
            'student_id', '=', $id
        )->whereIn('course_id', $courses->pluck('course_id'))->orderBy('course_id', 'desc')->get();

        //SesssionMark
        $sessionMarks = SessionMark::whereIn('id', $marks->pluck('session_mark_id')->toArray())->get()->keyBy('id');

        //MarkTypeDetail
        $markTypeIds = $courses->pluck('mark_type_id')->toArray();

        $markTypeDetails = MarkTypeDetail::whereIn('mark_type_id', array_unique($markTypeIds))->get();

        //Fee
        $listIds = $courses->where('fee_status', '=', 0)->pluck('id')->toArray();
        $date = Carbon::now()->firstOfMonth();
        $listMaxFees = FeeDetail::selectRaw('course_student_id, Max(id) as key_id')->whereIn('course_student_id', $listIds)->groupBy('course_student_id')->pluck('key_id');
        $listFees = FeeDetail::whereIn('id', $listMaxFees)->get();
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
}
