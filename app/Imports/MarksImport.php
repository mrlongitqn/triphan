<?php

namespace App\Imports;

use App\Models\Mark;
use App\Models\Student;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class MarksImport implements ToCollection
{
    private $course_id;
    private $scores;

    public function __construct($course_id, $scores)
    {
        $this->course_id = $course_id;
        $this->scores = $scores;
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $head = $collection[0];
        $mappingCols = [];
        for ($i = 2; $i < count($head); $i++) {
            $col = explode(' ', $head[$i]);
            if (isset($col[1])) {
                if (in_array($col[1], $this->scores))
                    $mappingCols[$col[1]] = $i;
            }

        }

        $marks = Mark::where('course_id', $this->course_id)->get();

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
            $mark = $marks->find($student->id);
            if ($mark == null)
                continue;
            $update = [];
            foreach ($mappingCols as $i => $v) {
                $update['score' . $i] = $item[$v];
            }
            $mark->update($update);
        }
    }
}
