<?php

namespace App\Http\Controllers;

use App\DataTables\SessionMarkDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateSessionMarkRequest;
use App\Http\Requests\UpdateSessionMarkRequest;
use App\Repositories\SessionMarkRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class SessionMarkController extends AppBaseController
{
    /** @var SessionMarkRepository $sessionMarkRepository*/
    private $sessionMarkRepository;

    public function __construct(SessionMarkRepository $sessionMarkRepo)
    {
        $this->sessionMarkRepository = $sessionMarkRepo;
    }

    /**
     * Display a listing of the SessionMark.
     *
     * @param SessionMarkDataTable $sessionMarkDataTable
     *
     * @return Response
     */
    public function index(SessionMarkDataTable $sessionMarkDataTable)
    {
        return $sessionMarkDataTable->render('session_marks.index');
    }

    /**
     * Show the form for creating a new SessionMark.
     *
     * @return Response
     */
    public function create()
    {
        return view('session_marks.create');
    }

    /**
     * Store a newly created SessionMark in storage.
     *
     * @param CreateSessionMarkRequest $request
     *
     * @return Response
     */
    public function store(CreateSessionMarkRequest $request)
    {
        $input = $request->all();

        $sessionMark = $this->sessionMarkRepository->create($input);

        Flash::success('Session Mark saved successfully.');

        return redirect(route('sessionMarks.index'));
    }

    /**
     * Display the specified SessionMark.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $sessionMark = $this->sessionMarkRepository->find($id);

        if (empty($sessionMark)) {
            Flash::error('Session Mark not found');

            return redirect(route('sessionMarks.index'));
        }

        return view('session_marks.show')->with('sessionMark', $sessionMark);
    }

    /**
     * Show the form for editing the specified SessionMark.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $sessionMark = $this->sessionMarkRepository->find($id);

        if (empty($sessionMark)) {
            Flash::error('Session Mark not found');

            return redirect(route('sessionMarks.index'));
        }

        return view('session_marks.edit')->with('sessionMark', $sessionMark);
    }

    /**
     * Update the specified SessionMark in storage.
     *
     * @param int $id
     * @param UpdateSessionMarkRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSessionMarkRequest $request)
    {
        $sessionMark = $this->sessionMarkRepository->find($id);

        if (empty($sessionMark)) {
            Flash::error('Session Mark not found');

            return redirect(route('sessionMarks.index'));
        }

        $sessionMark = $this->sessionMarkRepository->update($request->all(), $id);

        Flash::success('Session Mark updated successfully.');

        return redirect(route('sessionMarks.index'));
    }

    /**
     * Remove the specified SessionMark from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $sessionMark = $this->sessionMarkRepository->find($id);

        if (empty($sessionMark)) {
            Flash::error('Session Mark not found');

            return redirect(route('sessionMarks.index'));
        }

        $this->sessionMarkRepository->delete($id);

        Flash::success('Session Mark deleted successfully.');

        return redirect(route('sessionMarks.index'));
    }
}
