<?php

namespace App\Http\Controllers\API\v1\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;
use App\Grade;

class GetController extends Controller
{
    /**
     * Get All Students
     * 
     * @return {App\Student}
     */
    public function __invoke()
    {
    	return response()->json([
    		'student' => Student::paginate(10),
    		'grade' => Grade::all()
    	]);
    }

    /**
     * Get Enrolled Students
     * 
     * @return {App\Student}
     */
    public function enrolled()
    {
    	$student = Student::join('enroll_students', 'students.id', '=', 'enroll_students.student_id')
    					->select('students.*')
    					->whereNotNull('enroll_students.section_id')
    					->paginate(10);
    	return response()->json([
    		'student' => $student,
    		'grade' => Grade::all()
    	]);

    }

    /**
     * Get Pending Students
     * 
     * @return {App\Student}
     */
    public function pending()
    {
        $student = Student::leftJoin('enroll_students', 'students.id', '=', 'enroll_students.student_id')
                        ->select('students.*')
                        ->whereNull('enroll_students.section_id')
                        ->paginate(10);
        return response()->json([
            'student' => $student,
            'grade' => Grade::all()
        ]);
    }

    /**
     * Get Students by Section
     * @param {Int} $id
     * @return {App\Student}
     */
    public function section($id)
    {
        $student = Student::join('enroll_students', 'students.id', '=', 'enroll_students.student_id')
                        ->select('students.*')
                        ->where('enroll_students.section_id', $id)
                        ->paginate(10);
        return response()->json([
            'student' => $student,
            'grade' => Grade::all()
        ]);
    }
}
