<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Bestellung extends Controller
{
	// POST, Neue Bestellung erstellen (Erfordert Auth-Token)
    public function Erstellen(Request $request) {
    	$produkte = [];
    	$tisch = null;
    	$bestellung = null;

    	/*
        $client = new Client(new Version2X(config('app.node_addr'), []));
        $client->initialize();
        $client->emit('order created', [
            'id' => $bestellung->id,
            'table' => [
                'id' => $tisch->id,
                'name' => $tisch->Name,
            ],
            'produkte' => $produkte
        ]);
        $client->close(); */
    }

    // GET, Hole Produkte mit Kategorien, Bildern etc.
    public function ProduktListe() {}
}
