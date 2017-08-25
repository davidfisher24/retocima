<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Faker\Factory as Faker;

use App\Cima;
use App\Cimero;
use App\Logro;
use App\Services\PataNegraService;

class PataNegraServiceTest extends TestCase
{


	public function setUp()
	{
	    parent::setUp();
	    $this->service = new PataNegraService();
	    $this->faker = Faker::create();
	}

    /**
     * Tests getting a ranking of cimas by number of logros
     *
     * @return void
     */

    public function testGetPataNegraCimas()
    {
        $pataNegras = $this->service->getPataNegraCimas();
        $this->assertContainsOnlyInstancesOf(Cima::class,$pataNegras);

        foreach ($pataNegras as $pataNegra) {
            $array = $pataNegra->toArray();
            $this->assertEquals(true, $array['pata_negra']);
        }
    }

    /**
     * Tests getting cimeros ranked by completed pata negras
     *
     * @return void
     */


    public function testGetCimeroscountedByCompletedPataNegras()
    {
        $cimeros = $this->service->getCimeroscountedByCompletedPataNegras();

        foreach ($cimeros as $cimero) {
            $this->assertInternalType('array', $cimero);
            $this->assertInstanceOf(Cimero::class,$cimero["cimero"]);
            $this->assertInternalType('int', $cimero["pata_negras"]);
            $this->assertContainsOnlyInstancesOf(Logro::class,$cimero["pata_negras_completed"]);
        }
    
    }

    /**
     * Tests getting pata negras ranked by number of ascensions
     *
     * @return void
     */


    public function testGetPataNegrasRankedByAscensionss()
    {
        $pataNegras = $this->service->getPataNegrasRankedByAscensions();

        foreach ($pataNegras as $pataNegra) {
            $this->assertInstanceOf(Cima::class,$pataNegra["cima"]);
            $this->assertInternalType('int', $pataNegra["ascensions"]);
        }
    
    }

}
