<?php

namespace App\Http\Controllers\Verwaltung;

use App\Http\Controllers\AuthController;
use App\Http\Requests\SeitenEinstellungenSpeichern;
use App\Models\Helper\UserLogs;
use App\Models\SiteSettings;
use Illuminate\Support\Facades\Auth;

class SiteSettingsController extends AuthController
{
    public function index() {
    	$settings = SiteSettings::first();
        UserLogs::create(Auth::id(), 'Verwaltung.Seite.Dashboard', 'Hat die Seiteneinstellungen anzeigen lassen');
        return view('verwaltung.site.index', ['setting'=>$settings]);
    }

    public function EinstellungenSpeichern(SeitenEinstellungenSpeichern $request) {
    	$settings = SiteSettings::first();
    	$settings->site_name = $request->input('site_name');
    	$settings->site_template = $request->input('site_template');
        
        if($request->input('module_warenwirtschaft') == null) {
            $settings->module_warenwirtschaft = false;
        } else {
            $settings->module_warenwirtschaft = true;
        }

        if($request->input('module_logging') == null) {
            $settings->module_logging = false;
        } else {
            $settings->module_logging = true;
        }

        UserLogs::create(Auth::id(), 'Verwaltung.Seite.Speichern', 'Hat die Seiteneinstellungen bearbeitet');
        $settings->save();

        return redirect(route('Verwaltung.Seite'))->with('message', 'Einstellungen erfolgreich gespeichert');
    }
}
