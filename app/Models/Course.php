<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Course
 * @package App\Models
 * @version December 21, 2023, 3:06 pm UTC
 *
 * @property string $course
 * @property integer $fee
 * @property integer $level_id
 * @property integer $subject_id
 * @property string $teacher
 * @property string $start_date
 * @property string $end_date
 * @property integer $status
 * @property integer $user_id
 */
class Course extends Model
{
    use SoftDeletes;


    public $table = 'courses';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'course',
        'fee',
        'level_id',
        'subject_id',
        'teacher',
        'start_date',
        'end_date',
        'status',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'course' => 'string',
        'fee' => 'integer',
        'level_id' => 'integer',
        'subject_id' => 'integer',
        'teacher' => 'string',
        'start_date' => 'date',
        'end_date' => 'date',
        'status' => 'integer',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
