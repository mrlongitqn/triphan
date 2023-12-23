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
}
