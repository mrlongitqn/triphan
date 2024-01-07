<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCourseSessionRequest;
use App\Http\Requests\UpdateCourseSessionRequest;
use App\Repositories\CourseSessionRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class CourseSessionController extends AppBaseController
{
    /** @var CourseSessionRepository $courseSessionRepository*/
    private $courseSessionRepository;

    public function __construct(CourseSessionRepository $courseSessionRepo)
    {
        $this->courseSessionRepository = $courseSessionRepo;
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
        $courseSessions = $this->courseSessionRepository->paginate(10);

        return view('course_sessions.index')
            ->with('courseSessions', $courseSessions);
    }

    /**
     * Show the form for creating a new CourseSession.
     *
     * @return Response
     */
    public function create()
    {
        return view('course_sessions.create');
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

        Flash::success('Course Session saved successfully.');

        return redirect(route('courseSessions.index'));
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

        if (empty($courseSession)) {
            Flash::error('Course Session not found');

            return redirect(route('courseSessions.index'));
        }

        return view('course_sessions.edit')->with('courseSession', $courseSession);
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

        return redirect(route('courseSessions.index'));
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
