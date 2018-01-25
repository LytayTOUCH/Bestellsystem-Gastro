<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBestellungenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Tische', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Name');
            $table->string('Beschreibung')->nullable(true);
        });

        Schema::create('Kunden', function (Blueprint $table) {
            $table->integer('Tisch_ID');
            $table->boolean('Abgerechnet')->default(false);
            $table->timestamps();
        });

        Schema::create('Kunden_Bestellungen', function (Blueprint $table) {
            $table->integer('Kunden_ID');
            $table->integer('Bestellung_ID');
        });

        Schema::create('Bestellungen', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('Erledigt')->default(false);
            $table->timestamps();
        });

        Schema::create('Bestellungen_Produkte', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('Bestellung_ID');
            $table->integer('Produkt_ID');
            $table->double('Preis')->default(0);
            $table->string('Bemerkung')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Bestellungen');
        Schema::dropIfExists('Bestellungen_Produkte');
        Schema::dropIfExists('Tische');
        Schema::dropIfExists('Kunden');
        Schema::dropIfExists('Kunden_Bestellungen');
    }
}
