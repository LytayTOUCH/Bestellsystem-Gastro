<?php

namespace App\Http\Controllers\Verwaltung;

use App\Http\Requests\KategorieSpeichern;
use App\Http\Controllers\AuthController;
use App\Models\Helper\UserLogs;
use Illuminate\Http\Request;
use App\Models\Produkte\Kategorie;
use App\Models\Produkte\Produkt;
use Illuminate\Support\Facades\Auth;

class KategorienController extends AuthController
{
    public function index()
    {
        $categorys = Kategorie::all();
        UserLogs::create(Auth::id(), 'Verwaltung.Kategorien.Dashboard', 'Hat sich alle Kategorien anzeigen lassen');
        return view("verwaltung.kategorien.index", ['kategorien' => $categorys]);
    }

    public function neueKategorie()
    {
        UserLogs::create(Auth::id(), 'Verwaltung.Kategorien.Erstellen', 'Hat das Formular für das Erstellen einer Kategorie geöffnet');
        return view("verwaltung.kategorien.erstellen", ['isNewCategoryDataset' => true]);
    }

    public function neueKategorieSpeichern(KategorieSpeichern $request)
    {
        $category = new Kategorie;
        $category->name = $request->input('categoryName');
        $category->description = $request->input('categoryDescription');
        $category->save();
        UserLogs::create(Auth::id(), 'Verwaltung.Kategorien.Erstellen.Speichern', 'Hat eine neue Kategorie "' . $category->name . '" (ID: ' . $category->id . ') erstellt');
        return redirect(route("Verwaltung.Kategorien"))->with('message', 'Die Kategorie wurde gespeichert');
    }

    public function bearbeiten($id)
    {
        $checkCategory = Kategorie::where('id', '=', $id)->first();
        if ($checkCategory !== null) {
            $category = Kategorie::find($id);
            UserLogs::create(Auth::id(), 'Verwaltung.Kategorien.Bearbeiten', 'Hat die Kategorie "' . $category->name . '" (ID: ' . $category->id . ') zur Bearbeitung geöffnet');
            return view("verwaltung.kategorien.erstellen", ['kategorie' => $category, 'isNewCategoryDataset' => false]);
        } else {
            UserLogs::create(Auth::id(), 'Verwaltung.Kategorien.Bearbeiten', 'Hat die Kategorie (ID: ' . $id . ') versucht zur Bearbeitung zu öffnen (Ohne Erfolg)');
            return redirect(route("Verwaltung.Kategorien"));
        }
    }

    public function bearbeitenSpeichern(KategorieSpeichern $request, $id)
    {
        $category = Kategorie::find($id);
        $category->name = $request->input('categoryName');
        $category->description = $request->input('categoryDescription');
        $category->save();
        UserLogs::create(Auth::id(), 'Verwaltung.Kategorien.Bearbeiten.Speichern', 'Hat die Kategorie "'.$category->name.'" (ID: ' . $id . ') bearbeitet');

        return redirect(route("Verwaltung.Kategorien"))->with('message', 'Die Kategorie wurde gespeichert');
    }

    public function entfernen($id)
    {
        $categoryCount = Kategorie::all()->count();

        if ($categoryCount > 1) {
            $checkCategory = Kategorie::where('id', '=', $id)->first();

            if ($checkCategory !== null) {
                $category = Kategorie::find($id);
                $category->delete();

                $products = Produkt::where('category', $id)
                    ->update(['category' => Kategorie::all()->first()->id]);

            }

            UserLogs::create(Auth::id(), 'Verwaltung.Kategorien.Entfernen', 'Hat die Kategorie (ID: ' . $id . ') entfernt');
            return redirect(route("Verwaltung.Kategorien"))->with('message', 'Die Kategorie wurde entfernt');
        } else {
            UserLogs::create(Auth::id(), 'Verwaltung.Kategorien.Entfernen', 'Hat versucht die Kategorie (ID: ' . $id . ') entfernt (Ohne Erfolg)');
            return redirect(route("Verwaltung.Kategorien"))->with('error_message', 'Die letzte Kategorie kann nicht entfernt werden');

        }
    }
}
