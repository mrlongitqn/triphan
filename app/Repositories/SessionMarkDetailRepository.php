<?php

namespace App\Repositories;

use App\Models\SessionMarkDetail;
use App\Repositories\BaseRepository;

/**
 * Class SessionMarkDetailRepository
 * @package App\Repositories
 * @version January 27, 2024, 11:34 pm +07
*/

class SessionMarkDetailRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'session_mark_id',
        'course_id'
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
        return SessionMarkDetail::class;
    }
}
