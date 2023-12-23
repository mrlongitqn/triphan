<?php

namespace App\Repositories;

use App\Models\Student;
use App\Repositories\BaseRepository;

/**
 * Class StudentRepository
 * @package App\Repositories
 * @version December 21, 2023, 3:24 pm UTC
*/

class StudentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'code',
        'fullname',
        'phone_number',
        'email',
        'school',
        'parent_name',
        'parent_phone1',
        'parent_phone2',
        'parent_mail',
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
        return Student::class;
    }

    public function getByIds($ids){
        return $this->model->newQuery()->whereIn('id', $ids)->get();
    }

    public function search($keyword, $limit=15){

        return $this->model->newQuery()->orWhere( 'fullname','like', $keyword)
            ->orWhere('code', 'like', $keyword)
            ->orWhere('parent_name', 'like', $keyword)
            ->orWhere('phone_number', 'like', $keyword)
            ->orWhere('parent_phone1', 'like', $keyword)
            ->orWhere('parent_phone2', 'like', $keyword)->limit($limit);
    }
}
