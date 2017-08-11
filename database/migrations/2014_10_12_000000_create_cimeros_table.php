<?php

 /**
   * MMigration to create cimeros table
   * @author David Fisher
*/

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCimerosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cimeros', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('apellido1');
            $table->string('apellido2')->nullable();
            $table->string('fechanacimiento')->nullable();
            $table->string('direccion')->nullable();
            $table->string('poblacion')->nullable();
            $table->string('provincia')->nullable();
            $table->string('codigopostal')->nullable();
            $table->string('correoelectronico')->nullable();
            $table->string('web')->nullable();
            $table->string('puertofavorito')->nullable();
            $table->string('puertomasduro')->nullable();
            $table->string('puertomasfacil')->nullable();
            $table->string('bicicleta')->nullable();
            $table->string('desarrollo')->nullable();
            $table->string('grupo')->nullable();
            $table->longText('frase')->nullable();
            $table->string('usuario');
            $table->string('contrasena');
            $table->string('nickmiarroba')->nullable();
            $table->string('fechaalta')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('cimeros');
    }
}


