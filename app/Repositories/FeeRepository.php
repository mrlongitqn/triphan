<?php

namespace App\Repositories;

use App\Models\Fee;
use App\Repositories\BaseRepository;

/**
 * Class FeeRepository
 * @package App\Repositories
 * @version December 23, 2023, 4:25 am UTC
*/

class FeeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'course_student_id',
        'course_id',
        'student_id',
        'fee',
        'amount',
        'remain',
        'status',
        'refund'
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
        return Fee::class;
    }
}
