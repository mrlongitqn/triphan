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
    public $table = 'marks';

    public $timestamps = false;
    public $fillable = [
        'course_student_id',
        'course_id',
        'student_id',
        'score1',
        'score2',
        'score3',
        'score4',
        'score5',
        'score6',
        'score7',
        'score8',
        'score9',
        'score10',
        'note',
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
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


}
