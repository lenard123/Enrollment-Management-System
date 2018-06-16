<?php

namespace App\Http\Controllers\API\v1\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;
use App\Requirement;

class ShowController extends Controller
{
    public function __invoke($id)
    {
		$student = Student::find($id);
		$enroll = $student->enroll;
		$student->enroll ? $enroll->requirements: [];
		$student->enroll ? $enroll->section : [];

		return response()->json([
			'requirement' => Requirement::all(),
			'section' => $student->grade->sections,
			'grade_requirement' => $student->grade->requirements,
			'enroll' => $enroll,
		]);
    }
}
