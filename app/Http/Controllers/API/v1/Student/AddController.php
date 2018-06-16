<?php

namespace App\Http\Controllers\API\v1\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;

class AddController extends Controller
{
    public function __invoke(Request $request)
    {
    	$this->validateRequest($request);

    	$student = $this->insertStudent($request);

    	return response()->json([
    		'status' => 'success',
    		'message' => 'Student added successfully.',
            'student' => $student
    	]);
    }

    private function insertStudent($request)
    {
    	return Student::create($request->all());
    }

    private function validateRequest($request)
    {
    	$this->validate($request, [
    		'student_id' => 'required|unique:students',
    		'first_name' => 'required',
    		'last_name' => 'required',
    		'birthday' => 'required|date|age',
    		'phone' => 'nullable|digits:11',
    		'gender' => 'required|gender',
    		'grade_id' => 'required|exists:grades,id'
    	]);
    }
}
