<?php

namespace App\Http\Controllers\Verwaltung;

use App\Http\Controllers\AuthController;
use App\Http\Requests\NutzerSpeichern;
use App\Models\Helper\UserLogs;
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
        UserLogs::create(Auth::id(), 'Verwaltung.Nutzer.Dashboard', 'Hat sich alle Benutzer anzeigen lassen');

        return view('verwaltung.nutzer.index', ['nutzer' => $nutzer]);
    }

    public function erstellen() {
        UserLogs::create(Auth::id(), 'Verwaltung.Nutzer.Erstellen', 'Hat das Formular für die Erstellung eines Benutzer geöffnet');
        return view('verwaltung.nutzer.verwalten', ['newDataSet' => true]);
    }    

    public function erstellenSpeichern(NutzerSpeichern $request) {
    	$user = new User;
    	// $request->input('UserActive');
    	$user->name = $request->input('name');
    	$user->email = $request->input('email');
    	$user->password = Hash::make($request->input('password'));
    	$user->save();

        UserLogs::create(Auth::id(), 'Verwaltung.Nutzer.Erstellen.Speichern', 'Hat den Benutzer "'.$user->name.'" mit der ID '.$user->id.' erstellt');

        return redirect(route("Verwaltung.Nutzer"))->with('message', 'Der Benutzer wurde gespeichert');
    }

    public function bearbeiten($id) {
    	$user = User::find($id);
    	if($user !== null) {
    		return view('verwaltung.nutzer.verwalten', ['newDataSet' => false, 'user' => $user]);
    	}

        UserLogs::create(Auth::id(), 'Verwaltung.Nutzer.Bearbeiten', 'Hat den Benutzer "'.$user->name.'" mit der ID '.$user->id.' in der Bearbeitung geöffnet');

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
            UserLogs::create(Auth::id(), 'Verwaltung.Nutzer.Bearbeiten.Speichern', 'Hat den Benutzer "'.$user->name.'" mit der ID '.$user->id.' bearbeitet');

	    	$user->save();

    		return redirect(route("Verwaltung.Nutzer"))->with('message', 'Der Benutzer wurde erfolgreich bearbeitet');
    	}

    	return redirect(route("Verwaltung.Nutzer"));
    }

    public function entfernen($id) {
    	$user = User::find($id);
    	if($user !== null && $id!=Auth::user()->id) {
            UserLogs::create(Auth::id(), 'Verwaltung.Nutzer.Entfernen', 'Hat den Benutzer "'.$user->name.'" mit der ID '.$user->id.' gelöscht');
            $user->delete();
    	} else {
    		return redirect(route("Verwaltung.Nutzer"))->with('error_message', 'Der Benutzer kann nicht gelöscht werden!');
    	}

    	return redirect(route("Verwaltung.Nutzer"))->with('message', 'Der Benutzer wurde gelöscht!');
    }
}
