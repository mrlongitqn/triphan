<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSessionMarkDetailRequest;
use App\Http\Requests\UpdateSessionMarkDetailRequest;
use App\Repositories\SessionMarkDetailRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class SessionMarkDetailController extends AppBaseController
{
    /** @var SessionMarkDetailRepository $sessionMarkDetailRepository*/
    private $sessionMarkDetailRepository;

    public function __construct(SessionMarkDetailRepository $sessionMarkDetailRepo)
    {
        $this->sessionMarkDetailRepository = $sessionMarkDetailRepo;
    }

    /**
     * Display a listing of the SessionMarkDetail.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $sessionMarkDetails = $this->sessionMarkDetailRepository->paginate(10);

        return view('session_mark_details.index')
            ->with('sessionMarkDetails', $sessionMarkDetails);
    }

    /**
     * Show the form for creating a new SessionMarkDetail.
     *
     * @return Response
     */
    public function create()
    {
        return view('session_mark_details.create');
    }

    /**
     * Store a newly created SessionMarkDetail in storage.
     *
     * @param CreateSessionMarkDetailRequest $request
     *
     * @return Response
     */
    public function store(CreateSessionMarkDetailRequest $request)
    {
        $input = $request->all();

        $sessionMarkDetail = $this->sessionMarkDetailRepository->create($input);

        Flash::success('Session Mark Detail saved successfully.');

        return redirect(route('sessionMarkDetails.index'));
    }

    /**
     * Display the specified SessionMarkDetail.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $sessionMarkDetail = $this->sessionMarkDetailRepository->find($id);

        if (empty($sessionMarkDetail)) {
            Flash::error('Session Mark Detail not found');

            return redirect(route('sessionMarkDetails.index'));
        }

        return view('session_mark_details.show')->with('sessionMarkDetail', $sessionMarkDetail);
    }

    /**
     * Show the form for editing the specified SessionMarkDetail.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $sessionMarkDetail = $this->sessionMarkDetailRepository->find($id);

        if (empty($sessionMarkDetail)) {
            Flash::error('Session Mark Detail not found');

            return redirect(route('sessionMarkDetails.index'));
        }

        return view('session_mark_details.edit')->with('sessionMarkDetail', $sessionMarkDetail);
    }

    /**
     * Update the specified SessionMarkDetail in storage.
     *
     * @param int $id
     * @param UpdateSessionMarkDetailRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSessionMarkDetailRequest $request)
    {
        $sessionMarkDetail = $this->sessionMarkDetailRepository->find($id);

        if (empty($sessionMarkDetail)) {
            Flash::error('Session Mark Detail not found');

            return redirect(route('sessionMarkDetails.index'));
        }

        $sessionMarkDetail = $this->sessionMarkDetailRepository->update($request->all(), $id);

        Flash::success('Session Mark Detail updated successfully.');

        return redirect(route('sessionMarkDetails.index'));
    }

    /**
     * Remove the specified SessionMarkDetail from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $sessionMarkDetail = $this->sessionMarkDetailRepository->find($id);

        if (empty($sessionMarkDetail)) {
            Flash::error('Session Mark Detail not found');

            return redirect(route('sessionMarkDetails.index'));
        }

        $this->sessionMarkDetailRepository->delete($id);

        Flash::success('Session Mark Detail deleted successfully.');

        return redirect(route('sessionMarkDetails.index'));
    }
}
