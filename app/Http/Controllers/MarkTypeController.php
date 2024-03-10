<?php

namespace App\Http\Controllers;

use App\DataTables\MarkTypeDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateMarkTypeRequest;
use App\Http\Requests\UpdateMarkTypeRequest;
use App\Repositories\MarkTypeRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class MarkTypeController extends AppBaseController
{
    /** @var MarkTypeRepository $markTypeRepository*/
    private $markTypeRepository;

    public function __construct(MarkTypeRepository $markTypeRepo)
    {
        $this->markTypeRepository = $markTypeRepo;
    }

    /**
     * Display a listing of the MarkType.
     *
     * @param MarkTypeDataTable $markTypeDataTable
     *
     * @return Response
     */
    public function index(MarkTypeDataTable $markTypeDataTable)
    {
        return $markTypeDataTable->render('mark_types.index');
    }

    /**
     * Show the form for creating a new MarkType.
     *
     * @return Response
     */
    public function create()
    {
        return view('mark_types.create');
    }

    /**
     * Store a newly created MarkType in storage.
     *
     * @param CreateMarkTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateMarkTypeRequest $request)
    {
        $input = $request->all();

        $markType = $this->markTypeRepository->create($input);

        Flash::success('Thêm loại cột điểm thành công.');

        return redirect(route('markTypes.index'));
    }

    /**
     * Display the specified MarkType.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $markType = $this->markTypeRepository->find($id);

        if (empty($markType)) {
            Flash::error('Loại côt điểm không tồn tại');

            return redirect(route('markTypes.index'));
        }

        return view('mark_types.show')->with('markType', $markType);
    }

    /**
     * Show the form for editing the specified MarkType.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $markType = $this->markTypeRepository->find($id);

        if (empty($markType)) {
            Flash::error('Mark Type not found');

            return redirect(route('markTypes.index'));
        }

        return view('mark_types.edit')->with('markType', $markType);
    }

    /**
     * Update the specified MarkType in storage.
     *
     * @param int $id
     * @param UpdateMarkTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMarkTypeRequest $request)
    {
        $markType = $this->markTypeRepository->find($id);

        if (empty($markType)) {
            Flash::error('Loại cột điểm không tồn tại');

            return redirect(route('markTypes.index'));
        }

        $markType = $this->markTypeRepository->update($request->all(), $id);

        Flash::success('Cập nhật loại cột điểm không thành công.');

        return redirect(route('markTypes.index'));
    }

    /**
     * Remove the specified MarkType from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $markType = $this->markTypeRepository->find($id);

        if (empty($markType)) {
            Flash::error('Loại cột điểm không tồn tại');

            return redirect(route('markTypes.index'));
        }

        $this->markTypeRepository->delete($id);

        Flash::success('Xóa loại cột điểm thành công.');

        return redirect(route('markTypes.index'));
    }
}
