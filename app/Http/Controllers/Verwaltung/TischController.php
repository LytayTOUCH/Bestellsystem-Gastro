<?php

namespace App\Http\Controllers\Verwaltung;

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;

class TischController extends AuthController
{
    public function index()
    {
    	return view('verwaltung.tische.index');
    }
}
