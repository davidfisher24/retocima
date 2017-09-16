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
            $table->text('inicio')->nullable();
            $table->text('dudas')->nullable();
            $table->text('final')->nullable();
            $table->text('observaciones')->nullable();
            $table->decimal('longitude_cima',12,10)->nullable();
            $table->decimal('latitude_cima',12,10)->nullable();
            $table->string('iframe',255)->nullable();
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
