<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GradeRequirement extends Model
{
    protected $fillable = ['requirement_id', 'grade_id'];

    protected $hidden = ['created_at', 'updated_at'];

    public function requirement()
    {
    	return $this->belongsTo('App\Requirement');
    }
}
