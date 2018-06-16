<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = ['name'];
    protected $hidden = ['created_at', 'updated_at'];

    public function requirements()
    {
    	return $this->hasMany('App\GradeRequirement');
    }

    public function sections()
    {
    	return $this->hasMany('App\Section');
    }
}
