<?php

namespace App\Http\Controllers\Verwaltung;

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use App\Http\Requests\TischSpeichern;
use App\Tisch;

class TischController extends AuthController
{
    public function index()
    {
    	$tische = Tisch::all();

    	return view('verwaltung.tische.index', ['tische' => $tische]);
    }

    public function erstellen() {
    	return view('verwaltung.tische.erstellen');
    }


    public function erstellenSpeichern(TischSpeichern $request) {
    	$tisch = new Tisch;
    	$tisch->Name = $request->input('Name');
    	$tisch->save();

    	return redirect(route('Verwaltung.Tische'));
    }

    public function reset($id) {
    	$tisch = Tisch::find($id);
    	if($tisch !== null) {
    		$tisch->Besetzt = false;
    		$tisch->save();
    	}

    	return redirect(route('Verwaltung.Tische'))->with('message', "Der Tisch wurde zurückgesetzt");
    }

    public function reset_all() {
    	Tisch::where('Besetzt', true)->update([
    		'Besetzt' => false,
    	]);

    	return redirect(route('Verwaltung.Tische'))->with('message', "Alle Tische wurden zurückgesetzt");
    }

    public function entfernen($id) {
    	$tisch = Tisch::find($id);
    	if($tisch !== null) {
    		$tisch->delete();
    	}

    	return redirect(route('Verwaltung.Tische'));
    }
}
