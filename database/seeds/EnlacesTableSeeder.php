<?php

 /**
   * Enlaces Table seeder
   * @author David Fisher
   * Seeds from file '/database/raw/enlaces.csv'
   * Input csv should have no header row
   * Seeds the enlaces table
*/

use Illuminate\Database\Seeder;
use App\Cima;
use App\Vertiente;
use App\Enlace;

class EnlacesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Calls seedEnlace() for every row found
     *
     * @return void
     */


    public function run()
    {
    	DB::table('enlaces')->truncate();
		$file = fopen(base_path('/database/raw/enlaces.csv'),"r");

		while(! feof($file))
		{
			$this->seedEnlace(fgetcsv($file));
		}

		fclose($file);
    }

    /**
     * Finds the vertiente via the data passed and saves the enlaces to the table
     *
     * @param array $csvArray
     * @return void
     */

    public function seedEnlace($csvArray){
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

                $vertiente = Vertiente::where('cima_id',$cimaId)->where('index',(int )$csvArray[1])->first();

                if ($vertiente) {
                	$vertienteId = $vertiente->id;

                    $enlace = new Enlace();

			      	$enlace->cima_id = $cimaId;
			      	$enlace->vertiente_id = $vertienteId;
			      	$enlace->url = $csvArray[2];

			  		$enlace->save();
                } 
            }

        }
    	
    }
}
