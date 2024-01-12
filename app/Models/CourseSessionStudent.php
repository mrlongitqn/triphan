<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class CourseSessionStudent
 * @package App\Models
 * @version January 7, 2024, 11:15 am +07
 *
 * @property integer $course_id
 * @property integer $session_id
 * @property integer $student_id
 */
class CourseSessionStudent extends Model
{
    use SoftDeletes;


    public $table = 'course_session_students';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'course_id',
        'session_id',
        'student_id',
        'course_student_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'course_id' => 'integer',
        'session_id' => 'integer',
        'student_id' => 'integer',
        'course_student_id'=>'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


}
