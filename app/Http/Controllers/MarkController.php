<?php

namespace App\Http\Controllers;

use App\DataTables\MarkDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateMarkRequest;
use App\Http\Requests\UpdateMarkRequest;
use App\Repositories\MarkRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class MarkController extends AppBaseController
{
    /** @var MarkRepository $markRepository*/
    private $markRepository;

    public function __construct(MarkRepository $markRepo)
    {
        $this->markRepository = $markRepo;
    }

    /**
     * Display a listing of the Mark.
     *
     * @param MarkDataTable $markDataTable
     *
     * @return Response
     */
    public function index(MarkDataTable $markDataTable)
    {
        return $markDataTable->render('marks.index');
    }

    /**
     * Show the form for creating a new Mark.
     *
     * @return Response
     */
    public function create()
    {
        return view('marks.create');
    }

    /**
     * Store a newly created Mark in storage.
     *
     * @param CreateMarkRequest $request
     *
     * @return Response
     */
    public function store(CreateMarkRequest $request)
    {
        $input = $request->all();

        $mark = $this->markRepository->create($input);

        Flash::success('Mark saved successfully.');

        return redirect(route('marks.index'));
    }

    /**
     * Display the specified Mark.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $mark = $this->markRepository->find($id);

        if (empty($mark)) {
            Flash::error('Mark not found');

            return redirect(route('marks.index'));
        }

        return view('marks.show')->with('mark', $mark);
    }

    /**
     * Show the form for editing the specified Mark.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $mark = $this->markRepository->find($id);

        if (empty($mark)) {
            Flash::error('Mark not found');

            return redirect(route('marks.index'));
        }

        return view('marks.edit')->with('mark', $mark);
    }

    /**
     * Update the specified Mark in storage.
     *
     * @param int $id
     * @param UpdateMarkRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMarkRequest $request)
    {
        $mark = $this->markRepository->find($id);

        if (empty($mark)) {
            Flash::error('Mark not found');

            return redirect(route('marks.index'));
        }

        $mark = $this->markRepository->update($request->all(), $id);

        Flash::success('Mark updated successfully.');

        return redirect(route('marks.index'));
    }

    /**
     * Remove the specified Mark from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $mark = $this->markRepository->find($id);

        if (empty($mark)) {
            Flash::error('Mark not found');

            return redirect(route('marks.index'));
        }

        $this->markRepository->delete($id);

        Flash::success('Mark deleted successfully.');

        return redirect(route('marks.index'));
    }
}
