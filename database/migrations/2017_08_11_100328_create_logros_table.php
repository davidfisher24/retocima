<?php

 /**
   * MMigration to create logros table
   * @author David Fisher
*/

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logros', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cimero_id'); // Changed name
            $table->integer('cima_id'); // Changed name
            $table->string('cima_codigo'); // Changed name
            $table->integer('cima_estado'); // NEW
            $table->integer('provincia_id'); // NEW
            $table->integer('communidad_id'); // NEW
            $table->integer('iberia_id'); // NEW
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
        Schema::dropIfExists('logros');
    }
}
