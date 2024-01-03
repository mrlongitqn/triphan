<?php

namespace App\Repositories;

use App\Models\FeeDetail;
use App\Repositories\BaseRepository;

/**
 * Class FeeDetailRepository
 * @package App\Repositories
 * @version January 3, 2024, 2:58 pm UTC
*/

class FeeDetailRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'origin',
        'amount',
        'remain',
        'month',
        'year',
        'note',
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
        return FeeDetail::class;
    }
    public function lastMonthPayByCourseStudent($id){
        return $this->model->newQuery()->where('course_student_id', '=',$id)->orderBy('id','desc')->first();
    }
}
