<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Student
 * @package App\Models
 * @version December 21, 2023, 3:24 pm UTC
 *
 * @property string $fullname
 * @property string $dob
 * @property string $phone_number
 * @property string $email
 * @property integer $level_id
 * @property string $school
 * @property string $parent_name
 * @property string $parent_phone1
 * @property string $parent_phone2
 * @property string $parent_mail
 * @property string $note
 * @property integer $user_id
 * @property integer $status
 */
class Student extends Model
{
    use SoftDeletes;


    public $table = 'students';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'fullname',
        'dob',
        'phone_number',
        'email',
        'level_id',
        'school',
        'parent_name',
        'parent_phone1',
        'parent_phone2',
        'parent_mail',
        'note',
        'user_id',
        'status',
        'code',
        'gender'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'fullname' => 'string',
        'dob' => 'date',
        'phone_number' => 'string',
        'email' => 'string',
        'level_id' => 'integer',
        'school' => 'string',
        'parent_name' => 'string',
        'parent_phone1' => 'string',
        'parent_phone2' => 'string',
        'parent_mail' => 'string',
        'note' => 'string',
        'user_id' => 'integer',
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
