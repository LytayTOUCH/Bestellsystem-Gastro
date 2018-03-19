<?php

namespace App\Http\Controllers\Verwaltung;

use App\Http\Controllers\AuthController;
use App\Models\Helper\UserLogs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class VerwaltungController extends AuthController
{
    public function index() {
        UserLogs::create(Auth::id(), 'Verwaltung.Dashboard', 'Hat die Übersichtsseite der Verwaltung aufgerufen');

        return view("verwaltung.index");
    }
}
