<?php

use Illuminate\Database\Seeder;
use App\Cimero;

class CimerosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	DB::table('cimeros')->truncate();
		$file = fopen(base_path('/documentation/cimeros.csv'),"r");

		while(! feof($file))
		{
			$this->seedCimero(fgetcsv($file));
		}

		fclose($file);
    }

    public function seedCimero($csvArray){
    	$cimero = new Cimero();

    	$cimero->nombre = $csvArray[1];
    	$cimero->apellido1 = $csvArray[2];
    	$cimero->apellido2 = $csvArray[3];
    	$cimero->fechanacimiento = $csvArray[4];
    	$cimero->direccion = $csvArray[5];
    	$cimero->poblacion = $csvArray[6];
    	$cimero->provincia = $csvArray[7];
    	$cimero->codigopostal = $csvArray[8];
    	$cimero->correoelectronico = $csvArray[9];
    	$cimero->web = $csvArray[10];
    	$cimero->puertofavorito = $csvArray[11];
    	$cimero->puertomasduro = $csvArray[12];
    	$cimero->puertomasfacil = $csvArray[13];
    	$cimero->bicicleta = $csvArray[14];
    	$cimero->desarrollo = $csvArray[15];
    	$cimero->grupo = $csvArray[16];
    	$cimero->frase = $csvArray[17];
    	$cimero->usuario = $csvArray[18];;
    	$cimero->contrasena = Hash::make($csvArray[19]);
    	$cimero->nickmiarroba = $csvArray[20];
    	$cimero->fechaalta = $csvArray[21];

		$cimero->save();
    }
}
