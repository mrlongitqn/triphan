<?php

namespace App\Http\Controllers;

use App\DataTables\LevelDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateLevelRequest;
use App\Http\Requests\UpdateLevelRequest;
use App\Repositories\LevelRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class LevelController extends AppBaseController
{
    /** @var LevelRepository $levelRepository*/
    private $levelRepository;

    public function __construct(LevelRepository $levelRepo)
    {
        $this->levelRepository = $levelRepo;
    }

    /**
     * Display a listing of the Level.
     *
     * @param LevelDataTable $levelDataTable
     *
     * @return Response
     */
    public function index(LevelDataTable $levelDataTable)
    {
        return $levelDataTable->render('levels.index');
    }

    /**
     * Show the form for creating a new Level.
     *
     * @return Response
     */
    public function create()
    {
        return view('levels.create');
    }

    /**
     * Store a newly created Level in storage.
     *
     * @param CreateLevelRequest $request
     *
     * @return Response
     */
    public function store(CreateLevelRequest $request)
    {
        $input = $request->all();

        $level = $this->levelRepository->create($input);

        Flash::success('Thêm khối lớp thành công.');

        return redirect(route('levels.index'));
    }

    /**
     * Display the specified Level.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $level = $this->levelRepository->find($id);

        if (empty($level)) {
            Flash::error('Không tìm thấy khối lớp');

            return redirect(route('levels.index'));
        }

        return view('levels.show')->with('level', $level);
    }

    /**
     * Show the form for editing the specified Level.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $level = $this->levelRepository->find($id);

        if (empty($level)) {
            Flash::error('Không tìm thấy khối lớp');

            return redirect(route('levels.index'));
        }

        return view('levels.edit')->with('level', $level);
    }

    /**
     * Update the specified Level in storage.
     *
     * @param int $id
     * @param UpdateLevelRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLevelRequest $request)
    {
        $level = $this->levelRepository->find($id);

        if (empty($level)) {
            Flash::error('Không tìm thấy khối lớp');

            return redirect(route('levels.index'));
        }

        $level = $this->levelRepository->update($request->all(), $id);

        Flash::success('Cập nhật khối lớp thành công');

        return redirect(route('levels.index'));
    }

    /**
     * Remove the specified Level from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $level = $this->levelRepository->find($id);

        if (empty($level)) {
            Flash::error('Không tìm thấy khối lớp');

            return redirect(route('levels.index'));
        }

        $this->levelRepository->delete($id);

        Flash::success('Xóa khối lớp thành công.');

        return redirect(route('levels.index'));
    }
}
