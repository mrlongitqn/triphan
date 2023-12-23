<?php

namespace App\Http\Controllers;

use App\DataTables\CourseDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Repositories\CourseRepository;
use App\Repositories\LevelRepository;
use App\Repositories\SubjectRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class CourseController extends AppBaseController
{
    /** @var CourseRepository $courseRepository*/
    private $courseRepository;
    private $subjectRepository;
    private $levelRepository;

    public function __construct(CourseRepository $courseRepo, SubjectRepository  $subjectRepo, LevelRepository $levelRepo)
    {
        $this->courseRepository = $courseRepo;
        $this->subjectRepository = $subjectRepo;
        $this->levelRepository = $levelRepo;
    }

    /**
     * Display a listing of the Course.
     *
     * @param CourseDataTable $courseDataTable
     *
     * @return Response
     */
    public function index(CourseDataTable $courseDataTable)
    {
        return $courseDataTable->render('courses.index');
    }

    /**
     * Show the form for creating a new Course.
     *
     * @return Response
     */
    public function create()
    {
        $subjects = $this->subjectRepository->all()->pluck('subject', 'id');
        $levels = $this->levelRepository->all()->pluck('level', 'id');
        return view('courses.create', compact('subjects', 'levels'));
    }

    /**
     * Store a newly created Course in storage.
     *
     * @param CreateCourseRequest $request
     *
     * @return Response
     */
    public function store(CreateCourseRequest $request)
    {
        $input = $request->all();
        $input['status'] = 1;
        $input['open'] =  substr($input['open'], -4);
        $input['close'] =  substr($input['close'], -4);
        $input['user_id'] =  $request->user()->id;
        $course = $this->courseRepository->create($input);

        Flash::success('Đã thêm khóa học thành công.');

        return redirect(route('courses.index'));
    }

    /**
     * Display the specified Course.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $course = $this->courseRepository->find($id);

        if (empty($course)) {
            Flash::error('Khóa học không tồn tại');

            return redirect(route('courses.index'));
        }

        return view('courses.show')->with('course', $course);
    }

    /**
     * Show the form for editing the specified Course.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $course = $this->courseRepository->find($id);
        $subjects = $this->subjectRepository->all()->pluck('subject', 'id');
        $levels = $this->levelRepository->all()->pluck('level', 'id');
        if (empty($course)) {
            Flash::error('Khóa học không tồn tại');

            return redirect(route('courses.index'));
        }

        return view('courses.edit', compact('course', 'subjects', 'levels' ));
    }

    /**
     * Update the specified Course in storage.
     *
     * @param int $id
     * @param UpdateCourseRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCourseRequest $request)
    {
        $course = $this->courseRepository->find($id);

        if (empty($course)) {
            Flash::error('Khóa học không tồn tại');

            return redirect(route('courses.index'));
        }

        $course = $this->courseRepository->update($request->all(), $id);

        Flash::success('Cập nhật khóa học thành công.');

        return redirect(route('courses.index'));
    }

    /**
     * Remove the specified Course from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $course = $this->courseRepository->find($id);

        if (empty($course)) {
            Flash::error('Khóa học không tồn tại');

            return redirect(route('courses.index'));
        }

        $this->courseRepository->delete($id);

        Flash::success('Xóa khóa học thành công.');

        return redirect(route('courses.index'));
    }
    /**
     * Show the form for editing the specified Course.
     *
     * @param int $id
     *
     * @return Response
     */
    public function changeStatus($id)
    {
        $course = $this->courseRepository->find($id);

        if (empty($course)) {
            Flash::error('Khóa học không tồn tại');

            return redirect(route('courses.index'));
        }
        $course->status = 0;
        $this->courseRepository->delete($id);

        return redirect(route('courses.index'));
    }
}
