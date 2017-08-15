<?php

/**
   * communidads Table seeder
   * @author David Fisher
   * Seeds from file '/database/raw/communidads.csv'
   * Input csv should contain no header row
*/

use Illuminate\Database\Seeder;
use App\Communidad;

class CommunidadsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Calls seedCommunidad() for each row found
     *
     * @return void
     */

    public function run()
    {
        DB::table('communidads')->truncate();
  		$file = fopen(base_path('/database/raw/communidads.csv'),"r");

  		while(! feof($file))
  		{
  			$this->seedCommunidad(fgetcsv($file));
  			
  		}

  		fclose($file);
    }

    /**
     * Insert single communidad into the database
     *
     * @param array $csvArray
     * @return void
     */

    public function seedCommunidad($csvArray){
    	$communidad = new Communidad();

      $communidad->nombre = $csvArray[1];

  		$communidad->save();
    }
}
