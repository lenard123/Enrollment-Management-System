<?php

namespace App\Http\Controllers\API\v1\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;

class DeleteController extends Controller
{
    public function __invoke($id)
    {
    	Student::destroy($id);

    	return response()->json([
    		'status' => 'success',
    		'message' => 'Student deleted successfully'
    	]);
    }
}
