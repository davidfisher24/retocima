<?php

/**
   * Paises Table seeder
   * @author David Fisher
   * Seeds from file '/database/raw/paises.csv'
   * Input csv should contain no header row
*/

use Illuminate\Database\Seeder;
use App\Pais;

class PaisesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Calls seedPaises() for each row found
     *
     * @return void
     */

    public function run()
    {
      DB::table('paises')->truncate();
  		$file = fopen(base_path('/database/raw/paises.csv'),"r");

  		while(! feof($file))
  		{
  			$this->seedPais(fgetcsv($file));
  			
  		}

  		fclose($file);
    }

    /**
     * Insert single pais into the database
     *
     * @param array $csvArray
     * @return void
     */

    public function seedPais($csvArray){
    	$pais = new Pais();

      $pais->nombre = $csvArray[0];

  		$pais->save();
    }
}
