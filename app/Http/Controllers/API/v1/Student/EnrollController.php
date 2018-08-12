<?php

namespace App\Http\Controllers\API\v1\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\EnrollStudent;
use App\StudentRequirement;
use App\Student;

class EnrollController extends Controller
{
    public function __invoke(Request $request, $id)
    {

    	$request->requirements = $this->getRequirements($request); 

    	$es = EnrollStudent::firstOrCreate(['student_id'=>$id]);

    	$this->insertRequirement($request, $es);

    	if ($this->chkRequirements($es)) {
            $es->section_id = $request->section_id == 0 ? null : $request->section_id;
            $es->save();
        }

    	return response()->json([
    		'status' => 'success',
    		'message' => 'Success.',
            'test' => $this->chkRequirements($es)
    	]);
    }

    private function chkRequirements($enroll_student)
    {
    	$student_id = $enroll_student->student_id;
    	$grade_requirements = Student::find($student_id)->grade->requirements;
    	$student_requirements = StudentRequirement::where('enroll_student_id', $enroll_student->id)->get();

    	foreach ($grade_requirements as $key => $gr) {
    		$hasRequirement = false;
    		foreach ($student_requirements as $keys => $sr) 
    			if ($gr->requirement_id == $sr->requirement_id) $hasRequirement = true;
    		if (!$hasRequirement) return false;
    	}

    	return true;
    }

    private function getRequirements($request)
    {
    	$requirements = $request->requirements;
    	if (is_null($requirements))
    		return [];
    	elseif (!is_array($requirements))
    		return json_decode($requirements);
    	else
    		return $requirements;
    }

    private function insertRequirement($request, $es)
    {
    	StudentRequirement::where('enroll_student_id', $es->id)->delete();
    	foreach ($request->requirements as $key => $requirement) {
    		$student_requirement['enroll_student_id'] = $es->id;
    		$student_requirement['requirement_id'] = $requirement;
    		StudentRequirement::create($student_requirement);
    	}
    }
}
