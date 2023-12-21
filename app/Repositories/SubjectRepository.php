<?php

namespace App\Repositories;

use App\Models\Subject;
use App\Repositories\BaseRepository;

/**
 * Class SubjectRepository
 * @package App\Repositories
 * @version December 21, 2023, 2:07 pm UTC
*/

class SubjectRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'subject',
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
        return Subject::class;
    }
}
