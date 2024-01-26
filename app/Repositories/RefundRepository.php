<?php

namespace App\Repositories;

use App\Models\Refund;
use App\Repositories\BaseRepository;

/**
 * Class RefundRepository
 * @package App\Repositories
 * @version January 25, 2024, 8:47 pm +07
*/

class RefundRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'reason',
        'total',
        'amount',
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
        return Refund::class;
    }
}
