<?php

namespace App\Http\Controllers\Bestellungen;

use Illuminate\Http\Request;
use \App\Http\Controllers\AuthController;
use \App\Models\Bestellungen\KundeBestellung;
use \App\Models\Bestellungen\BestellungProdukt;
use \App\Models\Bestellungen\Bestellung;
use \App\Models\Bestellungen\Kunde;
use \App\Models\Produkte\Produkt;
use \App\Models\Produkte\Kategorie;
use \App\Models\Tisch;


class BestellungenController extends AuthController
{
    public function index() {
        $bestellungen = Bestellung::where('Erledigt', false)->get();
        $allBestellungen = [];

        foreach ($bestellungen as $bestellung) {
            $produkte = BestellungProdukt::where('Bestellung_ID', $bestellung->id)->get();
            $kundenBestellung = KundeBestellung::where('Bestellung_ID', $bestellung->id)->get()->first();
            $kunde = Kunde::find($kundenBestellung->Kunden_ID);
            $allBestellungen[$bestellung->id] = ['tisch' => $kunde->Tisch_ID, 'kunde' => $kunde->id, 'zeit' => $bestellung->created_at, 'produkte'=>$produkte];
        }

    	return view("bestellungen.index", ['bestellungen' => $allBestellungen]);
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

    public function BestellungStornieren($id) { 
        $bestellung = Bestellung::find($id);
        if($bestellung != null) {
            BestellungProdukt::where('Bestellung_ID', $id)->delete();
            KundeBestellung::where('Bestellung_ID', $id)->delete();
            $bestellung->delete();
        }
        return redirect(route('Bestellungen'));
    }

    public function BestellungErledigen($id) {
        $bestellung = Bestellung::find($id);
        if($bestellung != null) {
            $bestellung->Erledigt = true;
            $bestellung->save();
        }
        return redirect(route('Bestellungen'));
    }

    public function BestellungProduktEntfernen($id) {
        $produkt = BestellungProdukt::find($id);
        if($produkt != null) {
            $produkt->delete();
        }

        return redirect()->back();
    }

    public function BestellungProduktKostenlos($id) {
        $produkt = BestellungProdukt::find($id);
        if($produkt != null) {
            $produkt->Preis = 0;
            $produkt->save();
        }

        return redirect()->back();
    }

    public function NeueBestellungSpeichern(Request $request) {
        // Prüfe ob Tisch existiert
        $tisch = Tisch::find($request->input('customerTable'));
        if($tisch->count() !== null) {
            // Prüfe ob Tisch bereits besetzt ist
            if(Tisch::IsTableBlocked($tisch->id)) {
                $kundeId = Tisch::GetKundeFromTable($tisch->id);
                if($kundeId !== 0) {
                    $kunde = Kunde::find($kundeId);
                } else {
                    throw new Exception("Error Processing Request", 1);
                }
            } else {
                $kunde = new Kunde;
                $kunde->Tisch_ID = $request->input('customerTable');
            }

            $kunde->Abgerechnet = false;
            $kunde->save();

            // Prüfe ob Produkte enthalten sind
            $produkteAnzahl = 0;
            foreach($request->input('anzahl') as $produkt => $anzahl) {
                if(!$anzahl <= 0) {
                    $produkteAnzahl += $anzahl;
                }
            }

            // Erstelle eine neue Bestellung
            if($produkteAnzahl > 0) {
                $bestellung = new Bestellung;
                $bestellung->Erledigt = false;
                $bestellung->save();

                foreach($request->input('anzahl') as $produkt => $anzahl) {
                    for ($i=0; $i < $anzahl; $i++) { 
                        $bestellungProdukte = new BestellungProdukt;
                        $bestellungProdukte->Bestellung_ID = $bestellung->id;
                        $bestellungProdukte->Produkt_ID = $produkt;
                        // Hole den Preis zur Kaufzeit
                        $produktPreis = Produkt::find($produkt); 
                        $bestellungProdukte->Preis = $produktPreis->price;
                        $bestellungProdukte->save();
                    }   
                }

                $kundeBestellung = new KundeBestellung;
                $kundeBestellung->Kunden_ID = $kunde->id;
                $kundeBestellung->Bestellung_ID = $bestellung->id;
                $kundeBestellung->save();
            }

            // Setze Tisch als besetzt
            $tisch->Besetzt = true;
            $tisch->save();
        } else {
            throw new BadMethodCallException("Nicht implementierte Funktion");
        }
        return redirect(route('Bestellungen'));
    }

    public function Abrechnung() {
        $bestellungen = Kunde::with(['bestelltes' => function($q) {
            $q->where('Erledigt', '=', true);
        }, 'bestelltes.produkte', 'tisch'])->where([
            ['Abgerechnet', '=', false],
        ])->get();

        return view("bestellungen.abrechnung", ["tisch_bestellungen"=>$bestellungen]);
    }

    public function AbrechnungOpen($id) {
        // Tisch
        // Kunden
        // Produkte

        $tisch = Tisch::find($id);
        if($tisch !== null) {
            $kunden = Kunde::where("Tisch_ID", "=", $tisch->id)->with(['bestelltes', 'bestelltes.produkte', 'tisch'])->get();
            return view('bestellungen.bezahlen', ['kunden'=>$kunden]);
        } else {
            throw new Exception("Error Processing Request", 1);
            
        }
    }
}
