<?php

namespace App\Repositories;

use App\Models\CourseSessionStudent;
use App\Repositories\BaseRepository;

/**
 * Class CourseSessionStudentRepository
 * @package App\Repositories
 * @version January 7, 2024, 11:15 am +07
*/

class CourseSessionStudentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'course_id',
        'session_id',
        'student_id'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CourseSessionStudent::class;
    }

    public function listStudentBySession($course, $session){
        $data = $this->allQuery()->leftJoin('students', 'students.id', '=', 'course_session_students.student_id')
            ->where('session_id', '=', $session)
            ->select('students.*')->get();
        return $data;
    }
}
