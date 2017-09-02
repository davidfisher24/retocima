<?php

/**
   * Provincias Table seeder
   * @author David Fisher
   * Seeds from file '/database/raw/provincias.csv'
   * Input csv should contain no header row
*/

use Illuminate\Database\Seeder;
use App\Provincia;

class ProvinciasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Calls seedProvincia() for each row found
     *
     * @return void
     */

    public function run()
    {
      DB::table('provincias')->truncate();
  		$file = fopen(base_path('/database/raw/provincias.csv'),"r");

  		while(! feof($file))
  		{
  			$this->seedProvincia(fgetcsv($file));
  			
  		}

  		fclose($file);
    }

    /**
     * Insert single provincia into the database
     *
     * @param array $csvArray
     * @return void
     */

    public function seedProvincia($csvArray){
    	  $provincia = new Provincia();

      	$provincia->nombre = $csvArray[1];
      	$provincia->communidad_id = $csvArray[2];
      	$provincia->iberia_id = $csvArray[3];

  		  $provincia->save();
    }
}
