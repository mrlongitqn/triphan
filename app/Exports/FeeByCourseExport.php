<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class FeeByCourseExport implements FromView
{

    private $course;
    private $fees;
    private $students;
    private $mY;

    public function __construct($course,$students, $fees, $mY)
    {
        $this->course = $course;
        $this->fees = $fees;
        $this->students = $students;
        $this->mY = $mY;
    }

    public function view(): View
    {
        return view('exports.fee_by_course', [
            'course' => $this->course,
            'students'=>$this->students,
            'fees'=>$this->fees,
            'monthYear'=>$this->mY
        ]);
    }
}
