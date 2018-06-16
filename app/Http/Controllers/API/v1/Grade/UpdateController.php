<?php

namespace App\Http\Controllers\API\v1\Grade;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\Grade;
use App\GradeRequirement;

class UpdateController extends Controller
{
    public function __invoke(Request $request, $id)
    {
    	$this->toArray($request);

    	$this->validateRequest($request, $id);

    	$this->updateGrade($request, $id);

        $grade = Grade::find($id);
        $grade->requirements;

    	return response()->json([
    		'status' => 'success',
    		'message' => 'Grade updated successfully.',
            'grade' => $grade
    	]);
    }

    private function updateGrade($request, $id)
    {
    	Grade::find($id)->update($request->all());
    	$this->updateRequirements($request->requirements, $id);
    }

    private function updateRequirements($requirements, $id)
    {
    	GradeRequirement::where('grade_id', $id)->delete();
    	foreach ($requirements as $requirement_id) {
    		$grade_requirement['grade_id'] = $id;
    		$grade_requirement['requirement_id'] = $requirement_id;
    		GradeRequirement::create($grade_requirement);
    	}    	
    }

    private function validateRequest($request, $id)
    {
    	$this->validate($request, [
    		'name' => ['required', Rule::unique('grades')->ignore($id)],
    		'requirements' => 'exists1:requirements,id'
    	]);
    }

    private function toArray($request)
    {
    	if (!is_array($request->requirements)) 
    		$request->requirements = json_decode($request->requirements);
    }
}
