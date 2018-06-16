<?php

namespace App\Http\Controllers\API\v1\Requirement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Requirement;

class GetController extends Controller
{
    public function __invoke()
    {
    	return Requirement::all();
    }
}
