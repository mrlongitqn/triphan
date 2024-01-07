<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class CourseSession
 * @package App\Models
 * @version January 7, 2024, 11:11 am +07
 *
 * @property integer $course_id
 * @property string $day_of_week
 * @property string $session
 */
class CourseSession extends Model
{
    use SoftDeletes;


    public $table = 'course_sessions';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'course_id',
        'day_of_week',
        'session'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'course_id' => 'integer',
        'day_of_week' => 'string',
        'session' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
