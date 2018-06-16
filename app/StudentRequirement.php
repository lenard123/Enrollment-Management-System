<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentRequirement extends Model
{
    protected $fillable = ['enroll_student_id', 'requirement_id'];

    protected $hidden = ['created_at', 'updated_at'];

    public function requirement()
    {
    	return $this->belongsTo('App\Requirement');
    }
}
