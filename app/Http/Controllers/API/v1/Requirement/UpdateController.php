<?php

namespace App\Http\Controllers\API\v1\Requirement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\Requirement;

class UpdateController extends Controller
{
    public function __invoke(Request $request, $id)
    {
    	$this->validateRequest($request, $id);

    	$this->updateRequirement($request, $id);

    	return response()->json([
    		'status' => 'success',
    		'message' => 'Requirement updated successfully',
            'requirement' => Requirement::find($id)
    	]);
    }

    private function updateRequirement($request, $id)
    {
    	Requirement::find($id)->update($request->all());
    }

    private function validateRequest($request, $id)
    {
    	$this->validate($request, [
    		'name' => ['required', Rule::unique('requirements')->ignore($id)]
    	]);
    }
}
