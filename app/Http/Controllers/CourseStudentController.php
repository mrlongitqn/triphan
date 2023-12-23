<?php

namespace App\Http\Controllers;

use App\DataTables\CourseStudentDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateCourseStudentRequest;
use App\Http\Requests\UpdateCourseStudentRequest;
use App\Repositories\CourseStudentRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class CourseStudentController extends AppBaseController
{
    /** @var CourseStudentRepository $courseStudentRepository*/
    private $courseStudentRepository;

    public function __construct(CourseStudentRepository $courseStudentRepo)
    {
        $this->courseStudentRepository = $courseStudentRepo;
    }

    /**
     * Display a listing of the CourseStudent.
     *
     * @param CourseStudentDataTable $courseStudentDataTable
     *
     * @return Response
     */
    public function index(CourseStudentDataTable $courseStudentDataTable)
    {
        return $courseStudentDataTable->render('course_students.index');
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

        $courseStudent = $this->courseStudentRepository->create($input);

        Flash::success('Course Student saved successfully.');

        return redirect(route('courseStudents.index'));
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
}
