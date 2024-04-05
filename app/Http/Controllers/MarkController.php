<?php

namespace App\Http\Controllers;

use App\Exports\MarksExport;
use App\Imports\MarksImport;
use App\Repositories\MarkTypeDetailRepository;
use App\Repositories\MarkTypeRepository;
use App\Repositories\SessionMarkDetailRepository;
use App\Repositories\SessionMarkRepository;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\DataTables\MarkDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateMarkRequest;
use App\Http\Requests\UpdateMarkRequest;
use App\Repositories\CourseRepository;
use App\Repositories\CourseSessionRepository;
use App\Repositories\CourseSessionStudentRepository;
use App\Repositories\CourseStudentRepository;
use App\Repositories\LevelRepository;
use App\Repositories\MarkRepository;
use App\Repositories\StudentRepository;
use App\Repositories\SubjectRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Response;

class MarkController extends AppBaseController
{
    /** @var MarkRepository $markRepository */
    private $markRepository;
    /** @var CourseStudentRepository $courseStudentRepository */
    private $courseStudentRepository;
    /**
     * @var LevelRepository
     */
    private $levelRepository;
    /**
     * @var CourseRepository
     */
    private $courseRepository;
    /**
     * @var SubjectRepository
     */
    private $subjectRepository;
    /**
     * @var StudentRepository
     */
    private $studentRepository;
    /**
     * @var CourseSessionRepository
     */
    private $courseSessionRepository;
    /**
     * @var CourseSessionStudentRepository
     */
    private $courseSessionStudentRepository;
    /**
     * @var SessionMarkRepository
     */
    private $sessionMarkRepository;
    /**
     * @var SessionMarkDetailRepository
     */
    private $markDetailRepository;
    /**
     * @var MarkTypeRepository
     */
    private $markTypeRepository;
    /**
     * @var MarkTypeDetailRepository
     */
    private $markTypeDetailRepository;

    public function __construct(MarkRepository          $markRepo, CourseStudentRepository $courseStudentRepo, LevelRepository $levelRepository, CourseRepository $courseRepository, SubjectRepository $subjectRepository, StudentRepository $studentRepository,
                                CourseSessionRepository $courseSessionRepository, CourseSessionStudentRepository $courseSessionStudentRepository, SessionMarkRepository $sessionMarkRepository, SessionMarkDetailRepository $markDetailRepository,
                                MarkTypeRepository      $markTypeRepository, MarkTypeDetailRepository $markTypeDetailRepository)
    {
        $this->markRepository = $markRepo;
        $this->courseStudentRepository = $courseStudentRepo;
        $this->levelRepository = $levelRepository;
        $this->courseRepository = $courseRepository;
        $this->subjectRepository = $subjectRepository;
        $this->studentRepository = $studentRepository;
        $this->courseSessionRepository = $courseSessionRepository;
        $this->courseSessionStudentRepository = $courseSessionStudentRepository;

        $this->sessionMarkRepository = $sessionMarkRepository;
        $this->markDetailRepository = $markDetailRepository;
        $this->markTypeRepository = $markTypeRepository;
        $this->markTypeDetailRepository = $markTypeDetailRepository;
    }

    /**
     * Display a listing of the Mark.
     *
     * @param MarkDataTable $markDataTable
     *
     * @return Response
     */
    public function index(Request  $request, $id = null)
    {
        $levels = $this->levelRepository->all();
        $subjects = $this->subjectRepository->all();
        $courses = $this->courseRepository->all();
        if (count($courses) === 0) {
            Flash::error('Vui lòng tạo các lớp học trước.');
            return redirect(route('courses.index'));
        }

        $selected_course = $id == null ? $courses[0] : $courses->find($id);
        if ($selected_course === null) {
            Flash::error('Lớp học không tồn tại.');
            return redirect(route('marks.index'));
        }

        $courseStudent = $this->courseStudentRepository->getByCourse($selected_course->id, [0])->get();
        $markTypeDetail = $this->markTypeDetailRepository->all(['mark_type_id' => $selected_course->mark_type_id])->sortBy('column_number');

        $now = Carbon::now();
        $sessionMarks = $this->markDetailRepository->allQuery()
            ->leftJoin('session_marks', 'session_marks.id', '=', 'session_mark_details.session_mark_id')
            ->where('session_mark_details.course_id', '=', $selected_course->id)
            ->orderByDesc('session_marks.id')->get();
        if($request->has('session_mark')){
            $sessionMark = $sessionMarks->firstWhere('id','=', $request->session_mark);
            if(!$sessionMark){
                Flash::error('Không tìm thấy đợt nhập điểm');
                return redirect(route('marks.index', $id));
            }

            $marks = $this->markRepository->allQuery()->where([
                ['course_id', $selected_course->id],
                ['session_mark_id',$sessionMark->id]
            ])->get()->keyBy('course_student_id');
        }else{
            $sessionMark = $sessionMarks->first();
            $marks = $this->markRepository->allQuery()->where([
                ['course_id', $selected_course->id],
                ['session_mark_id',$sessionMark?$sessionMark->id:0]
            ])->get()->keyBy('course_student_id');
        }

//            ->where('start_date', '<=', $now)
//            ->where('end_date', '>=', $now)
//            ->first();
        $scores = [1,2,3,4,5,6,7,8,9,10];// $sessionMark ? explode(',', $sessionMark->scores) : [];
        return view('marks.index', compact('marks', 'levels', 'courses', 'subjects', 'selected_course', 'courseStudent', 'sessionMarks','sessionMark', 'scores', 'markTypeDetail'));
    }

    public function exportMarks($id = 0, Request $request)
    {
        $course = $this->courseRepository->find($id);
        if (!$course)
            return abort('404');
        $cols = $request->cols;
        sort($cols);
        return Excel::download(new MarksExport($id, $cols), 'Diem-'. Str::slug($course->course).'.xlsx');
    }

    /**
     * Show the form for creating a new Mark.
     *
     * @return Response
     */
    public function create()
    {
        return view('marks.create');
    }

    /**
     * Store a newly created Mark in storage.
     *
     * @param CreateMarkRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->toArray();
        $course_id = $input['course_id'];
        $course = $this->courseRepository->find($course_id);
        if (empty($course)) {
            Flash::error('Lớp học không tồn tại');

            return redirect(route('marks.index'));
        }
        $now = Carbon::now();
        $sessionMark = $this->sessionMarkRepository->find($request->session_mark_id);
        if (empty($sessionMark)) {
            Flash::error('Đợt nhập điểm không tồn tại');

            return redirect(route('marks.index', $course_id));
        }
        $scores = [1,2,3,4,5,6,7,8,9,10];// $sessionMark ? explode(',', $sessionMark->scores) : [];
        if (count($scores) == 0) {
            Flash::error('Lớp học không nằm trong đợt nhập điểm');

            return redirect(route('marks.index'));
        }
        $marks = $this->markRepository->allQuery()->where([
            ['course_id', $course->id],
            ['session_mark_id',$sessionMark->id]
        ])->get()->keyBy('course_student_id');

        foreach ($marks as $k => $mark) {
            $markScore = [];
            if (isset($input[$mark->course_student_id . '_note']))
                $markScore['note'] = $input[$mark->course_student_id . '_note'];
            foreach ($scores as $score) {
                if (!isset($input[$mark->course_student_id . '_score' . $score]))
                    continue;
                $markScore['score' . $score] = $input[$mark->course_student_id . '_score' . $score];
            }


            $mark->update($markScore);
            if($k == 3)
                dd($mark, $markScore);
        }


        Flash::success('Lưu điểm thành công.');

        return redirect(route('marks.index', $course_id).'?session_mark='.$sessionMark->id);
    }


    public function import(Request $request)
    {
        $course = $this->courseRepository->find($request->course_id);
        if (empty($course)) {
            Flash::error('Lớp học không tồn tại');

            return redirect(route('marks.index'));
        }
        $now = Carbon::now();
        $sessionMark = $this->markDetailRepository->find($request->session_id);
        if (empty($sessionMark)) {
            Flash::error('Đợt nhập điểm không tồn tại');

            return redirect(route('marks.index', $course->id));
        }

        $markTypeDetail = $this->markTypeDetailRepository->all(['mark_type_id' => $course->mark_type_id])->sortBy('column_number')->keyBy('column_name');
        Excel::import(new MarksImport($request->course_id,$sessionMark, $markTypeDetail), $request->fileImport);
        Flash::success('Import điểm thành công.');

        return redirect(route('marks.index', $course->id).'?session_mark='.$sessionMark->id);
    }

    /**
     * Display the specified Mark.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $mark = $this->markRepository->find($id);

        if (empty($mark)) {
            Flash::error('Mark not found');

            return redirect(route('marks.index'));
        }

        return view('marks.show')->with('mark', $mark);
    }

    /**
     * Show the form for editing the specified Mark.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $mark = $this->markRepository->find($id);

        if (empty($mark)) {
            Flash::error('Mark not found');

            return redirect(route('marks.index'));
        }

        return view('marks.edit')->with('mark', $mark);
    }

    /**
     * Update the specified Mark in storage.
     *
     * @param int $id
     * @param UpdateMarkRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMarkRequest $request)
    {
        $mark = $this->markRepository->find($id);

        if (empty($mark)) {
            Flash::error('Mark not found');

            return redirect(route('marks.index'));
        }

        $mark = $this->markRepository->update($request->all(), $id);

        Flash::success('Mark updated successfully.');

        return redirect(route('marks.index'));
    }

    /**
     * Remove the specified Mark from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $mark = $this->markRepository->find($id);

        if (empty($mark)) {
            Flash::error('Mark not found');

            return redirect(route('marks.index'));
        }

        $this->markRepository->delete($id);

        Flash::success('Mark deleted successfully.');

        return redirect(route('marks.index'));
    }
}
