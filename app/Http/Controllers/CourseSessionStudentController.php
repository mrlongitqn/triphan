<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCourseSessionStudentRequest;
use App\Http\Requests\UpdateCourseSessionStudentRequest;
use App\Repositories\CourseSessionStudentRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class CourseSessionStudentController extends AppBaseController
{
    /** @var CourseSessionStudentRepository $courseSessionStudentRepository*/
    private $courseSessionStudentRepository;

    public function __construct(CourseSessionStudentRepository $courseSessionStudentRepo)
    {
        $this->courseSessionStudentRepository = $courseSessionStudentRepo;
    }

    /**
     * Display a listing of the CourseSessionStudent.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $courseSessionStudents = $this->courseSessionStudentRepository->paginate(10);

        return view('course_session_students.index')
            ->with('courseSessionStudents', $courseSessionStudents);
    }

    /**
     * Show the form for creating a new CourseSessionStudent.
     *
     * @return Response
     */
    public function create()
    {
        return view('course_session_students.create');
    }

    /**
     * Store a newly created CourseSessionStudent in storage.
     *
     * @param CreateCourseSessionStudentRequest $request
     *
     * @return Response
     */
    public function store(CreateCourseSessionStudentRequest $request)
    {
        $input = $request->all();

        $courseSessionStudent = $this->courseSessionStudentRepository->create($input);

        Flash::success('Course Session Student saved successfully.');

        return redirect(route('courseSessionStudents.index'));
    }

    /**
     * Display the specified CourseSessionStudent.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $courseSessionStudent = $this->courseSessionStudentRepository->find($id);

        if (empty($courseSessionStudent)) {
            Flash::error('Course Session Student not found');

            return redirect(route('courseSessionStudents.index'));
        }

        return view('course_session_students.show')->with('courseSessionStudent', $courseSessionStudent);
    }

    /**
     * Show the form for editing the specified CourseSessionStudent.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $courseSessionStudent = $this->courseSessionStudentRepository->find($id);

        if (empty($courseSessionStudent)) {
            Flash::error('Course Session Student not found');

            return redirect(route('courseSessionStudents.index'));
        }

        return view('course_session_students.edit')->with('courseSessionStudent', $courseSessionStudent);
    }

    /**
     * Update the specified CourseSessionStudent in storage.
     *
     * @param int $id
     * @param UpdateCourseSessionStudentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCourseSessionStudentRequest $request)
    {
        $courseSessionStudent = $this->courseSessionStudentRepository->find($id);

        if (empty($courseSessionStudent)) {
            Flash::error('Course Session Student not found');

            return redirect(route('courseSessionStudents.index'));
        }

        $courseSessionStudent = $this->courseSessionStudentRepository->update($request->all(), $id);

        Flash::success('Course Session Student updated successfully.');

        return redirect(route('courseSessionStudents.index'));
    }

    /**
     * Remove the specified CourseSessionStudent from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $courseSessionStudent = $this->courseSessionStudentRepository->find($id);

        if (empty($courseSessionStudent)) {
            Flash::error('Course Session Student not found');

            return redirect(route('courseSessionStudents.index'));
        }

        $this->courseSessionStudentRepository->delete($id);

        Flash::success('Course Session Student deleted successfully.');

        return redirect(route('courseSessionStudents.index'));
    }
}
