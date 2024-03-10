<?php

namespace App\Http\Controllers;

use App\DataTables\MarkTypeDetailDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateMarkTypeDetailRequest;
use App\Http\Requests\UpdateMarkTypeDetailRequest;
use App\Repositories\MarkTypeDetailRepository;
use App\Repositories\MarkTypeRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class MarkTypeDetailController extends AppBaseController
{
    /** @var MarkTypeDetailRepository $markTypeDetailRepository*/
    private $markTypeDetailRepository;
    /**
     * @var MarkTypeRepository
     */
    private $markTypeRepository;

    public function __construct(MarkTypeDetailRepository $markTypeDetailRepo, MarkTypeRepository  $markTypeRepository)
    {
        $this->markTypeDetailRepository = $markTypeDetailRepo;
        $this->markTypeRepository = $markTypeRepository;
    }

    /**
     * Display a listing of the MarkTypeDetail.
     *
     * @param MarkTypeDetailDataTable $markTypeDetailDataTable
     *
     * @return Response
     */
    public function index($id)
    {
        $markType = $this->markTypeRepository->find($id);
        if(!$markType)
        {
            Flash::success('Không tìm thấy loại cột điểm.');
            return redirect(route('markTypes.index'));
        }
        $detail = $this->markTypeDetailRepository->all([
           'mark_type_id'=>$id
        ]);


        return view('mark_type_details.index', compact('detail','markType'));
    }

    /**
     * Show the form for creating a new MarkTypeDetail.
     *
     * @return Response
     */
    public function create()
    {
        return view('mark_type_details.create');
    }

    /**
     * Store a newly created MarkTypeDetail in storage.
     *
     * @param CreateMarkTypeDetailRequest $request
     *
     * @return Response
     */
    public function store(CreateMarkTypeDetailRequest $request)
    {
        $input = $request->all();

        $markTypeDetail = $this->markTypeDetailRepository->create($input);

        Flash::success('Mark Type Detail saved successfully.');

        return redirect(route('markTypeDetails.index'));
    }

    /**
     * Display the specified MarkTypeDetail.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $markTypeDetail = $this->markTypeDetailRepository->find($id);

        if (empty($markTypeDetail)) {
            Flash::error('Mark Type Detail not found');

            return redirect(route('markTypeDetails.index'));
        }

        return view('mark_type_details.show')->with('markTypeDetail', $markTypeDetail);
    }

    /**
     * Show the form for editing the specified MarkTypeDetail.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $markTypeDetail = $this->markTypeDetailRepository->find($id);

        if (empty($markTypeDetail)) {
            Flash::error('Mark Type Detail not found');

            return redirect(route('markTypeDetails.index'));
        }

        return view('mark_type_details.edit')->with('markTypeDetail', $markTypeDetail);
    }

    /**
     * Update the specified MarkTypeDetail in storage.
     *
     * @param int $id
     * @param UpdateMarkTypeDetailRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMarkTypeDetailRequest $request)
    {
        $markTypeDetail = $this->markTypeDetailRepository->find($id);

        if (empty($markTypeDetail)) {
            Flash::error('Mark Type Detail not found');

            return redirect(route('markTypeDetails.index'));
        }

        $markTypeDetail = $this->markTypeDetailRepository->update($request->all(), $id);

        Flash::success('Mark Type Detail updated successfully.');

        return redirect(route('markTypeDetails.index'));
    }

    /**
     * Remove the specified MarkTypeDetail from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $markTypeDetail = $this->markTypeDetailRepository->find($id);

        if (empty($markTypeDetail)) {
            Flash::error('Mark Type Detail not found');

            return redirect(route('markTypeDetails.index'));
        }

        $this->markTypeDetailRepository->delete($id);

        Flash::success('Mark Type Detail deleted successfully.');

        return redirect(route('markTypeDetails.index'));
    }
}
