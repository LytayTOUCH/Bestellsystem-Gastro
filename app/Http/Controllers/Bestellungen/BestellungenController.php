<?php

namespace App\Http\Controllers\Bestellungen;

use App\Models\Helper\UserLogs;
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
use Illuminate\Support\Facades\Auth;

/**
 * @category  Bestellungen
 * @author  Dennis Heinrich
 */
class BestellungenController extends AuthController {

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
            $allBestellungen[$bestellung->id] = ['tisch' => $kunde->Tisch_ID, 'kunde' => $kunde->id, 'zeit' => $bestellung->created_at, 'produkte' => $produkte];
        }

        UserLogs::create(Auth::id(), 'Bestellung.Dashboard', 'Hat die Bestellübersicht geöffnet');

        return view("bestellungen.index", ['bestellungen' => $allBestellungen]);
    }

    /**
     * Anzeigen des Formulars für eine neue Bestellung 
     */
    public function NeueBestellung() {
        $kategorien = Kategorie::with('produkte')->get();
        $tische = Tisch::all();
        $selectedAuswahl = [];

        foreach ($kategorien as $kategorie) {
            // Zeige nur Kategorien mit Produkten
            if (count($kategorie->produkte) > 0) {
                $produkte = Produkt::where('category', $kategorie->id)->where('active', true)->get();
                $selectedAuswahl[$kategorie->name] = ["id" => $kategorie->id, "name" => $kategorie->name, "produkte" => $produkte];
            }
        }

        UserLogs::create(Auth::id(), 'Bestellung.Erstellen', 'Hat das Formular für eine neue Bestellung geöffnet');

        return view('bestellungen.bestellung', ['selectedCatsAndProds' => $selectedAuswahl, 'tische' => $tische]);
    }

    /**
     * Bestellung mit spezieller ID stornieren
     * @param integer $id ID der Bestellung zum stornieren
     */
    public function BestellungStornieren($id) {
        $bestellung = Bestellung::find($id);
        if ($bestellung != null) {
            BestellungProdukt::where('Bestellung_ID', $id)->delete();
            $kundeB = KundeBestellung::where('Bestellung_ID', $id)->first();

            // Prüfe ob Kunde keine weiteren Bestellungen zum Abschließen hat

            if (Kunde::offeneBestellungenCount($kundeB->Kunden_ID) <= 1) {
                $kunde = Kunde::find($kundeB->Kunden_ID);
                $kunde->Abgerechnet = true;
                $kunde->save();
            }

            $kundeB->delete();
            $bestellung->delete();

            $client = new Client(new Version2X(config('app.node_addr'), []));
            $client->initialize();
            $client->emit('order closed', [
                'id' => $id
            ]);
            $client->close();
        }

        UserLogs::create(Auth::id(), 'Bestellung.Stornieren', 'Hat die Bestellung (ID: '.$id.') storniert');

        return redirect(route('Bestellungen'));
    }

    /**
     * Bestellung mit spezieller ID als erledigt markieren
     * @param integer $id ID der zu erledigenden Bestellung
     */
    public function BestellungErledigen($id) {
        $bestellung = Bestellung::find($id);
        if ($bestellung != null) {
            $bestellung->Erledigt = true;
            $bestellung->save();

            $client = new Client(new Version2X(config('app.node_addr'), []));
            $client->initialize();
            $client->emit('order closed', [
                'id' => $id
            ]);
            $client->close();
        }

        UserLogs::create(Auth::id(), 'Bestellung.Erledigen', 'Hat die Bestellung (ID: '.$id.') als erledigt markiert');

        return redirect(route('Bestellungen'));
    }

    /**
     * Produkt aus einer Bestellung entfernen
     * @param integer $id ID des Produktes zu der Kundenbestellung
     */
    public function BestellungProduktEntfernen($id) {
        $produkt = BestellungProdukt::find($id);
        if ($produkt != null) {
            $produkt->delete();

            // Prüfe, ob es das letzte Produkt war
            $order_id = $produkt->Bestellung_ID;
            $order = Bestellung::with(['produkte'])->where('id', '=', $order_id)->first();
            if (count($order->produkte) == 0) {
                $order->delete();
            }

            UserLogs::create(Auth::id(), 'Bestellung.ProduktEntfernen', 'Hat ein Produkt aus der Bestellung (ID: '.$id.') entfernt');
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
        if ($produkt != null) {
            $produkt->Preis = 0;
            $produkt->save();
        }

        // @todo NodeJS
        UserLogs::create(Auth::id(), 'Bestellung.ProduktKostenlos', 'Hat ein Produkt aus der Bestellung (ID: '.$id.') kostenlos gemacht');

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
        foreach ($request->input('anzahl') as $produkt => $anzahl) {
            if (!$anzahl <= 0) {
                $produkteAnzahl += $anzahl;
            }
        }

        if (!$produkteAnzahl > 0) {
            return redirect(route('Bestellungen'))->with('error_message', 'Die Bestellung enthielt keine Produkte');
        }

        // Prüfe ob Tisch existiert
        $tisch = Tisch::find($request->input('customerTable'));
        if ($tisch->count() !== null) {
            // Prüfe ob Tisch bereits besetzt ist
            if (Tisch::IsTableBlocked($tisch->id)) {
                $kundeId = Tisch::GetKundeFromTable($tisch->id);
                if ($kundeId !== 0) {
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
            if ($produkteAnzahl > 0) {
                $bestellung = new Bestellung;
                $bestellung->Erledigt = false;
                $bestellung->save();

                foreach ($request->input('anzahl') as $produkt => $anzahl) {
                    for ($i = 0; $i < $anzahl; $i++) {
                        $bestellungProdukte = new BestellungProdukt;
                        $bestellungProdukte->Bestellung_ID = $bestellung->id;
                        $bestellungProdukte->Produkt_ID = $produkt;

                        // Aktualisiere Warenwirtschaft-Anzahl
                        if (\App\Models\SiteSettings::all()->first()->module_warenwirtschaft) {
                            $wawi_produkt = Produkt::find($produkt);
                            $wawi_produkt->available -= 1;
                            $wawi_produkt->save();
                        }

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

        UserLogs::create(Auth::id(), 'Bestellung.Erstellen.Speichern', 'Hat eine neue Bestellung aufgenommen (ID: '.$bestellung->id.')');
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

        UserLogs::create(Auth::id(), 'Bestellung.Abrechnung', 'Hat die Übersicht aller Abrechnungen geöffnet');

        return view("bestellungen.abrechnung", ["tisch_bestellungen" => $bestellungen]);
    }

    /**
     * Öffnen einer Abrechnung zu einem Tisch
     * @param integer $id ID des Tisches zur Abrechnung
     */
    public function AbrechnungClose($id) {
        $kunde = Kunde::all()->where('Tisch_ID', '=', $id)->last();
        $kunde->Abgerechnet = true;
        $kunde->save();

        $tisch = Tisch::all()->where('id', '=', $id)->first();
        $tisch->Besetzt = false;
        UserLogs::create(Auth::id(), 'Bestellung.AbrechnungEnde', 'Hat die Abrechnung zum Tisch (ID: '.$id.') abgeschlossen');

        return redirect(route('Bestellungen.Abrechnung'))->with('message', 'Kunde wurde erfolgreich abgerechnet!');
    }

}
