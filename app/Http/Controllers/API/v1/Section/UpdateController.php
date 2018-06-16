<?php

namespace App\Http\Controllers\API\v1\Section;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Section;

class UpdateController extends Controller
{
    public function __invoke(Request $request, $id)
    {
    	$request->grade_id = Section::find($id)->grade_id;
    	$this->validateRequest($request, $id);
    	$this->updateSection($request, $id);
    	return response()->json([
    		'status' => 'success',
    		'message' => 'Section updated successfully.',
            'section' => Section::find($id)
    	]);	
    }

    private function updateSection($request, $id)
    {
    	Section::find($id)->update($request->all());
    }

    private function validateRequest($request, $id)
    {
    	$this->validate($request, [
    		
    		'teacher' => 'required',

    		'name' => [
    			'required',
    			Rule::unique('sections')->ignore($id)->where(function($query){
    				$query->where('grade_id', request('grade_id'));
    			})
    		]
    	]);
    }
}
