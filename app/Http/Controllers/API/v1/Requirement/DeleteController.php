<?php

namespace App\Http\Controllers\API\v1\Requirement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Requirement;

class DeleteController extends Controller
{
    public function __invoke($id)
    {
    	Requirement::destroy($id);

    	return response()->json([
    		'status' => 'success',
    		'message' => 'Requirement deleted successfully'
    	]);
    }
}
