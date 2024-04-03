<?php

namespace App\Http\Controllers;

use App\DataTables\StudentDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Mail\ReportTotalEmail;
use App\Repositories\StudentRepository;
use DateTime;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Response;

class StudentController extends AppBaseController
{
    /** @var StudentRepository $studentRepository */
    private $studentRepository;

    public function __construct(StudentRepository $studentRepo)
    {
        $this->studentRepository = $studentRepo;
    }

    /**
     * Display a listing of the Student.
     *
     * @param StudentDataTable $studentDataTable
     *
     * @return Response
     */
    public function index(StudentDataTable $studentDataTable)
    {
        return $studentDataTable->render('students.index');
    }

    /**
     * Show the form for creating a new Student.
     *
     * @return Response
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created Student in storage.
     *
     * @param CreateStudentRequest $request
     *
     * @return Response
     */
    public function store(CreateStudentRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = $request->user()->id;
        $input['status'] = 0;
        $d = str_replace('/', '-', $input['dob']);
        $date = DateTime::createFromFormat('d-m-Y', $d);

        if ($date) {
            $formattedDate = $date->format('Y-m-d');
            $input['dob'] = $formattedDate;  // Kết quả sẽ là: 2024-04-15
        } else {
            Flash::error('Ngày sinh không hợp lệ.');
            return redirect()->back();
        }

        $student = $this->studentRepository->create($input);
        $student->code = $this->generateStudentID($student->id);
        $student->update();

        Flash::success('Thêm học viên thành công.');

        return redirect(route('students.index'));
    }

    function generateStudentID($id)
    {
        // Chuyển đổi $id thành một chuỗi
        $idString = strval($id);

        // Sử dụng str_pad để thêm số 0 phía trước nếu chiều dài chuỗi ít hơn 6
        $paddedID = str_pad($idString, 6, '0', STR_PAD_LEFT);

        return $paddedID;
    }

    /**
     * Display the specified Student.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $student = $this->studentRepository->find($id);

        if (empty($student)) {
            Flash::error('Học viên không tồn tại');

            return redirect(route('students.index'));
        }

        return view('students.show')->with('student', $student);
    }

    /**
     * Show the form for editing the specified Student.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $student = $this->studentRepository->find($id);
        if (empty($student)) {
            Flash::error('Học viên không tồn tại');

            return redirect(route('students.index'));
        }

        return view('students.edit')->with('student', $student);
    }

    /**
     * Update the specified Student in storage.
     *
     * @param int $id
     * @param UpdateStudentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateStudentRequest $request)
    {
        $student = $this->studentRepository->find($id);
        $input = $request->all();
        $d = str_replace('/', '-', $input['dob']);

        if (empty($student)) {
            Flash::error('Học viên không tồn tại');

            return redirect(route('students.index'));
        }
        $date = DateTime::createFromFormat('d-m-Y', $d);

        if ($date) {
            $formattedDate = $date->format('Y-m-d');
            $input['dob'] = $formattedDate;  // Kết quả sẽ là: 2024-04-15
        } else {
            Flash::error('Ngày sinh không hợp lệ.');
            return redirect()->back();
        }
        $student = $this->studentRepository->update($input, $id);

        Flash::success('Cập nhật học viên thành công.');

        return redirect(route('students.index'));
    }

    /**
     * Remove the specified Student from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $student = $this->studentRepository->find($id);

        if (empty($student)) {
            Flash::error('Học viên không tồn tại');

            return redirect(route('students.index'));
        }

        $this->studentRepository->delete($id);

        Flash::success('Xóa học viên thành công.');

        return redirect(route('students.index'));
    }

    public function search(Request $request)
    {
        $keyword = $request->term;
        $data = $this->studentRepository->search('%' . $keyword . '%')->selectRaw("id, CONCAT (code, '-',fullname) as text")->get();


        return response()->json(
            [
                "results" => $data,
                "pagination" => [
                    'more' => false
                ]
            ]
        );
    }
}
