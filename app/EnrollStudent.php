<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnrollStudent extends Model
{
    protected $fillable = ['student_id', 'section_id'];

    public function requirements()
    {
    	return $this->hasMany('App\StudentRequirement');
    }

    public function section()
    {
    	return $this->belongsTo('App\Section');
    }
}
