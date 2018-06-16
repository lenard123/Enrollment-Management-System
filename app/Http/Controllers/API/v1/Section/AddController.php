<?php

namespace App\Http\Controllers\API\v1\Section;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Section;

class AddController extends Controller
{
    public function __invoke(Request $request)
    {
    	$this->validateRequest($request);

    	$section = $this->insertSection($request);

    	return response()->json([
    		'status' => 'success',
    		'message' => 'Section added successfully.',
            'section' => $section
    	]);
    }

    private function insertSection($request)
    {
    	return Section::create($request->all());
    }

    private function validateRequest($request)
    {
    	$this->validate($request, [
    		'grade_id' => 'bail|required|exists:grades,id',
    		'name' => [
    			'required',
    			Rule::unique('sections')->where(function($query){
    				$query->where('grade_id', request('grade_id'));
    			})
    		],
    		'teacher' => 'required'
    	]);
    }
}
