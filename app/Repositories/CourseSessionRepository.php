<?php

namespace App\Repositories;

use App\Models\CourseSession;
use App\Repositories\BaseRepository;

/**
 * Class CourseSessionRepository
 * @package App\Repositories
 * @version January 7, 2024, 11:11 am +07
*/

class CourseSessionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'course_id',
        'day_of_week',
        'session'
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
        return CourseSession::class;
    }
}
