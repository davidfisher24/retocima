<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Faker\Factory as Faker;

use App\Logro;
use App\Cimero;
use App\Cima;

use App\Services\CimeroLogroService;
use App\Repositories\LogroRepository;

class CimeroLogroServiceTest extends TestCase
{


	public function setUp()
	{
	    parent::setUp();
	    $this->service = new CimeroLogroService(new LogroRepository(new Logro));
	    $this->faker = Faker::create();
	}

    /**
     * Tests getting a list of cima_id for cimero logros
     *
     * @return void
     */


    public function testGetCimeroLogrosCimaIds()
    {
        $cimero = $this->faker->numberBetween(1, Cimero::count());
        $logroIds = $this->service->getCimeroLogrosCimaIds($cimero);

        $this->assertInternalType('array', $logroIds);
        foreach ($logroIds as $id) $this->assertInternalType('int', $id);
    }

    /**
     * Tests getting a list of detailed logros for a cimero
     *
     * @return void
     */

    public function testGetCimeroWithDetailedLogros()
    {
        $cimero = $this->faker->numberBetween(1, Cimero::count());
        $logros = $this->service->getCimeroWithDetailedLogros($cimero);

        $this->assertContainsOnlyInstancesOf(Cima::class,$logros);
    }

    /**
     * Tests getting a ranking of all cimeros
     *
     * @return void
     */

    /*public function testGetRankingOfAllCimeros(){

        $ranking = $this->service->getRankingOfAllCimeros();
        $this->assertCount(Cimero::count(),$ranking);

    }*/

    /**
     * Tests getting a cimeros logros grouped by communidad
     *
     * @return void
     */

     public function testGetCimeroLogrosGroupedByCommunidad(){

        $cimero = $this->faker->numberBetween(1, Cimero::count());
        $logros = $this->service->getCimeroLogrosGroupedByCommunidad($cimero)->first()->first();

        $this->assertContainsOnlyInstancesOf(Logro::class,$logros);    
    }


}
