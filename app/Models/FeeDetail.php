<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class FeeDetail
 * @package App\Models
 * @version January 3, 2024, 2:58 pm UTC
 *
 * @property integer $origin
 * @property integer $amount
 * @property integer $remain
 * @property integer $month
 * @property integer $year
 * @property string $note
 * @property integer $status
 */
class FeeDetail extends Model
{
    use SoftDeletes;


    public $table = 'fee_details';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'origin',
        'amount',
        'remain',
        'month',
        'year',
        'note',
        'status',
        'course_student_id',
        'fee_id'
    ];
    public $timestamps = false;
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'origin' => 'integer',
        'amount' => 'integer',
        'remain' => 'integer',
        'month' => 'integer',
        'year' => 'integer',
        'note' => 'string',
        'status' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


}
