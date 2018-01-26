<?php

namespace App\Http\Controllers\Bestellungen;

use \App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use \App\Bestellung;
use \App\Kategorie;
use \App\Tisch;
use \App\Produkt;

class BestellungenController extends AuthController
{
    public function index() {
    	return view("bestellungen.index");
    }

    public function NeueBestellung() {
    	$kategorien = Kategorie::all();
        $tische = Tisch::all();
    	$selectedAuswahl = [];

    	foreach($kategorien as $kategorie) {
    		$produkte = Produkt::where('category', $kategorie->id)->get();
    		$selectedAuswahl[$kategorie->name] = ["id" => $kategorie->id, "name" => $kategorie->name, "produkte" => $produkte];
    	}

    	return view('bestellungen.bestellung', ['selectedCatsAndProds' => $selectedAuswahl, 'tische' => $tische]);
    	// Test zur korrekten Zuordnung des Arrays
    	# print_r($selectedAuswahl);
    }

    public function NeueBestellungSpeichern(Request $request) {
/*        echo $request->input('customerTable');
        echo "<br>";
        print_r($request->input('anzahl'));*/
        return redirect(route('Bestellungen'));
    }

    public function BestellungStornieren() {

    }

    public function BestellungErledigen($id)
    {
    	$selectedOrder = Bestellung::where('id', $id)->first();
    	if($selectedOrder->count() == 1) {
    		$selectedOrder->Erledigt = true;
    		$selectedOrder->save();
    	}

    	return redirect(route('Bestellungen'));
    }
}
