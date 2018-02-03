<?php

namespace App\Http\Controllers\Verwaltung;

use App\Http\Controllers\AuthController;
use App\Http\Requests\NutzerSpeichern;
use Illuminate\Support\Facades\Hash;
use App\User;
use Auth;

class NutzerController extends AuthController
{
    public function index() {
    	$nutzer = User::where([
    		["id", "!=", 1],
    		["id", "!=", Auth::user()->id]
    	])->get();
    	return view('verwaltung.nutzer.index', ['nutzer' => $nutzer]);
    }

    public function erstellen() {
    	return view('verwaltung.nutzer.verwalten', ['newDataSet' => true]);
    }    

    public function erstellenSpeichern(NutzerSpeichern $request) {
    	$user = new User;
    	// $request->input('UserActive');
    	$user->name = $request->input('name');
    	$user->email = $request->input('email');
    	$user->password = Hash::make($request->input('password'));
    	$user->save();
    	return redirect(route("Verwaltung.Nutzer"))->with('message', 'Der Benutzer wurde gespeichert');
    }

    public function bearbeiten($id) {
    	$user = User::find($id);
    	if($user !== null) {
    		return view('verwaltung.nutzer.verwalten', ['newDataSet' => false, 'user' => $user]);
    	}

    	return redirect(route("Verwaltung.Nutzer"));
    }   

    public function bearbeitenSpeichern(NutzerSpeichern $request, $id) {
    	$user = User::find($id);
    	if($user !== null) {
	    	$user->name = $request->input('name');
	    	$user->email = $request->input('email');

	    	// Passwort nur aktualisieren, sofern eine Eingabe vorhanden ist
	    	if($request->input('password') != "") {
		    	$user->password = Hash::make($request->input('password'));
		    }

	    	$user->save();

    		return redirect(route("Verwaltung.Nutzer"))->with('message', 'Der Benutzer wurde erfolgreich bearbeitet');
    	}

    	return redirect(route("Verwaltung.Nutzer"));
    }

    public function entfernen($id) {
    	$user = User::find($id);
    	if($user !== null && $id!=Auth::user()->id) {
    		$user->delete();
    	} else {
    		return redirect(route("Verwaltung.Nutzer"))->with('error_message', 'Der Benutzer kann nicht gelöscht werden!');
    	}

    	return redirect(route("Verwaltung.Nutzer"))->with('message', 'Der Benutzer wurde gelöscht!');
    }
}
