<?php

namespace App\Http\Controllers\Verwaltung;

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;

class VerwaltungController extends AuthController
{
    public function index() {
    	return view("verwaltung.index");
    }
}
