<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class SessionMark
 * @package App\Models
 * @version December 23, 2023, 4:30 am UTC
 *
 * @property string $session
 * @property string $start_date
 * @property string $end_date
 * @property string $desc
 * @property string $course_ids
 */
class SessionMark extends Model
{
    use SoftDeletes;


    public $table = 'session_marks';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'session',
        'start_date',
        'end_date',
        'desc',
        'course_ids',
        'user_id',
        'scores'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'session' => 'string',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'desc' => 'string',
        'course_ids' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'session'=> 'required',
    ];


}
