<?php

namespace App\Http\Controllers\API\v1\Grade;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Grade;
use App\Requirement;

class GetController extends Controller
{
	public function __invoke(){
    	$grades = Grade::all();
    	$requirements = Requirement::all();
    	
    	foreach ($grades as $key => $grade) 
    		foreach ($grade->requirements as $key1 => $requirement) 
    			$requirement->requirement;   

	    return response()->json([
	    	'grade' => $grades,
	    	'requirement' => $requirements
	    ]);
	}
}
