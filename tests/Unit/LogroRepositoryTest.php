<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Faker\Factory as Faker;

use App\Logro;
use App\Cimero;
use App\Cima;
use App\Repositories\LogroRepository;

class LogroRepositoryTest extends TestCase
{

    use DatabaseTransactions;

	public function setUp()
	{
	    parent::setUp();
	    $this->repo = new LogroRepository(new Logro());
	    $this->faker = Faker::create();
	}

    /**
     * Test getting logros by cimeroId
     *
     * @return void
     */

    public function testGetLogrosByCimeroId()
    {
        $id = $this->faker->numberBetween(1, Cimero::count());
        $logros = $this->repo->getLogrosByCimeroId($id);
        $this->assertContainsOnlyInstancesOf(Logro::class,$logros);

        foreach($logros as $logro) {
            $array = $logro->toArray();
            $this->assertEquals($id, $array['cimero_id']);
        }
    }

    public function testSaveNewLogro() 
    {

        $cimero = $this->faker->numberBetween(1, Cimero::count());
        $cima = Cima::find($this->faker->numberBetween(1, Cima::count()));
        $this->repo->saveNewLogro($cimero,$cima);

        $this->assertDatabaseHas('logros', [
            'cimero_id' => $cimero, 
            'cima_id' => $cima->id,
            'cima_codigo' => $cima->codigo,
            'cima_estado' => $cima->estado,
            'provincia_id' => $cima->provincia_id, 
            'communidad_id' => $cima->communidad_id,
            'iberia_id' => $cima->iberia_id,
        ]);  
    }
}
