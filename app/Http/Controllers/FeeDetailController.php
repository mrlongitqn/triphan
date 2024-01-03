<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFeeDetailRequest;
use App\Http\Requests\UpdateFeeDetailRequest;
use App\Repositories\FeeDetailRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class FeeDetailController extends AppBaseController
{
    /** @var FeeDetailRepository $feeDetailRepository*/
    private $feeDetailRepository;

    public function __construct(FeeDetailRepository $feeDetailRepo)
    {
        $this->feeDetailRepository = $feeDetailRepo;
    }

    /**
     * Display a listing of the FeeDetail.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $feeDetails = $this->feeDetailRepository->paginate(10);

        return view('fee_details.index')
            ->with('feeDetails', $feeDetails);
    }

    /**
     * Show the form for creating a new FeeDetail.
     *
     * @return Response
     */
    public function create()
    {
        return view('fee_details.create');
    }

    /**
     * Store a newly created FeeDetail in storage.
     *
     * @param CreateFeeDetailRequest $request
     *
     * @return Response
     */
    public function store(CreateFeeDetailRequest $request)
    {
        $input = $request->all();

        $feeDetail = $this->feeDetailRepository->create($input);

        Flash::success('Fee Detail saved successfully.');

        return redirect(route('feeDetails.index'));
    }

    /**
     * Display the specified FeeDetail.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $feeDetail = $this->feeDetailRepository->find($id);

        if (empty($feeDetail)) {
            Flash::error('Fee Detail not found');

            return redirect(route('feeDetails.index'));
        }

        return view('fee_details.show')->with('feeDetail', $feeDetail);
    }

    /**
     * Show the form for editing the specified FeeDetail.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $feeDetail = $this->feeDetailRepository->find($id);

        if (empty($feeDetail)) {
            Flash::error('Fee Detail not found');

            return redirect(route('feeDetails.index'));
        }

        return view('fee_details.edit')->with('feeDetail', $feeDetail);
    }

    /**
     * Update the specified FeeDetail in storage.
     *
     * @param int $id
     * @param UpdateFeeDetailRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFeeDetailRequest $request)
    {
        $feeDetail = $this->feeDetailRepository->find($id);

        if (empty($feeDetail)) {
            Flash::error('Fee Detail not found');

            return redirect(route('feeDetails.index'));
        }

        $feeDetail = $this->feeDetailRepository->update($request->all(), $id);

        Flash::success('Fee Detail updated successfully.');

        return redirect(route('feeDetails.index'));
    }

    /**
     * Remove the specified FeeDetail from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $feeDetail = $this->feeDetailRepository->find($id);

        if (empty($feeDetail)) {
            Flash::error('Fee Detail not found');

            return redirect(route('feeDetails.index'));
        }

        $this->feeDetailRepository->delete($id);

        Flash::success('Fee Detail deleted successfully.');

        return redirect(route('feeDetails.index'));
    }
}
