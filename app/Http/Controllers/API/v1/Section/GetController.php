<?php

namespace App\Http\Controllers\API\v1\Section;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Grade;
use App\Section;

class GetController extends Controller
{
    public function __invoke()
    {
    	//return GetController::getSections();
        return response()->json([
            'section' => Section::all(),
            'grade' => Grade::all()
        ]);
    }

    public static function getSections()
    {
    	$grades = Grade::all();
    	foreach ($grades as $key => $grade) 
    		$grade->sections;
    	return $grades;    	
    }
}
