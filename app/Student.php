<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
    	'student_id',
    	'first_name',
    	'middle_name',
    	'last_name',
    	'address',
    	'phone',
    	'birthday',
    	'grade_id',
    	'gender'
    ];

    public function grade()
    {
        return $this->belongsTo('App\Grade');
    }

    public function enroll()
    {
        return $this->hasOne('App\EnrollStudent');
    }
}
