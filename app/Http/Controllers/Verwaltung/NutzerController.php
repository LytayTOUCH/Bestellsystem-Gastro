<?php

namespace App\Http\Controllers\Verwaltung;

use App\Http\Controllers\AuthController;
use App\Http\Requests\NutzerSpeichern;
use Illuminate\Support\Facades\Hash;
use App\User;

class NutzerController extends AuthController
{
    public function index() {
    	$nutzer = User::where("id", "!=", 1)->get();
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

    }   

    public function bearbeitenSpeichern($id) {

    }

    public function entfernen($id) {
    	$user = User::find($id);
    	if($user !== null) {
    		$user->delete();
    	}

    	return redirect(route("Verwaltung.Nutzer"))->with('message', 'Der Benutzer wurde gelöscht!');
    }
}
