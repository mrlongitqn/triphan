<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class MarkTypeDetail
 * @package App\Models
 * @version March 10, 2024, 12:55 pm +07
 *
 * @property integer $mark_type_id
 * @property integer $column_number
 * @property string $column_name
 */
class MarkTypeDetail extends Model
{


    public $table = 'mark_type_details';
    



    public $fillable = [
        'mark_type_id',
        'column_number',
        'column_name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'mark_type_id' => 'integer',
        'column_number' => 'integer',
        'column_name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
