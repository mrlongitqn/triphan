<?php

namespace App\Repositories;

use App\Models\MarkTypeDetail;
use App\Repositories\BaseRepository;

/**
 * Class MarkTypeDetailRepository
 * @package App\Repositories
 * @version March 10, 2024, 12:55 pm +07
*/

class MarkTypeDetailRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'mark_type_id',
        'column_number',
        'column_name'
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
        return MarkTypeDetail::class;
    }
}
