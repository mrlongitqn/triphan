<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\CourseStudentRepository;
use App\Repositories\FeeDetailRepository;
use App\Repositories\FeeRepository;
use App\Repositories\StudentRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

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

    public function __construct(CourseStudentRepository $courseStudentRepository, FeeDetailRepository $feeDetailRepository,
                                StudentRepository       $studentRepository, FeeRepository $feeRepository
    )
    {

        $this->courseStudentRepository = $courseStudentRepository;
        $this->feeDetailRepository = $feeDetailRepository;
        $this->studentRepository = $studentRepository;
        $this->feeRepository = $feeRepository;
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
        $userId = $request->userId;
        $studentId = $request->studentId;

        $data = $this->feeRepository->allQuery()->whereBetween('fees.created_at', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')]);

        if (count($selectedUsers) > 0) {
            $data = $data->whereIn('fees.user_id', $selectedUsers);
        }
        $data = $data->leftJoin('courses', 'courses.id', '=', 'fees.course_id')->leftJoin('students', 'students.id', '=', 'fees.student_id')->select('fees.*', 'fullname', 'course')->get();


        return view('reports.report_collect', compact('listUser', 'selectedUsers', 'datetime', 'data'));
    }
}
