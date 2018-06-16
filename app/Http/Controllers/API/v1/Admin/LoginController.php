<?php

namespace App\Http\Controllers\API\v1\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
    	$this->validateRequest($request);

    	$result = $this->getResult($request);

    	return response()->json($this->getResult($request));
    }

    private function getResult($request)
    {
    	if ($this->chkLogin($request)) {
    		$user = $request->user();
    		$result = [
    			'status' => 'success',
    			'message' => 'Login Successfully',
    			'user' => $user,
    			'ACCESS_TOKEN' => $user->createToken('MyApp')->accessToken
    		];
    	} else {
    		$result = [
    			'status' => 'failed',
    			'message' => 'Wrong username or password.'
    		];
    	}

    	return $result;
    }

    private function chkLogin($request)
    {
    	return Auth::attempt([
    		'username' => $request->username,
    		'password' => $request->password
    	]);
    }

    private function validateRequest($request)
    {
    	$this->validate($request, [
    		'username' => 'required',
    		'password' => 'required'
    	]);
    }
}
