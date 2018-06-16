<?php

namespace App\Http\Controllers\API\v1\Grade;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Grade;
use App\GradeRequirement;

class AddController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->toArray($request);

    	$this->validateRequest($request);

    	$grade = $this->insertGrade($request);
        $grade->requirements;

    	return response()->json([
    		'status' => 'success',
    		'message' => 'Grade Added Successfully',
            'grade' => $grade
    	]);
    }

    private function insertGrade($request)
    {
    	$grade = Grade::create($request->all());
    	$this->insertRequirement($grade->id, $request->requirements);
        return $grade;
    }

    private function insertRequirement($id, $requirements)
    {
        $requirements = !is_null($requirements)?$requirements:[];
    	foreach ($requirements as $requirement_id) {
    		$grade_requirement['grade_id'] = $id;
    		$grade_requirement['requirement_id'] = $requirement_id;
    		GradeRequirement::create($grade_requirement);
    	}
    }

    private function validateRequest($request)
    {
    	$this->validate($request, [
    		'name' => 'required|unique:grades',
    		'requirements' => 'exists1:requirements,id'
    	]);
    }

    private function toArray($request)
    {
    	if (!is_array($request->requirements)) 
    		$request->requirements = json_decode($request->requirements);
    }
}
