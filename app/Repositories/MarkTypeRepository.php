<?php

namespace App\Repositories;

use App\Models\MarkType;
use App\Repositories\BaseRepository;

/**
 * Class MarkTypeRepository
 * @package App\Repositories
 * @version March 10, 2024, 12:52 pm +07
*/

class MarkTypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'desc'
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
        return MarkType::class;
    }
}
