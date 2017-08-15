<?php

/**
   * Iberias Table seeder
   * @author David Fisher
   * Seeds from file '/database/raw/iberias.csv'
   * Input csv should contain no header row
*/

use Illuminate\Database\Seeder;
use App\Iberia;

class IberiasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Calls seedIberia() for each row found
     *
     * @return void
     */

    public function run()
    {
      DB::table('iberias')->truncate();
  		$file = fopen(base_path('/database/raw/iberias.csv'),"r");

  		while(! feof($file))
  		{
  			$this->seedIberia(fgetcsv($file));
  			
  		}

  		fclose($file);
    }

    /**
     * Insert single iberia into the database
     *
     * @param array $csvArray
     * @return void
     */

    public function seedIberia($csvArray){
    	$iberia = new Iberia();

      $iberia->nombre = $csvArray[1];

  		$iberia->save();
    }
}
