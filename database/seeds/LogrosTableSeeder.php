<?php

 /**
   * Logros Table seeder
   * @author David Fisher
   * Seeds from file '/database/raw/logros.csv'
   * Input csv should contain header row with the ids of the cimas
   * Completed logros are marked as 'X'. Non complete are null
*/

use Illuminate\Database\Seeder;
use App\Logro;
use App\Cima;

class LogrosTableSeeder extends Seeder
{

	// Stores the header row of the csv for referencing the code of the cima

	private $cimaCodeHeaders;


    /**
     * Run the database seeds.
     * Stores the cimas codes if $cimaCodeHeaders for the first row, and seedLogro() for every subsequent row
     *
     * @return void
     */

    public function run()
    {
        DB::table('logros')->truncate();
		$file = fopen(base_path('/database/raw/logros.csv'),"r");
		$headerParsed = false;

		while(! feof($file))
		{
			if (!$headerParsed) {
				$this->parseHeaders(fgetcsv($file));
				$headerParsed = true;
			} else {
				$this->seedLogros(fgetcsv($file));
			}
			
		}

		fclose($file);
    }

    /**
     * Parses cima code headers from the first line of the csv
     *
     * @param array $csvArray
     * @return void
     */

    private function parseHeaders($csvArray){
    	$this->cimaCodeHeaders = $csvArray;    
    }

    /**
     * Insert logros for one user into the database
     * Loops through the parameters ignoring the first (the id of the cimero)
     * For each logro found (not null) looks for the cima in the database and adds a row with id_cimero, id_cima, and codigo_cima
     *
     * @param array $csvArray
     * @return void
     */

    public function seedLogros($csvArray){
    	$id_cimero = $csvArray[0];
		for ($a = 1; $a < count($csvArray); $a++) {
			if ($csvArray[$a]) {
				$logro = new Logro();

				$codigoCima = $this->cimaCodeHeaders[$a];
				$cima = Cima::where('codigo',$codigoCima)->whereIn('estado',[1,3,4])->first();

            	$logro->cimero_id = $id_cimero;
            	$logro->cima_id = $cima->id;
            	$logro->cima_codigo = $cima->codigo;
                $logro->cima_estado = $cima->estado;
                $logro->provincia_id = $cima->provincia_id;
                $logro->communidad_id = $cima->communidad_id; 
                $logro->iberia_id = $cima->iberia_id;

            	$logro->save();
			}
		}    	
    }
}
