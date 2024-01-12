<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Fee
 * @package App\Models
 * @version December 23, 2023, 4:25 am UTC
 *
 * @property integer $course_student_id
 * @property integer $course_id
 * @property integer $student_id
 * @property integer $fee
 * @property integer $amount
 * @property integer $remain
 * @property integer $status
 * @property integer $refund
 */
class Fee extends Model
{
    use SoftDeletes;


    public $table = 'fees';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'course_student_id',
        'course_id',
        'student_id',
        'total',
        'discount',
        'amount',
        'refund',
        'status',
        'refund',
        'fee_code',
        'note',
        'user_id',
        'payment_type'
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
        'fee' => 'integer',
        'amount' => 'integer',
        'remain' => 'integer',
        'status' => 'integer',
        'refund' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


}
