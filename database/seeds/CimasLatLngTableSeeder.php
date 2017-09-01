<?php

/**
   * Cima Lat Lng Table seeder
   * @author David Fisher
   * Seeds from file '/database/raw/latLng.csv'
   * Input csv should have no header row
   * Seeds additional latitude longitude coordinates to the cimas table
*/

use Illuminate\Database\Seeder;
use App\Cima;

class CimasLatLngTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     * Calls seedCimaLatLng() for every row found
     *
     * @return void
     */

    public function run()
    {
		$file = fopen(base_path('/database/raw/latLng.csv'),"r");

		while(! feof($file))
		{
			$this->seedCimaLatLng(fgetcsv($file));
		}

		fclose($file);
    }

    /**
     * Finds the cima via the data passed and saves the lat/lng data to the appropriate model
     *
     * @param array $csvArray
     * @return void
     */

    public function seedCimaLatLng($csvArray){
    	$cimaCodigo = $csvArray[0];
    	$cima;

    	if (substr($cimaCodigo,4,1) === "e") {
    		$cimaCodigo = substr($cimaCodigo,0,4);
    		$cima = Cima::where('codigo',$cimaCodigo)->where('estado',2)->first();
    	} else {
    		$cima = Cima::where('codigo',$cimaCodigo)->whereIn('estado',[1,3])->first();
    	}

        if($cima) {
            $cima->longitude = $csvArray[2];
            $cima->latitude = $csvArray[3];
            $cima->save();
        }
    }

}
