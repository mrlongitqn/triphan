<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Refund
 * @package App\Models
 * @version January 25, 2024, 8:47 pm +07
 *
 * @property integer $user_id
 * @property string $fee_ids
 * @property string $reason
 * @property integer $total
 * @property integer $amount
 * @property integer $status
 */
class Refund extends Model
{
    use SoftDeletes;


    public $table = 'refunds';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'user_id',
        'fee_ids',
        'reason',
        'total',
        'amount',
        'status',
        'student_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'fee_ids' => 'string',
        'reason' => 'string',
        'total' => 'integer',
        'amount' => 'integer',
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
