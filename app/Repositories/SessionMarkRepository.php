<?php

namespace App\Repositories;

use App\Models\SessionMark;
use App\Repositories\BaseRepository;

/**
 * Class SessionMarkRepository
 * @package App\Repositories
 * @version December 23, 2023, 4:30 am UTC
*/

class SessionMarkRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'session',
        'start_date',
        'end_date',
        'desc',
        'course_ids'
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
        return SessionMark::class;
    }
}
