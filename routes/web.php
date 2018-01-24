<?php

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

// Verwaltung
Route::prefix('verwaltung')->group(function() {
	Route::get('/', 'Verwaltung\VerwaltungController@index')->name('Verwaltung');
	Route::prefix('produkte')->group(function() {
		Route::get('/', 'Verwaltung\ProdukteController@index')->name('Verwaltung.Produkte');
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
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');