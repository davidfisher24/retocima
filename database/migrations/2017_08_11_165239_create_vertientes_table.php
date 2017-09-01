<?php

 /**
   * MMigration to create vertientes table
   * Requires more data to be added: vertiene recomendado, webpage links, geo coordinates
   * @author David Fisher
*/

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVertientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vertientes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cima_id'); 
            $table->string('cima_codigo'); 
            $table->integer('index');
            $table->string('vertiente');
            $table->integer('altitud')->nullable();
            $table->integer('desnivel')->nullable();
            $table->float('longitud')->nullable();
            $table->float('porcentage_medio')->nullable();
            $table->integer('porcentage_maximo')->nullable();
            $table->integer('apm')->nullable();
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
        Schema::dropIfExists('vertientes');
    }
}
