<?php

namespace App\Http\Controllers\API\v1\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;
use App\Grade;

class GetController extends Controller
{
    public function __invoke()
    {
    	return response()->json([
    		'student' => Student::paginate(15),
    		'grade' => Grade::all()
    	]);
    }
}
