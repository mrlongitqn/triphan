<?php

namespace App\Http\Controllers;

use App\DataTables\SessionMarkDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateSessionMarkRequest;
use App\Http\Requests\UpdateSessionMarkRequest;
use App\Repositories\CourseRepository;
use App\Repositories\SessionMarkDetailRepository;
use App\Repositories\SessionMarkRepository;
use Carbon\Carbon;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class SessionMarkController extends AppBaseController
{
    /** @var SessionMarkRepository $sessionMarkRepository */
    private $sessionMarkRepository;
    /**
     * @var SessionMarkDetailRepository
     */
    private $markDetailRepository;
    /**
     * @var CourseRepository
     */
    private $courseRepository;

    public function __construct(SessionMarkRepository $sessionMarkRepo, SessionMarkDetailRepository $markDetailRepository,
    CourseRepository  $courseRepository)
    {
        $this->sessionMarkRepository = $sessionMarkRepo;
        $this->markDetailRepository = $markDetailRepository;
        $this->courseRepository = $courseRepository;
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
        $date = Carbon::now();
        $datetime = $date->format('d/m/Y') . ' - ' . $date->format('d/m/Y');
        $scores = [];
        return view('session_marks.create', compact('datetime', 'scores'));
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
        if ($request->courses == null || count($request->courses) == 0) {
            return redirect()->back()->withInput()->withErrors(['courses' => 'Vui lòng chọn lớp học.']);

        }
//        if ($request->scores == null || count($request->scores) == 0) {
//            return redirect()->back()->withInput()->withErrors(['scores' => 'Vui lòng chọn cột điểm.']);
//
//        }
        $input = $request->all();
        $parseDate = explode(' - ', $request->datetime);
        $startDate = Carbon::createFromFormat('d/m/Y', $parseDate[0])->setHour(0)->setMinute(0);
        $endDate = Carbon::createFromFormat('d/m/Y', $parseDate[1])->setHour(23)->setMinute(59);
        $input['course_ids'] = implode(',', $request->courses);
        $input['start_date'] = $startDate;
        $input['end_date'] = $endDate;
        $input['user_id'] = $request->user()->id;
        $input['scores'] = '1,2,3,4,5,6,7,8,9,10';//implode(',', $request->scores);
        $sessionMark = $this->sessionMarkRepository->create($input);
        foreach ($request->courses as $cours) {
            $this->markDetailRepository->create([
                'session_mark_id' => $sessionMark->id,
                'course_id' => $cours
            ]);
        }
        Flash::success('Tạo đợt thành công');

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
            Flash::error('Đợt nhập điểm không tồn tại');

            return redirect(route('sessionMarks.index'));
        }
        $courses = $this->courseRepository->allQuery()->whereIn('id', explode(',', $sessionMark->course_ids))->get();
        $datetime = $sessionMark->start_date->format('d/m/Y').' - '.$sessionMark->end_date->format('d/m/Y');
        $scores = explode(',', $sessionMark->scores);
        return view('session_marks.edit', compact('sessionMark', 'datetime', 'courses','scores'));
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
            Flash::error('Đợt nhập điểm không tồn tại');

            return redirect(route('sessionMarks.index'));
        }
        if ($request->courses == null || count($request->courses) == 0) {
            return redirect()->back()->withInput()->withErrors(['courses' => 'Vui lòng chọn lớp học.']);

        }
//        if ($request->scores == null || count($request->scores) == 0) {
//            return redirect()->back()->withInput()->withErrors(['scores' => 'Vui lòng chọn cột điểm.']);
//
//        }
        $input = $request->all();
        $parseDate = explode(' - ', $request->datetime);
        $startDate = Carbon::createFromFormat('d/m/Y', $parseDate[0]);
        $endDate = Carbon::createFromFormat('d/m/Y', $parseDate[1]);
        $input['course_ids'] = implode(',', $request->courses);
        $input['start_date'] = $startDate;
        $input['end_date'] = $endDate;
        $input['user_id'] = $request->user()->id;
        $input['scores'] =  $input['scores'] = '1,2,3,4,5,6,7,8,9,10';//implode(',', $request->scores);
        $sessionMark = $this->sessionMarkRepository->update($input, $id);

        Flash::success('Cập nhật đợt nhập điểm thành công.');

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
            Flash::error('Đợt nhập điểm không tồn tại');

            return redirect(route('sessionMarks.index'));
        }

        $this->sessionMarkRepository->delete($id);

        Flash::success('Xoá đợt nhập điểm thành công.');

        return redirect(route('sessionMarks.index'));
    }
}
