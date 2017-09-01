<?php

 /**
   * Vertientes Data Table seeder
   * @author David Fisher
   * Seeds from file '/database/raw/vertientesData.csv'
   * Input csv should have no header row
   * Seeds additional data to the vertientes table
*/

use Illuminate\Database\Seeder;

class VertientesAdditionalDataTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Calls seedVertienteData() for every row found
     *
     * @return void
     */

    public function run()
    {
		$file = fopen(base_path('/database/raw/vertientesData.csv'),"r");

		while(! feof($file))
		{
			$this->seedVertienteData(fgetcsv($file));
		}

		fclose($file);
    }

    /**
     * Finds the vertiente via the data passed and saves the additional data to the appropriate model
     *
     * @param array $csvArray
     * @return void
     */

    public function seedVertienteData($csvArray){
    	$cimaCodigo = $csvArray[0];
    	$cimaId;

    	if (substr($cimaCodigo,4,1) === "e") {
    		$cimaCodigo = substr($cimaCodigo,0,4);
    		$cimaId = Cima::where('codigo',$cimaCodigo)->where('estado',2)->first()->id;
    	} else {
    		$cimaId = Cima::where('codigo',$cimaCodigo)->whereIn('estado',[1,3])->first()->id;
    	}

    	$vertienteName = $csvArray[1]; //lower case, strip accents
    	$vertiente = Vertiente::where('cima_id',$cimaId)->where('vertiente',$vertienteName)->first();

    	$vertiente->inicio = $csvArray[2];
    	$vertiente->dudas = $csvArray[3];
    	$vertiente->final = $csvArray[4];
    	$vertiente->observaciones = $csvArray[5];
    	$vertiente->lontitude_cima = $csvArray[6];
    	$vertiente->latitude_cima = $csvArray[7];
    	$vertiente->iframe = $csvArray[8];

		$vertiente->save();
    }
}
