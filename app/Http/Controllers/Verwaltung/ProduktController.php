<?php

namespace App\Http\Controllers\Verwaltung;

use App\Http\Requests\ProduktSpeichern;
use App\Http\Controllers\AuthController;
use App\Models\Helper\UserLogs;
use Illuminate\Http\Request;
use App\Models\Produkte\Produkt;
use App\Models\Produkte\Kategorie;
use App\Models\Bestellungen\BestellungProdukt;
use Illuminate\Support\Facades\Auth;

class ProduktController extends AuthController {

    public function index() {
        $categorys = Kategorie::all();
        $produkte = Produkt::all();

        UserLogs::create(Auth::id(), 'Verwaltung.Produkte.Dashboard', 'Hat sich alle Produkte anzeigen lassen');
        return view("verwaltung.produkte.index", ["kategorien" => $categorys, "produkte" => $produkte]);
    }

    public function erstellen() {
        $categorys = Kategorie::all();

        UserLogs::create(Auth::id(), 'Verwaltung.Produkte.Erstellen', 'Hat das Formular für die Erstellung eines Produktes geöffnet');
        return view("verwaltung.produkte.erstellen", ['isNewCategoryDataset' => true, "kategorien" => $categorys]);
    }

    public function erstellenSpeichern(ProduktSpeichern $request) {
        $produkt = new Produkt;
        $produkt->name = $request->input('productName');
        $produkt->description = $request->input('productDescription');
        $produkt->price = $request->input('productPrice');
        $produkt->category = $request->input('productCategory');
        // \App\Models\SiteSettings::all()->first()->module_warenwirtschaft;
        $produkt->available = $request->input('productAvailable');

        if ($request->input('productInfinite') != null) {
            $produkt->infinite = true;
        } else {
            $produkt->infinite = false;
        }

        if ($request->input('productActive') != null) {
            $produkt->active = true;
        } else {
            $produkt->active = false;
        }

        $produkt->save();
        UserLogs::create(Auth::id(), 'Verwaltung.Produkte.Erstellen.Speichern', 'Hat das Produkt '.$produkt->name.' mit der ID '.$produkt->id.' erstellt');

        return redirect(route('Verwaltung.Produkte'))->with('message', 'Das Produkt wurde gespeichert');
    }

    public function bearbeiten($id) {
        $produkt = Produkt::where('id', $id)->first();
        $categorys = Kategorie::all();

        if ($produkt->count() >= 1) {
            UserLogs::create(Auth::id(), 'Verwaltung.Produkte.Bearbeiten.Ansicht', 'Hat sich das Produkt "'.$produkt->name.'"" mit der ID '.$id.' anzeigen lassen');
            return view("verwaltung.produkte.erstellen", ['product' => $produkt, 'isNewCategoryDataset' => false, "kategorien" => $categorys]);
        } else {
            UserLogs::create(Auth::id(), 'Verwaltung.Produkte.Bearbeiten.Ansicht', 'Hat sich das Produkt "'.$produkt->name.'"" mit der ID '.$id.' anzeigen lassen wollen (Ohne Erfolg)');
            return redirect(route('Verwaltung.Produkte'));
        }
    }

    public function bearbeitenSpeichern(ProduktSpeichern $request, $id) {
        $produkt = Produkt::where('id', $id)->first();
        if ($produkt->count() >= 1) {
            $produkt->name = $request->input('productName');
            $produkt->description = $request->input('productDescription');
            $produkt->price = $request->input('productPrice');
            $produkt->category = $request->input('productCategory');
            $produkt->available = $request->input('productAvailable');
            if ($request->input('productInfinite') != null) {
                $produkt->infinite = true;
            } else {
                $produkt->infinite = false;
            }

            if ($request->input('productActive') != null) {
                $produkt->active = true;
            } else {
                $produkt->active = false;
            }

            UserLogs::create(Auth::id(), 'Verwaltung.Produkte.Bearbeiten.Speichern', 'Hat das Produkt "'.$produkt->name.'"" mit der ID '.$id.' bearbeitet');

            $produkt->save();
        } else {
            UserLogs::create(Auth::id(), 'Verwaltung.Produkte.Bearbeiten.Speichern', 'Hat das Produkt "'.$produkt->name.'"" mit der ID '.$id.' bearbeiten wollen (Ohne Erfolg: Produkt nicht vorhanden)');
        }

        return redirect(route('Verwaltung.Produkte'))->with('message', 'Das Produkt wurde gespeichert');
    }

    public function entfernen($id) {
        $produkt = Produkt::where('id', $id)->first();
        if ($produkt->count() >= 1) {
            $produkte_bestellt = BestellungProdukt::where('Produkt_ID', '=', $id)->with(['bestellung', 'bestellung.produkte'])->get();

            foreach ($produkte_bestellt as $produkt_bestellt) {
                $bestellung = $produkt_bestellt->bestellung;
                if (count($bestellung->produkte) == 1) {
                    $bestellung->delete();
                }

                $produkt_bestellt->delete();
            }

            UserLogs::create(Auth::id(), 'Verwaltung.Produkte.Entfernen', 'Hat das Produkt "'.$produkt->name.'"" mit der ID '.$id.' entfernt');
            $produkt->delete();

            return redirect(route('Verwaltung.Produkte'))->with('message', 'Das Produkt wurde entfernt');
        }

        return redirect(route('Verwaltung.Produkte'));
    }

}
