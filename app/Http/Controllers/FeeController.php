<?php

namespace App\Http\Controllers;

use App\DataTables\FeeDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateFeeRequest;
use App\Http\Requests\UpdateFeeRequest;
use App\Repositories\CourseRepository;
use App\Repositories\CourseStudentRepository;
use App\Repositories\FeeDetailRepository;
use App\Repositories\FeeRepository;
use App\Repositories\StudentRepository;
use Carbon\Carbon;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Date;
use Response;

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
        return $feeDataTable->render('fees.index');
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
        $fee = $this->feeRepository->find($id);

        if (empty($fee)) {
            Flash::error('Fee not found');

            return redirect(route('fees.index'));
        }

        return view('fees.show')->with('fee', $fee);
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
        $listMonth = $this->calMonth($data['courseStudentId']);
        $total = 0;
        $fee = $this->feeRepository->create([
            'course_student_id'=>$courseStudent->id,
            'course_id'=>$courseStudent->course_id,
            'student_id'=>$courseStudent->student_id,
            'total'=>0,
            'amount'=>0,
            'status'=>0,
            'refund'=>0,
            'discount'=>0,
            'note'=>$data['note'],
            'code'=>'TP',
            'user_id'=>$request->user()->id
        ]);
        foreach ($listMonth as $item){
            if($request->has($item)){
                $date = explode('-', $item);
                $this->feeDetailRepository->create([
                    'course_student_id'=>$courseStudent->id,
                    'origin'=>$course->fee,
                    'amount'=> $data['fee_'.$item],
                    'remain'=>0,
                    'month'=>$date[0],
                    'year'=>$date[1],
                    'note'=>$data['note_'.$item],
                    'fee_id'=>$fee->id,
                    'status'=>0
                ]);
                $total += $data['fee_'.$item];
            }else{
              break;
            }
        }
        $amount = $this->round($total * (1 - $data['discount']/100));
        $fee->update([
            'total'=>$total,
            'discount'=>$data['discount'],
            'amount'=>$amount,
            'code'=> 'TP'.$this->generateFeeCode($fee->id)
        ]);

        return redirect(route('fees.index'))->with('fee_id',$fee->id);
    }
    function generateFeeCode($id)
    {
        // Chuyển đổi $id thành một chuỗi
        $idString = strval($id);

        // Sử dụng str_pad để thêm số 0 phía trước nếu chiều dài chuỗi ít hơn 6
        $paddedID = str_pad($idString, 9, '0', STR_PAD_LEFT);

        return $paddedID;
    }
    function round($so) {
        return ceil($so / 1000) * 1000;
    }
    public function getListFee($id = 0)
    {
        $studentCourse = $this->courseStudentRepository->find($id);
        if($studentCourse === null)
            return response()->json([
                'success'=>false,
                'message'=>"Thông tin không tồn tại"
            ]);

        $course = $this->courseRepository->find($studentCourse->course_id);
        if($course == null)
            return response()->json([
            'success'=>false,
            'message'=>"Thông tin không tồn tại"
        ]);

        $listMonth = $this->calMonth($id);
        return  response()->json([
            'success'=>true,
            'list'=>$listMonth
        ]);
    }
    function calMonth($studentCourseId): array
    {
        $fee = $this->feeDetailRepository->lastMonthPayByCourseStudent($studentCourseId);
        $date = Carbon::now();
        if ($fee != null) {
            $date = Carbon::create($fee->year,$fee->month, 1)->addMonths(1);
        }

        $listMonth = [];
        for ($i = 0; $i <= 7; $i++) {
            $listMonth[] = $date->clone()->addMonths($i)->format('n-Y');
        }
        return $listMonth;
    }
}
