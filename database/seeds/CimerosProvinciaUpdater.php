<?php

 /**
   * Cimeros Provincia Updater
   * @author David Fisher
   * Changes cimeros table. Updates cimero based on their provincia foreign key
*/

use Illuminate\Database\Seeder;
use App\Provincia;
use App\Cimero;

class CimerosProvinciaUpdater extends Seeder
{

	private $notFound;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $provincias = Provincia::select('nombre')->get()->pluck('nombre')->toArray();
        $this->notFound = DB::table('cimeros')->select(DB::raw('distinct provincia'))->whereNotIn('provincia',$provincias)->get()->pluck('provincia')->toArray();

        $count = Cimero::count();
        for ($i = 1; $i <= $count; $i++) {
        	$this->updateCimeroProvincia($i);
        }

    }

    /**
     * Updates the cimero province in the database
     *
     * @param integer $cimeroId
     * @return void
     */


    public function updateCimeroProvincia($cimeroId)
    {
    	$cimero = Cimero::find($cimeroId);
    	$province = $cimero->provincia;
    	$id = null;

    	if (!in_array($province, $this->notFound) && strpos($province, 'font') === false) 
            $id = Provincia::where('nombre',Cimero::find($cimeroId)->provincia)->first()->id;
    	else if ($province === 'Madrid') $id = 47;
    	else if ($province === 'Murcia') $id = 48;
    	else if ($province === 'Gipuzkoa' || $province === 'Guipuzcoa') $id = 39;
    	else if ($province === 'Coruña' || $province === 'La Coruña') $id = 42;
    	else if ($province === 'Baleares' || $province === 'Balears' || $province === 'Illes Balears') $id = 14;
    	else if ($province === 'Vizcaya') $id = 38;
    	else if ($province === 'Araba') $id = 37;


    	
    	if ($id) {
    		$cimero->provincia = $id;
   			$cimero->save();
    	}
    }
}
