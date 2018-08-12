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

		$enroll = $student->enroll ? $student->enroll : [];
		$sections = $student->grade->sections;
		$grade_requirements = $student->grade->requirements;
		$student_requirements = $student->enroll ? $student->enroll->requirements : [];

		return response()->json([
			'requirement' => Requirement::all(),
			'section' => $sections,
			'grade_requirement' => $grade_requirements,
			'student_requirements' => $student_requirements,
			'enroll' => $enroll,
		]);
    }
}
