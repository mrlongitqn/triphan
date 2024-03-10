<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class MarkType
 * @package App\Models
 * @version March 10, 2024, 12:52 pm +07
 *
 * @property string $name
 * @property string $desc
 */
class MarkType extends Model
{
    use SoftDeletes;


    public $table = 'mark_types';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'desc'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'desc' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
