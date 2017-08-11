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
    	$cima->nombre = utf8_encode($csvArray[3]);
    	$cima->provincia_frontera = utf8_encode($csvArray[4]);
    	$cima->provincia = utf8_encode($csvArray[5]);
    	$cima->communidad = utf8_encode($csvArray[6]);
    	$cima->pais = utf8_encode($csvArray[7]);
    	$cima->iberia = $csvArray[8];
    	$cima->isla = utf8_encode($csvArray[9]);
    	$cima->pata_negra = $csvArray[10];

		$cima->save();
    }
}
