<?php

namespace App\Imports;

use App\Models\CourseStudent;
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

    public function __construct()
    {
        $this->studentModel = new Student();
    }

    public function collection(Collection $rows)
    {
        // TODO: Implement collection() method.
        foreach ($rows as $index => $row) {

            if ($index == 0)
                continue;
//            if ($index == 49)
//                break;
            if (strtoupper($row[6]) === "NL")
                continue;
            if ($row[1] == "" || $row[1] == null) {
                break;
            }
            try {
                $dateTime = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[3]);//->format('Y-m-d');
               // $dateTime = Carbon::createFromFormat('d/m/Y', $row[3]);
            } catch (\Exception $exception) {
                $dateTime = Carbon::createFromFormat('d/m/Y', "01/01/2011");
            }
            //dd($dateTime);
            $newFormat = $dateTime->format('Y-m-d');
            $student = Student::create([
                'fullname' => ucwords(trim($row[1]) . ' ' . trim($row[2])),
                'dob' => $newFormat,
                'parent_phone1' => $row[4],
                'parent_phone2' => $row[5],
                //LEVEL
                'level_id' => 9,
                'status' => 0,
                'user_id' => 1
            ]);

            $student->save();

            $courseStudent = CourseStudent::create([
                'course_id'=>19,
                'student_id'=>$student->id,
                'status'=>0,
                'user_id'=>1,
                'note'=>''
            ]);
            $courseStudent->save();
        }
    }

}
