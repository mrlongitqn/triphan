<?php

namespace App\Imports;

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
            if (strtoupper($row[6]) === "NL")
                continue;
            try {
                $dateTime = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[3]);//->format('Y-m-d');
               // $dateTime = Carbon::createFromFormat('d/m/Y', $row[3]);
            } catch (\Exception $exception) {
                $dateTime = Carbon::createFromFormat('d/m/Y', "01/01/2011");
            }
            //dd($dateTime);
            $newFormat = $dateTime->format('Y-m-d');
//            $student = Student::create([
//                'fullname' => $row[1] . ' ' . $rows[2],
//                'dob' => $dateTime,
//                'parent_phone1' => $row[4],
//                'parent_phone2' => $row[5],
//                //LEVEL
//                'level_id' => 2,
//                'status' => 0,
//                'user_id' => 1
//            ]);
            $student = Student::create([
                'fullname' => 'Long',
                'dob' => '2015-01-02',
                'parent_phone1' => '0123',
                'parent_phone2' => '123',
                //LEVEL
                'level_id' => 2,
                'status' => 0,
                'user_id' => 1
            ]);
            $student->save();
           dd($student);
        }

    }

}
