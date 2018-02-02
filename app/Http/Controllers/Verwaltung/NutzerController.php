<?php

namespace App\Http\Controllers\Verwaltung;

use App\Http\Controllers\AuthController;
use App\Http\Requests\NutzerSpeichern;

class NutzerController extends AuthController
{
    public function index() {
    	$nutzer = [];
    	return view('verwaltung.nutzer.index', ['nutzer' => $nutzer]);
    }

    public function erstellen() {
    	return view('verwaltung.nutzer.verwalten');
    }    

    public function erstellenSpeichern(NutzerSpeichern $request) {
    	echo $request->input('FullName');
    }

    public function bearbeiten($id) {

    }   

    public function bearbeitenSpeichern($id) {

    }

    public function toggleSperre($id) {

    }

    public function entfernen($id) {

    }
}
