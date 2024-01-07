<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCourseSessionRequest;
use App\Http\Requests\UpdateCourseSessionRequest;
use App\Repositories\CourseRepository;
use App\Repositories\CourseSessionRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class CourseSessionController extends AppBaseController
{
    /** @var CourseSessionRepository $courseSessionRepository*/
    private $courseSessionRepository;
    /**
     * @var CourseRepository
     */
    private $courseRepository;

    public function __construct(CourseSessionRepository $courseSessionRepo, CourseRepository  $courseRepository)
    {
        $this->courseSessionRepository = $courseSessionRepo;
        $this->courseRepository = $courseRepository;
    }

    /**
     * Display a listing of the CourseSession.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $id = $request->course;
        $course = $this->courseRepository->find($id);
        if($course == null){
            abort(404);
        }
        $courseSessions = $this->courseSessionRepository->all(['course_id'=>$id]);

        return view('course_sessions.index', compact('courseSessions', 'course'));
    }

    /**
     * Show the form for creating a new CourseSession.
     *
     * @return Response
     */
    public function create(Request  $request)
    {
        $id = $request->course;
        $course = $this->courseRepository->find($id);
        return view('course_sessions.create', compact('course'));
    }

    /**
     * Store a newly created CourseSession in storage.
     *
     * @param CreateCourseSessionRequest $request
     *
     * @return Response
     */
    public function store(CreateCourseSessionRequest $request)
    {
        $input = $request->all();

        $courseSession = $this->courseSessionRepository->create($input);

        Flash::success('Đã tạo ca học thành công.');

        return redirect(route('courseSessions.index', [
            'course'=>$courseSession->course_id
        ]));
    }

    /**
     * Display the specified CourseSession.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $courseSession = $this->courseSessionRepository->find($id);

        if (empty($courseSession)) {
            Flash::error('Course Session not found');

            return redirect(route('courseSessions.index'));
        }

        return view('course_sessions.show')->with('courseSession', $courseSession);
    }

    /**
     * Show the form for editing the specified CourseSession.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $courseSession = $this->courseSessionRepository->find($id);
        $course = $this->courseRepository->find($courseSession->course_id);

        if (empty($courseSession)) {
            Flash::error('Course Session not found');

            return redirect(route('courseSessions.index'));
        }

        return view('course_sessions.edit', compact('course', 'courseSession'));
    }

    /**
     * Update the specified CourseSession in storage.
     *
     * @param int $id
     * @param UpdateCourseSessionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCourseSessionRequest $request)
    {
        $courseSession = $this->courseSessionRepository->find($id);

        if (empty($courseSession)) {
            Flash::error('Course Session not found');

            return redirect(route('courseSessions.index'));
        }

        $courseSession = $this->courseSessionRepository->update($request->all(), $id);

        Flash::success('Course Session updated successfully.');

        return redirect(route('courseSessions.index',[
            'course'=>$courseSession->course_id
        ]));
    }

    /**
     * Remove the specified CourseSession from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $courseSession = $this->courseSessionRepository->find($id);

        if (empty($courseSession)) {
            Flash::error('Course Session not found');

            return redirect(route('courseSessions.index'));
        }

        $this->courseSessionRepository->delete($id);

        Flash::success('Course Session deleted successfully.');

        return redirect(route('courseSessions.index'));
    }
}
