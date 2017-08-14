<?php

 /**
   * MMigration to create cimas table
   * @author David Fisher
*/

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCimasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cimas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo_provincia');
            $table->string('codigo');
            $table->integer('estado')->default(1);
            $table->string('nombre');
            $table->string('provincia_frontera')->nullable();
            $table->string('provincia');
            $table->integer('provincia_id'); // NEW
            $table->string('communidad');
            $table->integer('communidad_id'); // NEW
            $table->string('pais');
            $table->string('iberia');
            $table->integer('iberia_id'); // NEW
            $table->string('isla')->nullable();
            $table->boolean('pata_negra')->default(0);
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
        Schema::dropIfExists('cimas');
    }
}
