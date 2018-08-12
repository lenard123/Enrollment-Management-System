<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function(){
	Route::post('admin/login', 'API\v1\Admin\LoginController');

	Route::middleware('auth:api')->group(function(){

		Route::get('admin/user', 'API\v1\Admin\GetController@show');

		Route::get('requirement', 'API\v1\Requirement\GetController');
		Route::post('requirement', 'API\v1\Requirement\AddController');
		Route::put('requirement/{id}', 'API\v1\Requirement\UpdateController');
		Route::delete('requirement/{id}', 'API\v1\Requirement\DeleteController');

		Route::get('grade', 'API\v1\Grade\GetController');
		Route::post('grade', 'API\v1\Grade\AddController');
		Route::put('grade/{id}', 'API\v1\Grade\UpdateController');
		Route::delete('grade/{id}', 'API\v1\Grade\DeleteController');

		Route::get('section', 'API\v1\Section\GetController');
		Route::post('section', 'API\v1\Section\AddController');
		Route::put('section/{id}', 'API\v1\Section\UpdateController');
		Route::delete('section/{id}', 'API\v1\Section\DeleteController');

		Route::get('student', 'API\v1\Student\GetController');
		Route::get('student/enrolled', 'API\v1\Student\GetController@enrolled');
		Route::get('student/pending', 'API\v1\Student\GetController@pending');
		Route::get('student/section/{id}', 'API\v1\Student\GetController@section');
		
		Route::get('student/{id}', 'API\v1\Student\ShowController');
		Route::post('student', 'API\v1\Student\AddController');
		Route::post('student/{id}/enroll', 'API\v1\Student\EnrollController');
		Route::put('student/{id}', 'API\v1\Student\UpdateController');
		Route::delete('student/{id}', 'API\v1\Student\DeleteController');	
	});

});
