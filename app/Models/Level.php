<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Level
 * @package App\Models
 * @version December 21, 2023, 2:49 pm UTC
 *
 * @property string $level
 * @property string $desc
 */
class Level extends Model
{
    use SoftDeletes;


    public $table = 'levels';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'level',
        'desc'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'level' => 'string',
        'desc' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'level' => 'required',
        'desc' => ''
    ];


}
