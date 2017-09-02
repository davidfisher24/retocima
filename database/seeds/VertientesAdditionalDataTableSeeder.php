<?php

 /**
   * Vertientes Data Table seeder
   * @author David Fisher
   * Seeds from file '/database/raw/vertientesData.csv'
   * Input csv should have no header row
   * Seeds additional data to the vertientes table
*/

use Illuminate\Database\Seeder;
use App\Cima;
use App\Vertiente;

class VertientesAdditionalDataTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Calls seedVertienteData() for every row found
     *
     * @return void
     */

    public $error_log = array();

    public function run()
    {
		$file = fopen(base_path('/database/raw/vertientesData.csv'),"r");

		while(! feof($file))
		{
			$this->seedVertienteData(fgetcsv($file));
		}

		fclose($file);
        echo implode(",",$this->error_log);
    }

    /**
     * Finds the vertiente via the data passed and saves the additional data to the appropriate model
     *
     * @param array $csvArray
     * @return void
     */

    public function seedVertienteData($csvArray){
        if (is_array($csvArray)) {
            $cimaCodigo = $csvArray[0];
            $cimaId = null;;

            if (substr($cimaCodigo,4,1) === "e") {
                $cimaCodigo = substr($cimaCodigo,0,4);
                $cima = Cima::where('codigo',$cimaCodigo)->where('estado',2)->first();
                if ($cima) $cimaId = $cima->id;
            } else {
                $cima = Cima::where('codigo',$cimaCodigo)->whereIn('estado',[1,3])->first();
                if ($cima) $cimaId = $cima->id;
            }

            if ($cimaId) {

                $vertiente = Vertiente::where('cima_id',$cimaId)->where('index',(int )$csvArray[1] + 1)->first();



                if ($vertiente) {
                    if($csvArray[2]) $vertiente->inicio = $csvArray[2];
                    if($csvArray[3]) $vertiente->dudas = $csvArray[3];
                    if($csvArray[4]) $vertiente->final = $csvArray[4];
                    if($csvArray[5]) $vertiente->observaciones = $csvArray[5];
                    if($csvArray[6]) $vertiente->longitude_cima = $csvArray[6];
                    if($csvArray[7]) $vertiente->latitude_cima = $csvArray[7];
                    if($csvArray[8]) $vertiente->iframe = $csvArray[8];

                    $vertiente->save();
                } else {
                    array_push($this->error_log,$csvArray[0]);
                } 
            }

        }
    	
    }
}
