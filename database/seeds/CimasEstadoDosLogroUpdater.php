<?php

 /**
   * Cimeros Estado 2 Logros Updater
   * @author David Fisher
   * Seeds from file '/database/raw/cimasEliminadas.csv'
   * Input csv should have no header row
   * Changes logros table. Updates cima_id and cima_estado for cimeros who completed the substituted cima
*/

use Illuminate\Database\Seeder;
use App\Logro;
use App\Cima;

class CimasEstadoDosLogroUpdater extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = fopen(base_path('/database/raw/cimasEliminadas.csv'),"r");

		while(! feof($file))
		{
			$this->updateLogrosForSubsitutedCima(fgetcsv($file));
		}

		fclose($file);
    }

    /**
     * Finds all the logros which refer to the old cima and subsitutes their cima_id and cima_estado
     *
     * @param array $csvArray
     * @return void
     */


    public function updateLogrosForSubsitutedCima($csvArray)
    {
    	
    	$cimaCodigo = $csvArray[0];
    	$newCimaId = Cima::where('codigo',$cimaCodigo)->where('estado',2)->first()->id;
    	
    	$cimeroIds = array();

    	foreach($csvArray as $key => $csvData) {
    		if($key !== 0 && $csvData) array_push($cimeroIds,$csvData);
    	}

    	$logros = Logro::where('cima_codigo',$cimaCodigo)->whereIn('cimero_id',$cimeroIds)->get();

    	foreach($logros as $logro){

    		$logro->cima_id = $newCimaId;
    		$logro->cima_estado = 2;

    		$logro->save();
    	}
    }
}
