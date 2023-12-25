<?php

namespace App\Repositories;

use App\Models\CourseStudent;
use App\Repositories\BaseRepository;

/**
 * Class CourseStudentRepository
 * @package App\Repositories
 * @version December 23, 2023, 4:22 am UTC
*/

class CourseStudentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'course_id',
        'student_id',
        'status'
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
        return CourseStudent::class;
    }

    public function getByCourse($course_id){
        return $this->model->newQuery()->leftJoin('users','users.id','=','user_id')
            ->leftJoin('students','student_id', '=', 'students.id')
            ->where('course_id', '=',$course_id);
    }

    public function getCoursesByStudent($student_id){
        return $this->model->newQuery()->leftJoin('courses', 'courses.id', '=', 'course_id')
            ->where('student_id', $student_id)->select(['courses.id','course', 'fee', 'course_students.created_at'])->get();
    }

}
