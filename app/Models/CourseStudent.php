<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class CourseStudent
 * @package App\Models
 * @version December 23, 2023, 4:22 am UTC
 *
 * @property integer $course_id
 * @property integer $student_id
 * @property integer $status
 */
class CourseStudent extends Model
{
    use SoftDeletes;


    public $table = 'course_students';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'course_id',
        'student_id',
        'status',
        'user_id',
        'note'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'course_id' => 'integer',
        'student_id' => 'integer',
        'status' => 'integer',
        'note'=>'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


}
