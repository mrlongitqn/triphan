<?php

namespace App\Repositories;

use App\Models\Mark;
use App\Repositories\BaseRepository;

/**
 * Class MarkRepository
 * @package App\Repositories
 * @version December 23, 2023, 4:27 am UTC
*/

class MarkRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'course_student_id',
        'course_id',
        'student_id',
        'score',
        'status',
        'session_id'
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
        return Mark::class;
    }
}
