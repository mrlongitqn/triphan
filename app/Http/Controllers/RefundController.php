<?php

namespace App\Http\Controllers;

use App\DataTables\RefundDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateRefundRequest;
use App\Http\Requests\UpdateRefundRequest;
use App\Models\User;
use App\Repositories\CourseRepository;
use App\Repositories\FeeRepository;
use App\Repositories\RefundRepository;
use App\Repositories\StudentRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class RefundController extends AppBaseController
{
    /** @var RefundRepository $refundRepository*/
    private $refundRepository;
    /**
     * @var FeeRepository
     */
    private $feeRepository;
    /**
     * @var StudentRepository
     */
    private $studentRepository;
    /**
     * @var CourseRepository
     */
    private $courseRepository;

    public function __construct(RefundRepository $refundRepo, FeeRepository  $feeRepository,
    StudentRepository $studentRepository, CourseRepository $courseRepository
    )
    {
        $this->refundRepository = $refundRepo;
        $this->feeRepository = $feeRepository;
        $this->studentRepository = $studentRepository;
        $this->courseRepository = $courseRepository;
    }

    /**
     * Display a listing of the Refund.
     *
     * @param RefundDataTable $refundDataTable
     *
     * @return Response
     */
    public function index(RefundDataTable $refundDataTable)
    {
        return $refundDataTable->render('refunds.index');
    }

    /**
     * Show the form for creating a new Refund.
     *
     * @return Response
     */
    public function create()
    {
        return view('refunds.create');
    }

    /**
     * Store a newly created Refund in storage.
     *
     * @param CreateRefundRequest $request
     *
     * @return Response
     */
    public function store(CreateRefundRequest $request)
    {

        $input = $request->all();
        $input['user_id'] = $request->user()->id;
        $input['status'] = 0;
        $input['student_id'] = $request->studentId;
        $total = 0;
        foreach ($request->fee_ids as $fee_id){
            $fee = $this->feeRepository->find($fee_id);
            $total = $total + $fee->amount;
            $fee->update([
                'status'=>2,
                ]);
        }
        $input['total'] = $total;
        $input['fee_ids'] = json_encode($input['fee_ids']);

        $refund = $this->refundRepository->create($input);

        Flash::success('Refund saved successfully.');

        return redirect(route('refunds.index'));
    }

    /**
     * Display the specified Refund.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id=0)
    {
        $refund = $this->refundRepository->find($id);

        if (empty($refund)) {
            Flash::error('Refund not found');

            return redirect(route('refunds.index'));
        }
        $user = User::find($refund->user_id);
        $student = $this->studentRepository->find($refund->student_id);
        $fees = $this->feeRepository->allQuery()->whereIn('fees.id', json_decode($refund->fee_ids))
            ->leftJoin('courses','courses.id','=','fees.course_id')
            ->select('fees.*', 'course')
            ->get();

        return view('refunds.show', compact('refund', 'user', 'student', 'fees'));
    }

    /**
     * Show the form for editing the specified Refund.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $refund = $this->refundRepository->find($id);

        if (empty($refund)) {
            Flash::error('Refund not found');

            return redirect(route('refunds.index'));
        }

        return view('refunds.edit')->with('refund', $refund);
    }

    /**
     * Update the specified Refund in storage.
     *0
     * @param int $id
     * @param UpdateRefundRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRefundRequest $request)
    {
        $refund = $this->refundRepository->find($id);

        if (empty($refund)) {
            Flash::error('Refund not found');

            return redirect(route('refunds.index'));
        }

        $refund = $this->refundRepository->update($request->all(), $id);

        Flash::success('Refund updated successfully.');

        return redirect(route('refunds.index'));
    }

    /**
     * Remove the specified Refund from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $refund = $this->refundRepository->find($id);

        if (empty($refund)) {
            Flash::error('Refund not found');

            return redirect(route('refunds.index'));
        }

        $this->refundRepository->delete($id);

        Flash::success('Refund deleted successfully.');

        return redirect(route('refunds.index'));
    }
}
