<?php

namespace App\Http\Controllers;

use App\DataTables\CourseStudentDataTable;

use App\Http\Requests\CreateCourseStudentRequest;
use App\Http\Requests\UpdateCourseStudentRequest;
use App\Repositories\CourseRepository;
use App\Repositories\CourseSessionRepository;
use App\Repositories\CourseSessionStudentRepository;
use App\Repositories\CourseStudentRepository;
use App\Repositories\LevelRepository;
use App\Repositories\StudentRepository;
use App\Repositories\SubjectRepository;
use Flash;
use Illuminate\Http\Request;
use Response;

class CourseStudentController extends AppBaseController
{
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

    public function __construct(CourseStudentRepository $courseStudentRepo, LevelRepository $levelRepository, CourseRepository $courseRepository, SubjectRepository $subjectRepository, StudentRepository $studentRepository,
                                CourseSessionRepository $courseSessionRepository, CourseSessionStudentRepository $courseSessionStudentRepository)
    {
        $this->courseStudentRepository = $courseStudentRepo;
        $this->levelRepository = $levelRepository;
        $this->courseRepository = $courseRepository;
        $this->subjectRepository = $subjectRepository;
        $this->studentRepository = $studentRepository;
        $this->courseSessionRepository = $courseSessionRepository;
        $this->courseSessionStudentRepository = $courseSessionStudentRepository;
    }

    /**
     * Display a listing of the CourseStudent.
     *
     * @param CourseStudentDataTable $courseStudentDataTable
     *
     * @return Response
     */
    public function index($id = null)
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
            return redirect(route('courseStudents.index'));
        }
        $courseStudent = $this->courseStudentRepository->getByCourse($selected_course->id)->get();
        $courseSessions = $this->courseSessionRepository->all([
            'course_id' => $selected_course->id
        ]);
        $studentSession = $this->courseSessionStudentRepository->all(['course_id' => $selected_course->id]);

        foreach ($courseStudent as $value) {
            $sessionBy = $studentSession->where('student_id', '=', $value->student_id);

            $value->sessions = $sessionBy->pluck('session_id')->join(',');
        }

        return view('course_students.index', compact('levels', 'courses', 'subjects', 'selected_course', 'courseStudent', 'courseSessions'));
    }

    /**
     * Show the form for creating a new CourseStudent.
     *
     * @return Response
     */
    public function create()
    {
        return view('course_students.create');
    }

    /**
     * Store a newly created CourseStudent in storage.
     *
     * @param CreateCourseStudentRequest $request
     *
     * @return Response
     */
    public function store(CreateCourseStudentRequest $request)
    {
        $input = $request->all();
        $input['status'] = 0;
        $input['fee_status'] = 0;
        $input['note'] = '';
        $input['user_id'] = $request->user()->id;

        $exist = $this->courseStudentRepository->all([
            'course_id' => $request->course_id,
            'student_id' => $request->student_id
        ])->count();
        if ($exist > 0) {
            Flash::success('Học viên đã tồn tại trong lớp');
            return redirect(route('courseStudents.index', $request->course_id));
        }
        $courseStudent = $this->courseStudentRepository->create($input);
        if ($request->has('courseSession')) {
            $courseSessions = $request->courseSession;
            foreach ($courseSessions as $courseSession) {
                $this->courseSessionStudentRepository->create([
                    'course_id' => $request->course_id,
                    'session_id' => $courseSession,
                    'student_id' => $request->student_id,
                    'course_student_id'=>$courseStudent->id,
                ]);
            }
        }
        Flash::success('Đã thêm học viên vào lớp thành công');

        return redirect(route('courseStudents.index', $request->course_id));
    }


    public function updateSession(Request $request)
    {
        $data = $request->all();
        $courseStudent = $this->courseStudentRepository->find($data['studentCourseId']);
        if ($courseStudent == null)
            abort(404);
        $old = $this->courseSessionStudentRepository->all([
            'course_id' => $courseStudent->course_id,
            'student_id' => $courseStudent->student_id
        ]);
        if (isset($data['courseSession'])) {
            foreach ($old as $item) {
                if (in_array($item->session_id, $data['courseSession'])) {
                    //unset($item)
                    if (($key = array_search($item->session_id, $data['courseSession'])) !== false) {
                        unset($data['courseSession'][$key]);
                    }
                } else {
                    $item->delete();
                }
            }
            foreach ($data['courseSession'] as $i) {
                $this->courseSessionStudentRepository->create([
                    'course_id' => $courseStudent->course_id,
                    'student_id' => $courseStudent->student_id,
                    'session_id' => $i,
                    'course_student_id'=>$data['studentCourseId']
                ]);
            }
        } else {
            foreach ($old as $item) {
                $item->delete();
            }
        }

        return redirect(route('courseStudents.index', $courseStudent->course_id));
    }

    /**
     * Display the specified CourseStudent.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $courseStudent = $this->courseStudentRepository->find($id);

        if (empty($courseStudent)) {
            Flash::error('Course Student not found');

            return redirect(route('courseStudents.index'));
        }

        return view('course_students.show')->with('courseStudent', $courseStudent);
    }

    /**
     * Show the form for editing the specified CourseStudent.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $courseStudent = $this->courseStudentRepository->find($id);

        if (empty($courseStudent)) {
            Flash::error('Course Student not found');

            return redirect(route('courseStudents.index'));
        }

        return view('course_students.edit')->with('courseStudent', $courseStudent);
    }

    /**
     * Update the specified CourseStudent in storage.
     *
     * @param int $id
     * @param UpdateCourseStudentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCourseStudentRequest $request)
    {
        $courseStudent = $this->courseStudentRepository->find($id);

        if (empty($courseStudent)) {
            Flash::error('Course Student not found');

            return redirect(route('courseStudents.index'));
        }

        $courseStudent = $this->courseStudentRepository->update($request->all(), $id);

        Flash::success('Course Student updated successfully.');

        return redirect(route('courseStudents.index'));
    }

    /**
     * Remove the specified CourseStudent from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $courseStudent = $this->courseStudentRepository->find($id);

        if (empty($courseStudent)) {
            Flash::error('Course Student not found');

            return redirect(route('courseStudents.index'));
        }

        $this->courseStudentRepository->delete($id);

        Flash::success('Course Student deleted successfully.');

        return redirect(route('courseStudents.index'));
    }

    public function updateStatus($id)
    {
        $courseStudent = $this->courseStudentRepository->find($id);

        if (empty($courseStudent)) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy học viên'
            ]);
        }
        $courseStudent->update([
            'status' => !$courseStudent->status
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Cập nhật thành công',
            'data' => !$courseStudent->status]);
    }

    public function listCourses($student = 0)
    {
        $course = $this->courseStudentRepository->getCoursesByStudent($student, [0]);
        return response()->json([
            'success' => true,
            'data' => $course
        ]);
    }

    public function printList($course, $type='all'){
        switch ($type){
            case 'on':$status = [0]; break;
            case 'off':$status = [1]; break;
            default :$status = [0,1]; break;
        }
        $courseModel  = $this->courseRepository->find($course);
        $studentSession = $this->courseStudentRepository->getByCourse($course, $status)->get();
        return view('course_students.listStudent', compact('courseModel', 'studentSession'));
    }
    public function printListBySession($course = 0, $session = 0){
        $courseModel  = $this->courseRepository->find($course);
        $studentSession = $this->courseSessionStudentRepository->listStudentBySession($course,$session);
        $sessionModel = $this->courseSessionRepository->find($session);
        return view('course_students.listStudent', compact('courseModel', 'studentSession', 'sessionModel'));
    }
}
