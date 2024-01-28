<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class SessionMarkDetail
 * @package App\Models
 * @version January 27, 2024, 11:34 pm +07
 *
 * @property integer $session_mark_id
 * @property integer $course_id
 */
class SessionMarkDetail extends Model
{


    public $table = 'session_mark_details';

    public $timestamps = false;


    public $fillable = [
        'session_mark_id',
        'course_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'session_mark_id' => 'integer',
        'course_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


}
