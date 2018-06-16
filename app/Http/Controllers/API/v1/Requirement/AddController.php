<?php

namespace App\Http\Controllers\API\v1\Requirement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Requirement;

class AddController extends Controller
{
    public function __invoke(Request $request)
    {
    	$this->validateRequest($request);

    	$requirement = $this->insertRequirement($request);

    	return response()->json([
    		'status' => 'success',
    		'message' => 'Requirement added successfully',
            'requirement' => $requirement
    	]);
    }

    private function insertRequirement($request)
    {
    	return Requirement::create($request->all());
    }

    private function validateRequest($request)
    {
    	$this->validate($request, [
    		'name' => 'required|unique:requirements'
    	]);
    }
}
