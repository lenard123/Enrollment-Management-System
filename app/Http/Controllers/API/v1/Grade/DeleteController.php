<?php

namespace App\Http\Controllers\API\v1\Grade;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Grade;

class DeleteController extends Controller
{
    public function __invoke($id)
    {
    	Grade::destroy($id);
    	return response()->json([
    		'status' => 'success',
    		'message' => 'Grade deleted successfully.'
    	]);
    }
}
