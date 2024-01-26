<?php

namespace App\Http\Controllers;

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
    /** @var MarkRepository $markRepository*/
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
    public function __construct(MarkRepository $markRepo,CourseStudentRepository $courseStudentRepo, LevelRepository $levelRepository, CourseRepository $courseRepository, SubjectRepository $subjectRepository, StudentRepository $studentRepository,
                                CourseSessionRepository $courseSessionRepository, CourseSessionStudentRepository $courseSessionStudentRepository)
    {
        $this->markRepository = $markRepo;
        $this->courseStudentRepository = $courseStudentRepo;
        $this->levelRepository = $levelRepository;
        $this->courseRepository = $courseRepository;
        $this->subjectRepository = $subjectRepository;
        $this->studentRepository = $studentRepository;
        $this->courseSessionRepository = $courseSessionRepository;
        $this->courseSessionStudentRepository = $courseSessionStudentRepository;
    }

    /**
     * Display a listing of the Mark.
     *
     * @param MarkDataTable $markDataTable
     *
     * @return Response
     */
    public function index($id= null)
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

        $marks = $this->markRepository->all([
            'course_student_id'
        ])

        return view('marks.index', compact('levels', 'courses', 'subjects', 'selected_course', 'courseStudent', 'courseSessions'));
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
    public function store(CreateMarkRequest $request)
    {
        $input = $request->all();

        $mark = $this->markRepository->create($input);

        Flash::success('Mark saved successfully.');

        return redirect(route('marks.index'));
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
