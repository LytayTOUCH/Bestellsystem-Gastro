<?php

use App\Kunde;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('welcome');
});

Route::prefix('bestellungen')->group(function() {
	Route::get('/', 'Bestellungen\BestellungenController@index')->name('Bestellungen');
	Route::get('/neu', 'Bestellungen\BestellungenController@NeueBestellung')->name('Bestellungen.Aufnehmen');
	Route::post('/neu', 'Bestellungen\BestellungenController@NeueBestellungSpeichern')->name('Bestellungen.AufnehmenSpeichern');

	Route::prefix('abrechnung')->group(function() {
		Route::get('/', 'Bestellungen\BestellungenController@Abrechnung')->name('Bestellungen.Abrechnung');
		Route::get('/tisch/{id}', 'Bestellungen\BestellungenController@AbrechnungClose')->name('Bestellungen.Abrechnung.Bearbeiten');
	});

	Route::get('/abschliessen/{id}', 'Bestellungen\BestellungenController@BestellungErledigen')->name('Bestellungen.Abschliessen');
	Route::get('/stornieren/{id}', 'Bestellungen\BestellungenController@BestellungStornieren')->name('Bestellungen.Stornieren');
	Route::get('/produkt/kostenlos/{id}', 'Bestellungen\BestellungenController@BestellungProduktKostenlos')->name('Bestellungen.Produkt.Kostenlos');
	Route::get('/produkt/stornieren/{id}', 'Bestellungen\BestellungenController@BestellungProduktEntfernen')->name('Bestellungen.Produkt.Entfernen');
});

// Verwaltung
Route::prefix('verwaltung')->group(function() {
	Route::get('/', 'Verwaltung\VerwaltungController@index')->name('Verwaltung');

	// Einstellungen der Seite
	Route::prefix('site')->group(function() {
		Route::get('/', 'Verwaltung\SiteSettingsController@index')->name('Verwaltung.Seite');
		Route::post('/', 'Verwaltung\SiteSettingsController@EinstellungenSpeichern')->name('Verwaltung.SeiteSpeichern');
	});

	// Benutzerverwaltung
	Route::prefix('nutzer')->group(function() {
		Route::get('/', 'Verwaltung\NutzerController@index')->name('Verwaltung.Nutzer');
		Route::get('/erstellen', 'Verwaltung\NutzerController@erstellen')->name('Verwaltung.Nutzer.Erstellen');
		Route::post('/erstellen', 'Verwaltung\NutzerController@erstellenSpeichern')->name('Verwaltung.Nutzer.ErstellenSpeichern');
		Route::get('/bearbeiten/{id}', 'Verwaltung\NutzerController@bearbeiten')->name('Verwaltung.Nutzer.Bearbeiten');
		Route::post('/bearbeiten/{id}', 'Verwaltung\NutzerController@bearbeitenSpeichern')->name('Verwaltung.Nutzer.BearbeitenSpeichern');
		Route::get('/entfernen/{id}', 'Verwaltung\NutzerController@entfernen')->name('Verwaltung.Nutzer.Entfernen');
	});

	// Entwicklersektion
	Route::prefix('entwickler')->group(function () {
		Route::get('/', 'Verwaltung\EntwicklerController@index')->name('Verwaltung.Entwickler');
		Route::get('/update', 'Verwaltung\EntwicklerController@update')->name('Verwaltung.Entwickler.Update');
        Route::get('/changelog', 'Verwaltung\EntwicklerController@changelog')->name('Verwaltung.Entwickler.Changelog');
        Route::post('/issue', 'Verwaltung\EntwicklerController@CreateIssue')->name('Verwaltung.Entwickler.CreateIssue');

        // Logging-Modul
        if(\App\Models\SiteSettings::all()->first()->module_logging) {
            Route::get('/logs', 'Verwaltung\EntwicklerController@logs')->name('Verwaltung.Entwickler.Logs');
        }
    });

	// Systemdaten
	Route::prefix('daten')->group(function () {
		Route::get('/', 'Verwaltung\DatenController@index')->name('Verwaltung.Daten');
		Route::get('/bereinigen', 'Verwaltung\DatenController@bereinigen')->name('Verwaltung.Daten.Bereinigen');
	});

	// Tischverwaltung
	Route::prefix('tische')->group(function() {
		Route::get('/', 'Verwaltung\TischController@index')->name('Verwaltung.Tische');
		Route::get('/erstellen', 'Verwaltung\TischController@erstellen')->name('Verwaltung.Tische.Erstellen');
		Route::post('/erstellen', 'Verwaltung\TischController@erstellenSpeichern')->name('Verwaltung.Tische.ErstellenSpeichern');
		Route::get('/entfernen/{id}', 'Verwaltung\TischController@entfernen')->name('Verwaltung.Tische.Entfernen');
		Route::get('/reset/{id}', 'Verwaltung\TischController@reset')->name('Verwaltung.Tische.Reset');
		Route::get('/reset_all', 'Verwaltung\TischController@reset_all')->name('Verwaltung.Tische.ResetAll');
	});

	// Produktverwaltung
	Route::prefix('produkte')->group(function() {
		Route::get('/', 'Verwaltung\ProduktController@index')->name('Verwaltung.Produkte');
		Route::get('/erstellen', 'Verwaltung\ProduktController@erstellen')->name('Verwaltung.Produkte.Erstellen');
		Route::post('/erstellen', 'Verwaltung\ProduktController@erstellenSpeichern')->name('Verwaltung.Produkte.ErstellenSpeichern');
		Route::get('/bearbeiten/{id}', 'Verwaltung\ProduktController@bearbeiten')->name('Verwaltung.Produkte.Bearbeiten');
		Route::post('/bearbeiten/{id}', 'Verwaltung\ProduktController@bearbeitenSpeichern')->name('Verwaltung.Produkte.BearbeitenSpeichern');
		Route::get('/entfernen/{id}', 'Verwaltung\ProduktController@entfernen')->name('Verwaltung.Produkte.Entfernen');
	});

	// Kategorien für Produkte
	Route::prefix('kategorien')->group(function() {
		Route::get('/', 'Verwaltung\KategorienController@index')->name('Verwaltung.Kategorien');
		Route::get('/erstellen', 'Verwaltung\KategorienController@neueKategorie')->name('Verwaltung.Kategorien.Erstellen');
		Route::post('/erstellen', 'Verwaltung\KategorienController@neueKategorieSpeichern')->name('Verwaltung.Kategorien.NeueSpeichern');
		Route::get('/bearbeiten/{id}', 'Verwaltung\KategorienController@bearbeiten')->name('Verwaltung.Kategorien.Bearbeiten');
		Route::post('/bearbeiten/{id}', 'Verwaltung\KategorienController@bearbeitenSpeichern')->name('Verwaltung.Kategorien.BearbeitenSpeichern');
		Route::get('/entfernen/{id}', 'Verwaltung\KategorienController@entfernen')->name('Verwaltung.Kategorien.Entfernen');
	});
});


// Registration and forgot password are disabled
// Auth::routes();
Route::get('login', function() {
	return view('welcome');
})->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');