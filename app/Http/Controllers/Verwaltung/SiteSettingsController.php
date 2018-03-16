<?php

namespace App\Http\Controllers\Verwaltung;

use App\Http\Controllers\AuthController;
use App\Http\Requests\SeitenEinstellungenSpeichern;
use App\Models\SiteSettings;

class SiteSettingsController extends AuthController
{
    public function index() {
    	$settings = SiteSettings::first();
    	return view('verwaltung.site.index', ['setting'=>$settings]);
    }

    public function EinstellungenSpeichern(SeitenEinstellungenSpeichern $request) {
    	$settings = SiteSettings::first();
    	$settings->site_name = $request->input('site_name');
    	$settings->site_template = $request->input('site_template');
    	$settings->save();
    	return redirect(route('Verwaltung.Seite'))->with('message', 'Einstellungen erfolgreich gespeichert');
    }
}
