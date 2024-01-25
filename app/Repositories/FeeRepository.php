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
        'fees.code',
        'students.fullname',
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
        return Fee::class;
    }

    public function allFeesByCourseStudent($id){
        return $this->all(['
        course_student_id'=>$id])->get()->orderBy('id','desc');
    }
    public function getByCode($code){
        return $this->allQuery()->firstOrCreate(['fee_code'=>$code]);
    }
    public function byStudent($id){
        $query = $this->model->newQuery();
        $result = $query->leftJoin('courses', 'courses.id','=','course_id')
            ->leftJoin('users', 'users.id','=','fees.user_id')
            ->where('student_id','=', $id)
            ->where('fees.status',0)
            ->orderByDesc('id')->take(5)->select('fees.*','course', 'name');
        return $result->get();
    }

}
