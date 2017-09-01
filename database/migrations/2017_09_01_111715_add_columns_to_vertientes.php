<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToVertientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vertientes', function($table) {
            $table->text('inicio');
            $table->text('dudas');
            $table->text('final');
            $table->text('observaciones');
            $table->decimal('longitude_cima',2,10);
            $table->decimal('latitude_cima',2,10);
            $table->string('iframe',255);
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
            $table->dropColumn('inicio');
            $table->dropColumn('dudas');
            $table->dropColumn('final');
            $table->dropColumn('observaciones');
            $table->dropColumn('longitude_cima');
            $table->dropColumn('latitude_cima');
            $table->dropColumn('iframe');
        });
    }
}
