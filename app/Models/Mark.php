<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Mark
 * @package App\Models
 * @version December 23, 2023, 4:27 am UTC
 *
 * @property integer $course_student_id
 * @property integer $course_id
 * @property integer $student_id
 * @property number $score
 * @property integer $status
 * @property integer $session_id
 */
class Mark extends Model
{
    use SoftDeletes;


    public $table = 'marks';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'course_student_id',
        'course_id',
        'student_id',
        'score',
        'status',
        'session_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'course_student_id' => 'integer',
        'course_id' => 'integer',
        'student_id' => 'integer',
        'score' => 'decimal:2',
        'status' => 'integer',
        'session_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
