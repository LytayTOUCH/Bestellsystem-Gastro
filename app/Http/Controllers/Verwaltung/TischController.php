<?php

namespace App\Http\Controllers\Verwaltung;

use App\Http\Controllers\AuthController;
use App\Models\Helper\UserLogs;
use Illuminate\Http\Request;
use App\Http\Requests\TischSpeichern;
use App\Models\Tisch;
use Illuminate\Support\Facades\Auth;

class TischController extends AuthController
{
    public function index()
    {
    	$tische = Tisch::all();
        UserLogs::create(Auth::id(), 'Verwaltung.Tische.Dashboard', 'Hat die Tischkonfiguration anzeigen lassen');
    	return view('verwaltung.tische.index', ['tische' => $tische]);
    }

    public function erstellen() {
        UserLogs::create(Auth::id(), 'Verwaltung.Tische.Erstellen', 'Hat das Formular zum Erstellen eines Tisches aufgerufen');
        return view('verwaltung.tische.erstellen');
    }


    public function erstellenSpeichern(TischSpeichern $request) {
    	$tisch = new Tisch;
    	$tisch->Name = $request->input('Name');
    	$tisch->save();
        UserLogs::create(Auth::id(), 'Verwaltung.Tische.Erstellen.Speichern', 'Hat einen Tisch erstellt "'.$tisch->Name.'" (ID: '.$tisch->id.')');

        return redirect(route('Verwaltung.Tische'));
    }

    public function reset($id) {
    	$tisch = Tisch::find($id);
    	if($tisch !== null) {
    		$tisch->Besetzt = false;
    		$tisch->save();
    	}

        UserLogs::create(Auth::id(), 'Verwaltung.Tische.Reset', 'Hat den Tisch "'.$tisch->Name.'" mit der ID '.$id.' erstellt');
        return redirect(route('Verwaltung.Tische'))->with('message', "Der Tisch wurde zurückgesetzt");
    }

    public function reset_all() {
    	Tisch::where('Besetzt', true)->update([
    		'Besetzt' => false,
    	]);

        UserLogs::create(Auth::id(), 'Verwaltung.Tische.ResetAll', 'Hat alle Tische zurückgesetzt');
        return redirect(route('Verwaltung.Tische'))->with('message', "Alle Tische wurden zurückgesetzt");
    }

    public function entfernen($id) {
    	$tisch = Tisch::find($id);
        UserLogs::create(Auth::id(), 'Verwaltung.Tische.Entfernen', 'Hat den Tisch "'.$tisch->Name.'" mit der ID '.$id.' gelöscht');

        if($tisch !== null) {
            $tisch->delete();
        }

        return redirect(route('Verwaltung.Tische'));
    }
}
