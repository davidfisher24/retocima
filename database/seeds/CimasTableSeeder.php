<?php

 /**
   * Cimeros Table seeder
   * @author David Fisher
   * Seeds from file '/database/raw/cimas.csv'
   * Input csv should have no header row
*/

use Illuminate\Database\Seeder;
use App\Cima;

class CimasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Calls seedCima() for every row found
     *
     * @return void
     */

    public function run()
    {
        DB::table('cimas')->truncate();
		$file = fopen(base_path('/database/raw/cimas.csv'),"r");

		while(! feof($file))
		{
			$this->seedCima(fgetcsv($file));
		}

		fclose($file);
    }

    /**
     * Insert one cimero into the database
     *
     * @param array $csvArray
     * @return void
     */

    public function seedCima($csvArray){
    	$cima = new Cima();

    	$cima->codigo_provincia = $csvArray[0];
    	$cima->codigo = $csvArray[1];
    	$cima->estado = $csvArray[2];
    	$cima->nombre = $csvArray[3];
    	$cima->provincia_frontera = $csvArray[4];
        $cima->provincia_id = $csvArray[5];
    	$cima->provincia = $csvArray[6];
        $cima->communidad_id = $csvArray[7];
    	$cima->communidad = $csvArray[8];
    	$cima->pais = $csvArray[9];
        $cima->iberia_id = $csvArray[10];
    	$cima->iberia = $csvArray[11];
    	$cima->isla = $csvArray[12];
    	$cima->pata_negra = $csvArray[13];

		$cima->save();
    }
}

