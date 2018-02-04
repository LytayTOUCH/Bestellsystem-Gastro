<?php

namespace App\Http\Controllers\Verwaltung;

use App\Http\Requests\ProduktSpeichern;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use App\Models\Produkte\Produkt;
use App\Models\Produkte\Kategorie;

class ProduktController extends AuthController
{
    public function index() {
    	$categorys = Kategorie::all();
    	$produkte = Produkt::all();

    	return view("verwaltung.produkte.index", ["kategorien" => $categorys, "produkte"=>$produkte]);
    }

    public function erstellen() {
    	$categorys = Kategorie::all();

    	return view("verwaltung.produkte.erstellen", ['isNewCategoryDataset' => true, "kategorien" => $categorys]);
    }

    public function erstellenSpeichern(ProduktSpeichern $request) {
    	$produkt = new Produkt;
    	$produkt->name = $request->input('productName');
    	$produkt->description = $request->input('productDescription');
    	$produkt->price = $request->input('productPrice');
    	$produkt->category = $request->input('productCategory');
    	$produkt->save();

    	return redirect(route('Verwaltung.Produkte'))->with('message', 'Das Produkt wurde gespeichert');
    }

    public function bearbeiten($id) {
    	$produkt = Produkt::where('id', $id)->first();
    	$categorys = Kategorie::all();

    	if($produkt->count() >= 1) {
    		return view("verwaltung.produkte.erstellen", ['product'=>$produkt, 'isNewCategoryDataset' => false, "kategorien" => $categorys]);
    	} else {
    		return redirect(route('Verwaltung.Produkte'));
    	}
    }

    public function bearbeitenSpeichern(ProduktSpeichern $request, $id) {
    	$produkt = Produkt::where('id', $id)->first();
    	if($produkt->count() >= 1) {
    		$produkt->name = $request->input('productName');
	    	$produkt->description = $request->input('productDescription');
	    	$produkt->price = $request->input('productPrice');
	    	$produkt->category = $request->input('productCategory');
	    	$produkt->save();
    	}
    	
    	return redirect(route('Verwaltung.Produkte'))->with('message', 'Das Produkt wurde gespeichert');
    }

    public function entfernen($id) {
    	$produkt = Produkt::where('id', $id)->first();
    	if($produkt->count() >= 1) {
	    	$produkt->delete();
            return redirect(route('Verwaltung.Produkte'))->with('message', 'Das Produkt wurde entfernt');
    	}

    	return redirect(route('Verwaltung.Produkte'));
    }
}
