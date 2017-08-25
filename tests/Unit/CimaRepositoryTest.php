<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Faker\Factory as Faker;

use App\Cima;
use App\Provincia;
use App\Communidad;
use App\Repositories\CimaRepository;

class CimaRepositoryTest extends TestCase
{

	public function setUp()
	{
	    parent::setUp();
	    $this->repo = new CimaRepository(new Cima());
	    $this->faker = Faker::create();
	}

    /**
     * Test getting a single cima by id.
     *
     * @return void
     */
    public function testGetCimaById()
    {
    	$id = $this->faker->numberBetween(1, Cima::count());
        $cima = $this->repo->getCimaById($id);
        $this->assertInstanceOf(Cima::class,$cima);
    }

    /**
     * Test getting all cimas in a province.
     *
     * @return void
     */

    public function testGetCimasInProvince()
    {
    	$id = $this->faker->numberBetween(1, Provincia::count());
        $cimas = $this->repo->getCimasInProvincia($id);
        $this->assertContainsOnlyInstancesOf(Cima::class,$cimas);

        foreach($cimas as $cima) {
            $array = $cima->toArray();
            $this->assertEquals($id, $array['provincia_id']);
        }
    }

    /**
     * Test getting all cimas in a communidad.
     *
     * @return void
     */

    public function testGetCimasInCommunidad()
    {
        $id = $this->faker->numberBetween(1, Communidad::count());
    	$cimas = $this->repo->getCimasInCommunidad($id);
        $this->assertContainsOnlyInstancesOf(Cima::class,$cimas);

        foreach($cimas as $cima) {
            $array = $cima->toArray();
            $this->assertEquals($id, $array['communidad_id']);
        }
    }

    /**
     * Test getting all pata negras.
     *
     * @return void
     */

    public function testGetPataNegraCimas(){
        $cimas = $this->repo->getPataNegraCimas();
        $this->assertContainsOnlyInstancesOf(Cima::class,$cimas);

        foreach($cimas as $cima) {
            $array = $cima->toArray();
            $this->assertEquals(true, $array['pata_negra']);
        }
    }

    /**
     * Test getting a communidad list with cimas count.
     *
     * @return void
     */

    /*public function testGetCommunidadListWithCimasCount(){
        $cimas = $this->repo->getCommunidadListWithCimasCount();
        $this->assertContainsOnlyInstancesOf(Cima::class,$cimas);

        foreach($cimas as $cima) {
            $this->assertArrayHasKey('total', $cima);
            $this->assertArrayHasKey('communidad_id', $cima);
            $this->assertInstanceOf(Communidad::class,$cima->communidad);
        }
    }*/

    /**
     * Test getting a province list with cimas count.
     *
     * @return void
     */

    /*public function testGetProvinciaListWithCimasCount(){
    	$id = $this->faker->numberBetween(1, Provincia::count());
        $cimas = $this->repo->getProvinciaListWithCimasCount($id);
        $this->assertContainsOnlyInstancesOf(Cima::class,$cimas);
        
        foreach($cimas as $cima) {
            $this->assertArrayHasKey('total', $cima);
            $this->assertArrayHasKey('provincia_id', $cima);
            $this->assertInstanceOf(Provincia::class,$cima->provincia);
        }
    }*/
}
