<?php

namespace App\Http\Controllers;

use App\Imports\MultisheeStudentImport;
use App\Imports\StudentImport;
use App\Repositories\StudentRepository;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    /**
     * @var StudentRepository
     */
    private $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    function index()
    {
        $students = $this->studentRepository->all();
        foreach ($students as $i => $student){
            $student->fullname = mb_convert_case($student->fullname, MB_CASE_TITLE, 'UTF-8');
            $student->code =$this->generateStudentID($student->id);
            $student->save();
        }

        //Excel::import(new MultisheeStudentImport(), 'long.xlsx');
    }
    function generateStudentID($id)
    {
        // Chuyển đổi $id thành một chuỗi
        $idString = strval($id);

        // Sử dụng str_pad để thêm số 0 phía trước nếu chiều dài chuỗi ít hơn 6
        $paddedID = str_pad($idString, 6, '0', STR_PAD_LEFT);

        return $paddedID;
    }
}
