<?php

namespace App\Http\Controllers;

use App\DataTables\FeeDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateFeeRequest;
use App\Http\Requests\UpdateFeeRequest;
use App\Models\User;
use App\Repositories\CourseRepository;
use App\Repositories\CourseStudentRepository;
use App\Repositories\FeeDetailRepository;
use App\Repositories\FeeRepository;
use App\Repositories\StudentRepository;
use Carbon\Carbon;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use PHPViet\Laravel\NumberToWords\N2WFacade;
use Response;
use N2W;

class FeeController extends AppBaseController
{
    /** @var FeeRepository $feeRepository */
    private $feeRepository;
    /**
     * @var StudentRepository
     */
    private $studentRepository;
    /**
     * @var CourseRepository
     */
    private $courseRepository;
    /**
     * @var CourseStudentRepository
     */
    private $courseStudentRepository;
    /**
     * @var FeeDetailRepository
     */
    private $feeDetailRepository;

    public function __construct(FeeRepository $feeRepo, StudentRepository $studentRepository, CourseRepository $courseRepository, CourseStudentRepository $courseStudentRepository, FeeDetailRepository $feeDetailRepository)
    {
        $this->feeRepository = $feeRepo;
        $this->studentRepository = $studentRepository;
        $this->courseRepository = $courseRepository;
        $this->courseStudentRepository = $courseStudentRepository;
        $this->feeDetailRepository = $feeDetailRepository;
    }

    /**
     * Display a listing of the Fee.
     *
     * @param FeeDataTable $feeDataTable
     *
     * @return Response
     */
    public function index(FeeDataTable $feeDataTable)
    {
        $bill_id = 0;
        if (session()->has('bill_id')) {
            $bill_id = session('key');
        }
        return $feeDataTable->render('fees.index', compact('bill_id'));
    }

    /**
     * Show the form for creating a new Fee.
     *
     * @return Response
     */
    public function create()
    {
        return view('fees.create');
    }

    /**
     * Store a newly created Fee in storage.
     *
     * @param CreateFeeRequest $request
     *
     * @return Response
     */
    public function store(CreateFeeRequest $request)
    {
        $input = $request->all();

        $fee = $this->feeRepository->create($input);

        Flash::success('Fee saved successfully.');

        return redirect(route('fees.index'));
    }

    /**
     * Display the specified Fee.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $fee = $this->feeRepository->getByCode($id);
        $amount_text = N2W::toCurrency($fee->amount);
        $details = $this->feeDetailRepository->allQuery()->where('fee_id', '=', $fee->id)->get();

        $fee_text = 'Thu học phí tháng ';
        foreach ($details as $detail) {
            $fee_text = $fee_text . $detail->month . '/' . $detail->year . '; ';
        }
        $user = User::find($fee->user_id);
        $student = $this->studentRepository->find($fee->student_id);
        $course = $this->courseRepository->find($fee->course_id);
        return view('fees.show', compact('fee', 'details', 'student', 'course', 'fee_text', 'amount_text', 'user'));
    }

    /**
     * Show the form for editing the specified Fee.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $fee = $this->feeRepository->find($id);

        if (empty($fee)) {
            Flash::error('Fee not found');

            return redirect(route('fees.index'));
        }

        return view('fees.edit')->with('fee', $fee);
    }

    /**
     * Update the specified Fee in storage.
     *
     * @param int $id
     * @param UpdateFeeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFeeRequest $request)
    {
        $fee = $this->feeRepository->find($id);

        if (empty($fee)) {
            Flash::error('Fee not found');

            return redirect(route('fees.index'));
        }

        $fee = $this->feeRepository->update($request->all(), $id);

        Flash::success('Fee updated successfully.');

        return redirect(route('fees.index'));
    }

    /**
     * Remove the specified Fee from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $fee = $this->feeRepository->find($id);

        if (empty($fee)) {
            Flash::error('Fee not found');

            return redirect(route('fees.index'));
        }

        $this->feeRepository->delete($id);

        Flash::success('Fee deleted successfully.');

        return redirect(route('fees.index'));
    }

    public function collect($student_id = null, $course_id = null)
    {
        $selected_course = 0;
        if ($student_id == null || $student_id == 0)
            return view('fees.collect', compact('selected_course'));
        $student = $this->studentRepository->find($student_id);
        if ($student == null)
            return view('fees.collect', compact('selected_course'));
        $courses = $this->courseStudentRepository->getCoursesByStudent($student_id);
        $fees = $this->getListFee($course_id);

        return view('fees.collect', compact('student_id', 'selected_course', 'course_id', 'student', 'courses', 'fees'));
    }

    public function saveCollect(\Illuminate\Http\Request $request)
    {
        $data = $request->all();
        $courseStudent = $this->courseStudentRepository->find($data['courseStudentId']);
        $course = $this->courseRepository->find($courseStudent->course_id);
        $listMonth = $this->calMonth($data['courseStudentId'])['months'];
        $total = 0;
        $fee = $this->feeRepository->create([
            'course_student_id' => $courseStudent->id,
            'course_id' => $courseStudent->course_id,
            'student_id' => $courseStudent->student_id,
            'total' => 0,
            'amount' => 0,
            'status' => 0,
            'refund' => 0,
            'discount' => 0,
            'note' => $data['note'] . "",
            'fee_code' => 'TP',
            'user_id' => $request->user()->id
        ]);

        foreach ($listMonth as $item) {
            if ($request->has($item)) {
                $date = explode('-', $item);
                $this->feeDetailRepository->create([
                    'course_student_id' => $courseStudent->id,
                    'origin' => $course->fee,
                    'amount' => $data['fee_' . $item],
                    'remain' => isset($data['full_' . $item]) ? 0 : $course->fee - $data['fee_' . $item],
                    'month' => $date[0],
                    'year' => $date[1],
                    'note' => $data['note_' . $item] . "",
                    'fee_id' => $fee->id,
                    'status' => isset($data['full_' . $item]) ? 1 : 0
                ]);
                $total += $data['fee_' . $item];
            } else {
                break;
            }
        }
        $amount = $this->round($total * (1 - $data['discount'] / 100));
        $fee->update([
            'total' => $total,
            'discount' => $data['discount'],
            'amount' => $amount,
            'fee_code' => 'TP' . $this->generateFeeCode($fee->id)
        ]);

        return redirect(route('fees.index'))->with('bill_id', $fee->fee_code);
    }

    function generateFeeCode($id)
    {
        // Chuyển đổi $id thành một chuỗi
        $idString = strval($id);

        // Sử dụng str_pad để thêm số 0 phía trước nếu chiều dài chuỗi ít hơn 6
        $paddedID = str_pad($idString, 9, '0', STR_PAD_LEFT);

        return $paddedID;
    }

    function round($so)
    {
        return ceil($so / 1000) * 1000;
    }

    public function getListFee($id = 0)
    {
        $studentCourse = $this->courseStudentRepository->find($id);
        if ($studentCourse === null)
            return response()->json([
                'success' => false,
                'message' => "Thông tin không tồn tại"
            ]);

        $course = $this->courseRepository->find($studentCourse->course_id);
        if ($course == null)
            return response()->json([
                'success' => false,
                'message' => "Thông tin không tồn tại"
            ]);

        $listMonth = $this->calMonth($id);
        return response()->json([
            'success' => true,
            'list' => $listMonth
        ]);
    }

    function calMonth($studentCourseId): array
    {
        $fee = $this->feeDetailRepository->lastMonthPayByCourseStudent($studentCourseId);
        $date = Carbon::now();
        $remain = 0;
        if ($fee != null) {
            if ($fee->status == 0) {
                $date = Carbon::create($fee->year, $fee->month, 1);
                $remain = $fee->remain;
            } else {
                $date = Carbon::create($fee->year, $fee->month, 1)->addMonths(1);
            }

        }

        $listMonth = [];
        for ($i = 0; $i <= 7; $i++) {
            $listMonth[] = $date->clone()->addMonths($i)->format('n-Y');
        }
        return [
            'months' => $listMonth,
            'remain' => $remain
        ];
    }

    function getBill($id = 0)
    {
        $fee = $this->feeRepository->getByCode($id);
        $amount_text = N2W::toCurrency($fee->amount);
        $details = $this->feeDetailRepository->allQuery()->where('fee_id', '=', $fee->id)->get();

        $fee_text = 'Thu học phí tháng ';
        foreach ($details as $detail) {
            $fee_text = $fee_text . $detail->month . '/' . $detail->year . '; ';
        }
        $user = User::find($fee->user_id);
        $student = $this->studentRepository->find($fee->student_id);
        $course = $this->courseRepository->find($fee->course_id);
        return view('fees.bill', compact('fee', 'details', 'student', 'course', 'fee_text', 'amount_text', 'user'));
    }

    function cancel(Request $request)
    {
        $code = $request->code;
        $fee = $this->feeRepository->getByCode($code);
        $fee->update(['status' => 1]);
        $fee->save();
        return redirect(route('fees.index'));
    }

    //Get danh sách nợ học phí theo lớp
    public function listFeeDebtByCourse($course=0)
    {
        $listStudent = $this->courseStudentRepository->getByCourse($course)->get()->pluck('id');
        dd($listStudent);
        $date = Carbon::now();
        $listFees = $this->feeDetailRepository->allQuery()->selectRaw(' course_student_id, Max(id) as id')->groupBy('course_student_id');
    }


    //Get tất car học sinh nợ HP
}
