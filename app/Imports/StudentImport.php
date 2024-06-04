<?php

namespace App\Imports;

use App\Models\Course;
use App\Models\CourseStudent;
use App\Models\Level;
use App\Models\Student;
use App\Repositories\StudentRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentImport implements ToCollection
{

    /**
     * @var StudentRepository
     */
    private $studentModel;
    private $userId;

    public function __construct($userId)
    {
        $this->studentModel = new Student();
        $this->userId = $userId;
    }
    function generateStudentID($id)
    {
        // Chuyển đổi $id thành một chuỗi
        $idString = strval($id);
        // Sử dụng str_pad để thêm số 0 phía trước nếu chiều dài chuỗi ít hơn 6
        $paddedID = str_pad($idString, 6, '0', STR_PAD_LEFT);
        return $paddedID;
    }
    public function collection(Collection $rows)
    {
        $levels = Level::all();
        $courses = Course::where('status',0)->get();
        foreach ($rows as $index => $row) {

            if ($index == 0)
                continue;
            if ($index == 1) {
             //   dd($row);
            }
            if (!isset($row[2]) || $row[2] == null || $row[2] == "") {
                break;
            }
            try {
                $dateTime = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[3]);//->format('Y-m-d');
            } catch (\Exception $exception) {
                $dateTime = Carbon::createFromFormat('d/m/Y', "01/01/2011");
            }
            $lv = $levels->where('level', $row[8])->first();
            $newFormat = $dateTime->format('Y-m-d');
            $student = Student::create([
                'fullname' => ucwords(trim($row[1]) . ' ' . trim($row[2])),
                'dob' => $newFormat,
                'parent_name' => $row[5],
                'phone_number' => $row[4],
                'parent_phone1' => $row[6],
                'email' => $row[7],
                'level_id' => $lv ? $lv->id : 2,
                'school' => $row[9],
                'status' => 0,
                'user_id' => $this->userId,
                'note'=>$row[11]
            ]);
            $student->save();
            $student->code = $this->generateStudentID($student->id);
            $student->save();
            $class = explode(';', $row[10]);
            foreach ($class as $k => $v){
                $course = $courses->where('course',trim($v))->first();
                if(!$course)
                    continue;
                $courseStudent = CourseStudent::create([
                    'course_id' => $course->id,
                    'student_id' => $student->id,
                    'status' => 0,
                    'user_id' => 1,
                    'note' => '',
                    'fee_status'=>0
                ]);
                $courseStudent->save();
            }
        }
    }

}
