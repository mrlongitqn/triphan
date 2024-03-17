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

    public function getByCourse($course_id, $status= [0,1]){
        return $this->model->newQuery()->leftJoin('users','users.id','=','user_id')
            ->leftJoin('students','student_id', '=', 'students.id')
            ->where('course_id', '=',$course_id)
            ->whereIn('course_students.status', $status)
            ->select(['course_students.id','students.code','students.fullname','students.dob', 'students.phone_number','students.parent_phone1','course_students.created_at','users.name','fee_status','course_students.status', 'student_id', 'course_students.status']);
    }

    public function getCoursesByStudent($student_id, $status){
        return $this->model->newQuery()->leftJoin('courses', 'courses.id', '=', 'course_id')
            ->where('student_id', $student_id)
           ->whereIn('course_students.status',$status)
            ->select(['course_students.id', 'course_id','course', 'fee', 'course_students.created_at', 'fee_status','student_id'])->get();
    }

}
