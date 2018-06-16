<?php

namespace App\Http\Controllers\API\v1\Section;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Section;

class DeleteController extends Controller
{
    public function __invoke($id)
    {
    	Section::destroy($id);
    	return response()->json([
    		'status'=>'success',
    		'message'=>'Section deleted successfully.'
    	]);
    }
}
