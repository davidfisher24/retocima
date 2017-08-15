<?php

 /**
   * Vertientes Table seeder
   * @author David Fisher
   * Seeds from file '/database/raw/vertientes.csv'
   * Input csv should contain no header row
*/

use Illuminate\Database\Seeder;
use App\Cima;
use App\Vertiente;

class VertientesTableSeeder extends Seeder
{
    
	// Tracks the index for increment cima index
	private $lastCima;
	private $vertienteIndex = 1;

    /**
     * Run the database seeds.
     * Calls seedVertiente() for each row found
     *
     * @return void
     */

    public function run()
    {
      DB::table('vertientes')->truncate();
  		$file = fopen(base_path('/database/raw/vertientes.csv'),"r");

  		while(! feof($file))
  		{
  			$this->seedVertiente(fgetcsv($file));
  			
  		}

  		fclose($file);
    }

    /**
     * Insert single vertiente into the database
     * Loops through the parameters ignoring the first (the id of the cimero)
     * For each logro found (not null) looks for the cima in the database and adds a row with id_cimero, id_cima, and codigo_cima
     *
     * @param array $csvArray
     * @return void
     */

    public function seedVertiente($csvArray){

  		if ($this->lastCima != $csvArray[0]) {
  			$this->lastCima = $csvArray[0];
  			$this->vertienteIndex = 1;
  		} else {
  			$this->vertienteIndex = $this->vertienteIndex + 1;
  		}

  		$idCima = Cima::where('codigo',$csvArray[0])->whereIn('estado',[1,4])->first()->id;

  		$altitud = ($csvArray[2]) ? $csvArray[2] : null;
  		$desnivel = ($csvArray[3]) ? $csvArray[3] : null;
  		$longitud = ($csvArray[4]) ? $csvArray[4] : null;
  		$porcentage_medio = ($csvArray[5]) ? $csvArray[5] : null;
  		$porcentage_maximo = ($csvArray[6]) ? $csvArray[6] : null;
  		$apm = ($csvArray[7]) ? $csvArray[7] : null;

  		$vertiente = new Vertiente();

      	$vertiente->cima_id = $idCima;
      	$vertiente->cima_codigo = $csvArray[0];
      	$vertiente->index = $this->vertienteIndex;
      	$vertiente->vertiente = $csvArray[1];
      	$vertiente->altitud = $altitud;
      	$vertiente->desnivel = $desnivel;
      	$vertiente->longitud = $longitud;
      	$vertiente->porcentage_medio = $porcentage_medio;
      	$vertiente->porcentage_maximo = $porcentage_maximo;
      	$vertiente->apm = $apm;

  		$vertiente->save();	
    }
}
