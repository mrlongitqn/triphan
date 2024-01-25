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
        'status',
        'course_student_id'
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
        $data = $this->model->newQuery()->where('fee_details.course_student_id', '=',$id)
            ->leftJoin('fees','fees.id','=','fee_details.fee_id')
            ->where('fees.status','=',0)
            ->select('fee_details.*')
            ->orderBy('fee_details.id','desc')->first();
       return $data;
    }
}
