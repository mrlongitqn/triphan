<?php

namespace App\Http\Controllers;

use App\DataTables\MarkTypeDetailDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateMarkTypeDetailRequest;
use App\Http\Requests\UpdateMarkTypeDetailRequest;
use App\Models\MarkTypeDetail;
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
    public function create($id)
    {
        $markType = $this->markTypeRepository->find($id);
        if (empty($markType)) {
            Flash::error('Không tồn tại loại điểm');

            return redirect(route('markTypes.index'));
        }
        $all = $this->markTypeDetailRepository->all(['mark_type_id' =>$markType->id]);
        $markTypeDetail = new MarkTypeDetail();
        $markTypeDetail->column_number = count($all)+1;

        return view('mark_type_details.create', compact('markType', 'markTypeDetail'));
    }

    /**
     * Store a newly created MarkTypeDetail in storage.
     *
     * @param CreateMarkTypeDetailRequest $request
     *
     * @return Response
     */
    public function store($id, CreateMarkTypeDetailRequest $request)
    {
        $input = $request->all();

        $markTypeDetail = $this->markTypeDetailRepository->create($input);

        Flash::success('Đã tạo cột thành công.');

        return redirect(route('markTypeDetails.index', $id));
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
        $markType = $this->markTypeRepository->find($markTypeDetail->mark_type_id);
        return view('mark_type_details.edit', compact('markTypeDetail', 'markType'));
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

        Flash::success(' Cập nhật cột điểm thành công.');

        return redirect(route('markTypeDetails.index', $markTypeDetail->mark_type_id));
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
        $id =$markTypeDetail->mark_type_id;
        Flash::success('Xóa cột điểm thành công.');
        return redirect(route('markTypeDetails.index', $id));
    }
}
