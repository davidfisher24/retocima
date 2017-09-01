<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGeoColumnsToCimas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cimas', function($table) {
            $table->float('longitude');
            $table->float('latitude');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vertientes', function($table) {
            $table->dropColumn('longitude');
            $table->dropColumn('latitude');
        });
    }
}
