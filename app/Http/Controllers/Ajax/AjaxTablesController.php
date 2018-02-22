<?php

namespace App\Http\Controllers\Ajax;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

use App\Services\CimeroLogroService;
use App\Services\CimaLogroService;
use App\Services\ProvinciaLogroService;
use App\Services\CommunidadLogroService;
use App\Services\AreaCompletionService;

class AjaxTablesController extends Controller
{


	/**
    * Loads service lasses required
    * 
    * @param service $cimeroLogroService
    * @param service $cimaLogroService
    * @param service $provinciaLogroService
    *
    * @return void
    */

    public function __construct(CimeroLogroService $cimeroLogroService, CimaLogroService $cimaLogroService, ProvinciaLogroService $provinciaLogroService, CommunidadLogroService $communidadLogroService, AreaCompletionService $areaCompletionService)
    {
        $this->cimeroLogroService = $cimeroLogroService;
        $this->cimaLogroService = $cimaLogroService;
        $this->provinciaLogroService = $provinciaLogroService;
        $this->communidadLogroService = $communidadLogroService;
        $this->areaCompletionService = $areaCompletionService;
    }

    /**
     * Return array of all cimeros ranking, and a column structure for the table.
     *
     * @return array Table Data
     */

    public function baseCimeroRanking()
    {

        $cimeros = $this->cimeroLogroService->getRankingOfAllCimeros();
        
        $columns = array(
            array("field" => 'ranking', "title" => ''),
            array("field" => 'id', "title" => 'No. Cimero'),
            array("field" => 'nombre', "title" => 'Nombre'),
            array("field" => 'provincia', "title" => 'Provincia'),
            array("field" => 'logros_count', "title" => 'Logros'),
        );

        $links = array(
            "nombre" => "cimeropublicdetails/",
        );
        
        return array(
            "dataObject" => $cimeros->flatten(),
            "columns" =>  $columns,
            "filters" => array(
                "Provincia" => "provincia",
            ),
            "searches" => array(
                "Nombre" => 'nombre',
                "Provincia" => "provincia",
            ),
            "links" => $links,
        );
    }

    /**
     * Returns provinces started statistics.
     *
     * @return Table object
     */


    
    public function getCimerosWithProvinciasWithAtLeastOneLogro()
    {
        
        $cimeros = $this->cimeroLogroService->getCimerosWithProvinciasWithAtLeastOneLogro();

        $columns = array(
            array("field" => 'ranking', "title" => ''),
            array("field" => 'id', "title" => 'No. Cimero'),
            array("field" => 'nombre', "title" => 'Nombre'),
            array("field" => 'count', "title" => 'Logros'),
        );

        $links = array(
            "nombre" => "cimeropublicdetails/",
        );

        return array(
            "dataObject" => $cimeros->flatten(),
            "columns" =>  $columns,
            "searches" => array(
                "Nombre" => 'nombre',
            ),
            "filters" => array(),
            "links" => $links,
        );
    }



    /**
     * Returns cima by ascensiones statistics.
     *
     * @return Table object
     */
    

    public function getAllCimasRankedByLogros()
    {
        $cimas = $this->cimaLogroService->getAllCimasRankedByLogros();

        $columns = array(
            array("field" => 'ranking', "title" => ''),
            array("field" => 'provincia', "title" => 'Provincia'),
            array("field" => 'codigo', "title" => 'Codigo'),
            array("field" => 'nombre', "title" => 'Cima'),
            array("field" => 'logros_count', "title" => 'Ascensiones'),
        );

        $links = array(
            "nombre" => "detallescima/",
        );

        return array(
            "dataObject" => $cimas->flatten(),
            "columns" =>  $columns,
            "filters" => array(
                "Provincia" => "provincia",
            ),
            "searches" => array(
                "Nombre" => 'nombre',
            ),
            "links" => $links,
        );
    }

    /**
     * Returns provinces by ascensiones.
     *
     * @return Table object
     */
    

    public function getAllProvinciasRankedByLogros()
    {
        $provincias = $this->provinciaLogroService->getAllProvinciasRankedByLogros();

        $columns = array(
            array("field" => 'ranking', "title" => ''),
            array("field" => 'nombre', "title" => 'Provincia'),
            array("field" => 'logros_count', "title" => 'Ascensiones'),
        );

        return array(
            "dataObject" => $provincias->flatten(),
            "columns" =>  $columns,
            "filters" => array(
                "Nombre" => "nombre",
            ),
            "searches" => array(), 
        );
    }

    /**
     * Returns communidads by acensiones statsitcs.
     *
     * @return Table object
     */
    

    public function getAllCommunidadsRankedByLogros()
    {
        $communidads = $this->communidadLogroService->getAllCommunidadsRankedByLogros();

        $columns = array(
            array("field" => 'ranking', "title" => ''),
            array("field" => 'nombre', "title" => 'Comunidad'),
            array("field" => 'logros_count', "title" => 'Ascensiones'),
        );

        return array(
            "dataObject" => $communidads->flatten(),
            "columns" =>  $columns,
            "filters" => array(
                "Nombre" => "nombre",
            ),
            "searches" => array(),
        );
    }

    /**
     * Returns cimeros ranking inside a province/communidad/iberia
     *
     * @param $request requests with keys and id filter
     * example  $filter = array('key' => 'communidad_id', 'id' => 16);
     *
     * @return Table object
     */
    

    public function getRankingOfAllCimeros($filter, $id)
    {
        $filter = array("key" => $filter, 'id' => $id);

        $cimeros = $this->cimeroLogroService->getRankingOfAllCimeros($filter = $filter);

        $columns = array(
            array("field" => 'ranking', "title" => ''),
            array("field" => 'id', "title" => 'No. Cimero'),
            array("field" => 'nombre', "title" => 'Nombre'),
            array("field" => 'logros_count', "title" => 'Logros'),
        );

        $links = array(
            "nombre" => "cimeropublicdetails/",
        );

        return array(
            "dataObject" => $cimeros->flatten(),
            "columns" =>  $columns,
            "filters" => array(),
            "searches" => array(),
            "links" => $links,
        );
    }

    /**
     * Returns provinces by completion table
     *
     * @return Table object
     */

    public function getRankingOfProvincesByCompletion()
    {
        $provinces = $this->areaCompletionService->getProvincesOrderedByCompletions();
        
        $columns = array(
            array("field" => 'ranking', "title" => ''),
            array("field" => 'nombre', "title" => 'Provincia'),
            array("field" => 'completions', "title" => 'Completada'),
        );

        return array(
            "dataObject" => $provinces->flatten(),
            "columns" =>  $columns,
            "filters" => array(),
            "searches" => array(),
        );
    }

    /**
     * Returns communidads by completions table
     *
     * @return Table object
     */

    public function getRankingOfCommunidadsByCompletion()
    {
        $communidads = $this->areaCompletionService->getCommunidadsOrderedByCompletions();
        
        $columns = array(
            array("field" => 'ranking', "title" => ''),
            array("field" => 'nombre', "title" => 'Communidad'),
            array("field" => 'completions', "title" => 'Completada'),
        );

        return array(
            "dataObject" => $communidads->flatten(),
            "columns" =>  $columns,
            "filters" => array(),
            "searches" => array(),
        );
    }

    /**
     * Returns cimeros by completed provinces table object
     *
     * @return Table object
     */

    public function getRankingOfCimerosByProvinciaCompletion()
    {
        $cimeros = $this->areaCompletionService->getCimerosOrderByCompletedProvinces();
        
        $columns = array(
            array("field" => 'ranking', "title" => ''),
            array("field" => 'id', "title" => 'No. Cimero'),
            array("field" => 'nombre', "title" => 'Cimero'),
            array("field" => 'count', "title" => 'Prov. Comp.'),
        );

        $links = array(
            "nombre" => "cimeropublicdetails/",
        );

        return array(
            "dataObject" => $cimeros->flatten(),
            "columns" =>  $columns,
            "filters" => array(),
            "searches" => array(),
            "links" => $links,
        );
    }

    /**
     * Returns cimeros by completed communidads table object
     *
     * @return Table object
     */

    public function getRankingOfCimerosByCommunidadCompletion()
    {
         $cimeros = $this->areaCompletionService->getCimerosOrderByCompletedCommunidads();

         $columns = array(
            array("field" => 'ranking', "title" => ''),
            array("field" => 'id', "title" => 'No. Cimero'),
            array("field" => 'nombre', "title" => 'Cimero'),
            array("field" => 'count', "title" => 'CCAA. Comp.'),
        );

        $links = array(
            "nombre" => "cimeropublicdetails/",
        );

        return array(
            "dataObject" => $cimeros->flatten(),
            "columns" =>  $columns,
            "filters" => array(),
            "searches" => array(),
            "links" => $links,
        );
    }  

}
