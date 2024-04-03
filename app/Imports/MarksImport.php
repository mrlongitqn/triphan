<?php

namespace App\Imports;

use App\Models\Mark;
use App\Models\Student;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class MarksImport implements ToCollection
{
    private $course_id;
    private $sessionMark;
    private $scores;

    public function __construct($course_id, $sessionMark, $scores)
    {
        $this->course_id = $course_id;
        $this->sessionMark = $sessionMark;
        $this->scores = $scores;
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $head = $collection[0]->toArray();
        $mappingCols = [];
        foreach ($this->scores as $k => $v)
        {
            $col = array_search($k, $head);
            if ($col)
                $mappingCols[$col] = $v->column_number;
        }


        $note = array_search("Đánh giá", $head);
        if ($note)
            $mappingCols[$note] = 'note';

        $marks = Mark::where([
            ['course_id', $this->course_id],
            ['session_mark_id', $this->sessionMark->id]
        ])->get()->keyBy('student_id');

        $studentIds = $marks->pluck('student_id');

        $students = Student::whereIn('id', $studentIds)->select('id', 'code')->get()->keyBy('code');


        foreach ($collection as $index => $item) {

            if ($index == 0)
                continue;
            if (trim($item[0]) === '' || $item[0] === null)
                break;
            if (!isset($students[$item[0]]))
                continue;
            $student = $students[$item[0]];
            if (!isset($marks[$student->id]))
                continue;

            $mark = $marks[$student->id];

            $update = [];
            foreach ($mappingCols as $i => $v) {
                if($v == 'note')
                {
                    $update['note'] = $item[$i];
                }
                else{
                    $update['score' . $v] = $item[$i];
                }
            }

            $mark->update($update);
        }
    }
}
