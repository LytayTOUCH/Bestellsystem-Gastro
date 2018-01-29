<?php

namespace App\Http\Controllers\Verwaltung;

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use Artisan;

class DatenController extends AuthController
{
    public function index() {
    	return view('verwaltung.daten.index');
    }

    public function bereinigen() {
    	Artisan::call('delete:bestelldaten');
        return redirect()->back()->with('message', 'Systemdaten wurden bereinigt');
    }
}
