<?php

namespace App\Http\Controllers\Verwaltung;
use App\Http\Requests\KategorieSpeichern;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use App\Kategorie;
use App\Produkt;

class KategorienController extends AuthController
{
    public function index() {
    	$categorys = Kategorie::all();
    	return view("verwaltung.kategorien.index", ['kategorien' => $categorys]);
    }

    public function neueKategorie() {
    	return view("verwaltung.kategorien.erstellen", ['isNewCategoryDataset'=>true]);
    }

    public function neueKategorieSpeichern(KategorieSpeichern $request) {
    	$category = new Kategorie;
    	$category->name = $request->input('categoryName');
    	$category->description = $request->input('categoryDescription');
    	$category->save();
    	return redirect(route("Verwaltung.Kategorien"));
    }

    public function bearbeiten($id) {
    	$checkCategory = Kategorie::where('id', '=', $id)->first();
    	if($checkCategory !== null) {
	    	$category = Kategorie::find($id);
	    	return view("verwaltung.kategorien.erstellen", ['kategorie' => $category, 'isNewCategoryDataset'=>false]);
	    } else {
	    	return redirect(route("Verwaltung.Kategorien"));
	    }
    }

    public function bearbeitenSpeichern(KategorieSpeichern $request, $id) {
    	$category = Kategorie::find($id);
    	$category->name = $request->input('categoryName');
    	$category->description = $request->input('categoryDescription');
    	$category->save();
    	return redirect(route("Verwaltung.Kategorien"));
    }

    public function entfernen($id) {
        $categoryCount = Kategorie::all()->count();

        if($categoryCount > 1) {
        	$checkCategory = Kategorie::where('id', '=', $id)->first();

        	if($checkCategory !== null) {
        		$category = Kategorie::find($id);
        		$category->delete();

                $products = Produkt::where('category', $id)
                    ->update(['category'=>Kategorie::all()->first()->id]);

        	}
        }

    	return redirect(route("Verwaltung.Kategorien"));
    }
}
