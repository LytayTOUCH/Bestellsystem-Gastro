<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WarenwirtschaftSettings extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('site_settings', function($table) {
            $table->boolean('module_warenwirtschaft')->default(true)->nullable(false);
        });

        Schema::table('Produkte', function($table) {
            $table->integer('available')->default(0);
            $table->boolean('infinite')->default(false);
            $table->boolean('active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('site_settings', function($table) {
            $table->dropColumn('module_warenwirtschaft');
        });

        Schema::table('Produkte', function($table) {
            $table->dropColumn('available');
            $table->dropColumn('infinite');
            $table->dropColumn('active');
        });
    }

}
