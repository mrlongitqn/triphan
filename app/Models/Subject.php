<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Subject
 * @package App\Models
 * @version December 21, 2023, 2:07 pm UTC
 *
 * @property string $subject
 * @property string $desc
 */
class Subject extends Model
{
    use SoftDeletes;


    public $table = 'subjects';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'subject',
        'desc'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'subject' => 'string',
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
