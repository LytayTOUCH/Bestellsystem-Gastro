<?php

namespace App\Http\Controllers\Verwaltung;
use App\Http\Controllers\AuthController;

use Illuminate\Http\Request;

class EntwicklerController extends AuthController
{
    public function index() {
    	return view("verwaltung.entwickler.index");
    }
}
