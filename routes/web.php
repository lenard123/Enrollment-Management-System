<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function(){
	return view('index');
});

Route::get('/test', function(){
	$student = \App\Student::find(2);
	$enroll = $student->enroll;
	$student->enroll ? $enroll->requirements: [];
	$student->enroll ? $enroll->section : [];

	return response()->json([
		'requirement' => \App\Requirement::all(),
		'section' => $student->grade->sections,
		'grade_requirement' => $student->grade->requirements,
		'enroll' => $enroll,
	]);
});