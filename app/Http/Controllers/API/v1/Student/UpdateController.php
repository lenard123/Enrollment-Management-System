<?php

namespace App\Http\Controllers\API\v1\Student;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Student;

class UpdateController extends Controller
{
    public function __invoke(Request $request, $id)
    {
    	$this->validateRequest($request, $id);

    	$this->updateStudent($request, $id);

    	return response()->json([
    		'status' => 'success',
    		'message' => 'Student updated successfully.',
            'student' => Student::find($id)
    	]);
    }

    private function updateStudent($request, $id)
    {
    	Student::find($id)->update($request->all());
    }

    private function validateRequest($request, $id)
    {
    	$this->validate($request,[
    		'student_id' => ['required', Rule::unique('students')->ignore($id)],
    		'first_name' => 'required',
    		'last_name' => 'required',
    		'birthday' => 'required|date|age',
    		'phone' => 'nullable|digits:11',
    		'gender' => 'required|gender',
    		'grade_id' => 'required|exists:grades,id'
    	]);
    }
}
