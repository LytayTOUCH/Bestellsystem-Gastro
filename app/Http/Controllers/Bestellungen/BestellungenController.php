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

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

/**
 * @category  Bestellungen
 * @author  Dennis Heinrich
 */
class BestellungenController extends AuthController
{
    /**
     * Übersicht der offenen Bestellungen
     */
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

    /**
     * Anzeigen des Formulars für eine neue Bestellung 
     */
    public function NeueBestellung() {
    	$kategorien = Kategorie::with('produkte')->get();
        $tische = Tisch::all();
    	$selectedAuswahl = [];

    	foreach($kategorien as $kategorie) {
            // Zeige nur Kategorien mit Produkten
            if(count($kategorie->produkte) > 0) {
        		$produkte = Produkt::where('category', $kategorie->id)->get();
        		$selectedAuswahl[$kategorie->name] = ["id" => $kategorie->id, "name" => $kategorie->name, "produkte" => $produkte];
            }
    	}

    	return view('bestellungen.bestellung', ['selectedCatsAndProds' => $selectedAuswahl, 'tische' => $tische]);
    }

    /**
     * Bestellung mit spezieller ID stornieren
     * @param integer $id ID der Bestellung zum stornieren
     */
    public function BestellungStornieren($id) { 
        $bestellung = Bestellung::find($id);
        if($bestellung != null) {
            BestellungProdukt::where('Bestellung_ID', $id)->delete();
            KundeBestellung::where('Bestellung_ID', $id)->delete();
            $bestellung->delete();

            $client = new Client(new Version2X(config('app.node_addr'), []));
            $client->initialize();
            $client->emit('order closed', [
                'id' => $id
            ]);
            $client->close();
        }
        return redirect(route('Bestellungen'));
    }

    /**
     * Bestellung mit spezieller ID als erledigt markieren
     * @param integer $id ID der zu erledigenden Bestellung
     */
    public function BestellungErledigen($id) {
        $bestellung = Bestellung::find($id);
        if($bestellung != null) {
            $bestellung->Erledigt = true;
            $bestellung->save();
            
            $client = new Client(new Version2X(config('app.node_addr'), []));
            $client->initialize();
            $client->emit('order closed', [
                'id' => $id
            ]);
            $client->close();

        }

        return redirect(route('Bestellungen'));
    }

    /**
     * Produkt aus einer Bestellung entfernen
     * @param integer $id ID des Produktes zu der Kundenbestellung
     */
    public function BestellungProduktEntfernen($id) {
        $produkt = BestellungProdukt::find($id);
        if($produkt != null) {
            $produkt->delete();

            // Prüfe, ob es das letzte Produkt war
            $order_id = $produkt->Bestellung_ID;
            $order = Bestellung::with(['produkte'])->where('id', '=', $order_id)->first();
            if(count($order->produkte) == 0) {
                $order->delete();
            }
        }

        // @todo NodeJS

        return redirect()->back();
    }

    /**
     * Produkt aus einer Bestellung kostenlos machen
     * @param integer $id ID des Produktes zu der Kundenbestellung
     */
    public function BestellungProduktKostenlos($id) {
        $produkt = BestellungProdukt::find($id);
        if($produkt != null) {
            $produkt->Preis = 0;
            $produkt->save();
        }

        // @todo NodeJS

        return redirect()->back();
    }

    /**
     * Speichern einer neuen Bestellung
     * @param Request $request Request zur Bestellung
     */
    public function NeueBestellungSpeichern(Request $request) {
        // Variable zur Datenbestimmung für NodeJS
        $produkte = [];

        // Prüfe ob Produkte enthalten sind
        $produkteAnzahl = 0;
        foreach($request->input('anzahl') as $produkt => $anzahl) {
            if(!$anzahl <= 0) {
                $produkteAnzahl += $anzahl;
            }
        }

        if(!$produkteAnzahl > 0) {
            return redirect(route('Bestellungen'))->with('error_message', 'Die Bestellung enthielt keine Produkte');
        }

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

                        $produkte[] = [
                            "id" => $bestellungProdukte->id,
                            "product_id" => $produkt,
                            "product_price" => number_format($bestellungProdukte->Preis, 2, ',', '.'),
                            "product_name" => Produkt::find($produkt)->name,
                        ];
                    }   
                }

                $kundeBestellung = new KundeBestellung;
                $kundeBestellung->Kunden_ID = $kunde->id;
                $kundeBestellung->Bestellung_ID = $bestellung->id;
                $kundeBestellung->save();

                // Setze Tisch als besetzt
                $tisch->Besetzt = true;
                $tisch->save();

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
                $client->close();
            }
        } else {
            throw new BadMethodCallException("Nicht implementierte Funktion");
        }
        return redirect(route('Bestellungen'));
    }

    /**
     * Offene Abrechnungen anzeigen
     */
    public function Abrechnung() {
        $bestellungen = Kunde::with(['bestelltes' => function($q) {
            $q->where('Erledigt', '=', true);
        }, 'bestelltes.produkte', 'tisch'])->where([
            ['Abgerechnet', '=', false],
        ])->get();

        return view("bestellungen.abrechnung", ["tisch_bestellungen"=>$bestellungen]);
    }

    /**
     * Öffnen einer Abrechnung zu einem Tisch
     * @param integer $id ID des Tisches zur Abrechnung
     */
    public function AbrechnungOpen($id) {
        $tisch = Tisch::find($id);
        if($tisch !== null) {
            $kunden = Kunde::where("Tisch_ID", "=", $tisch->id)->with(['bestelltes', 'bestelltes.produkte', 'tisch'])->get();
            return view('bestellungen.bezahlen', ['kunden'=>$kunden]);
        } else {
            throw new Exception("Error Processing Request", 1);
            
        }
    }

    /**
     * Aufteilen von Produkten auf mehrere Kunden
     * @todo Programmieren der Aufteilung von Bestellungen
     */
    public function AbrechnungTeilen($bestellung_produkte) {

    }

    /**
     * Abrechnung zu einem Kunden / bzw. eines Tisches abschließen
     * @todo Programmieren des Abrechnungs-Abschlusses
     */
    public function AbrechnungClose($customer_id) {

    }
}
