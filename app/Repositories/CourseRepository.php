<?php

namespace App\Repositories;

use App\Models\Course;
use App\Repositories\BaseRepository;

/**
 * Class CourseRepository
 * @package App\Repositories
 * @version December 21, 2023, 3:06 pm UTC
*/

class CourseRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'course',
        'subjects.subject',
        'levels.level',
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
        return Course::class;
    }


}
