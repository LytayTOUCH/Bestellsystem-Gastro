<?php

namespace App\Http\Controllers\Verwaltung;

use App\Models\Helper\UserLogs;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use Artisan;
use Illuminate\Support\Facades\Auth;

class DatenController extends AuthController
{
    public function index() {
        UserLogs::create(Auth::id(), 'Verwaltung.Systemdaten.Dashboard', 'Hat die Bestätigungsseite für eine Systembereinigung anzeigen lassen');
        return view('verwaltung.daten.index');
    }

    public function bereinigen() {
    	Artisan::call('delete:bestelldaten');
        UserLogs::create(Auth::id(), 'Verwaltung.Systemdaten.Löschen', 'Hat eine Systembereinigung durchgeführt');
        return redirect()->back()->with('message', 'Systemdaten wurden bereinigt');
    }
}
