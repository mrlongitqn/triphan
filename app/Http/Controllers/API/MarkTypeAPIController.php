<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateMarkTypeAPIRequest;
use App\Http\Requests\API\UpdateMarkTypeAPIRequest;
use App\Models\MarkType;
use App\Repositories\MarkTypeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class MarkTypeController
 * @package App\Http\Controllers\API
 */

class MarkTypeAPIController extends AppBaseController
{
    /** @var  MarkTypeRepository */
    private $markTypeRepository;

    public function __construct(MarkTypeRepository $markTypeRepo)
    {
        $this->markTypeRepository = $markTypeRepo;
    }

    /**
     * Display a listing of the MarkType.
     * GET|HEAD /markTypes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $markTypes = $this->markTypeRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($markTypes->toArray(), 'Mark Types retrieved successfully');
    }

    /**
     * Store a newly created MarkType in storage.
     * POST /markTypes
     *
     * @param CreateMarkTypeAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateMarkTypeAPIRequest $request)
    {
        $input = $request->all();

        $markType = $this->markTypeRepository->create($input);

        return $this->sendResponse($markType->toArray(), 'Mark Type saved successfully');
    }

    /**
     * Display the specified MarkType.
     * GET|HEAD /markTypes/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var MarkType $markType */
        $markType = $this->markTypeRepository->find($id);

        if (empty($markType)) {
            return $this->sendError('Mark Type not found');
        }

        return $this->sendResponse($markType->toArray(), 'Mark Type retrieved successfully');
    }

    /**
     * Update the specified MarkType in storage.
     * PUT/PATCH /markTypes/{id}
     *
     * @param int $id
     * @param UpdateMarkTypeAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMarkTypeAPIRequest $request)
    {
        $input = $request->all();

        /** @var MarkType $markType */
        $markType = $this->markTypeRepository->find($id);

        if (empty($markType)) {
            return $this->sendError('Mark Type not found');
        }

        $markType = $this->markTypeRepository->update($input, $id);

        return $this->sendResponse($markType->toArray(), 'MarkType updated successfully');
    }

    /**
     * Remove the specified MarkType from storage.
     * DELETE /markTypes/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var MarkType $markType */
        $markType = $this->markTypeRepository->find($id);

        if (empty($markType)) {
            return $this->sendError('Mark Type not found');
        }

        $markType->delete();

        return $this->sendSuccess('Mark Type deleted successfully');
    }
}
