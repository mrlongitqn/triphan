<?php

namespace App\Exports;

use App\Models\CourseStudent;
use App\Models\Mark;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class MarksExport implements FromView
{

    private $id;
    private $scores;

    public function __construct($id, $scores)
    {
        $this->id = $id;
        $this->scores =count($scores)==0?[1,2,3,4,5,6,7,8,9,10]:$scores;

    }

    public function view(): View
    {
        $students = CourseStudent::where('course_id', $this->id)
            ->leftJoin('students', 'students.id', 'course_students.student_id')
            ->where('course_students.status','=',0)
            ->select('course_students.*', 'fullname','code')->get();

        $ids = $students->pluck('id');
        $marks = Mark::whereIn('course_student_id', $ids)->get()->keyBy('student_id')->toArray();
        return view('exports.marks', [
            'students' => $students,
            'marks' => $marks,
            'scores'=>$this->scores
        ]);
    }
}
