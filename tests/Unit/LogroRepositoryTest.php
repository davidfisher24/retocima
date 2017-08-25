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

    /**
     * Tests saving a new logro
     *
     * @return void
     */


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

    /**
     * Tests  deleting a single logro
     *
     * @return void
     */

    public function testRemoveSingleLogro()
    {
        $logroId = $this->faker->numberBetween(1, Logro::count());
        $this->repo->removeSingleLogro($logroId);

        $this->assertDatabaseMissing('logros', [
            'id' => $logroId,
        ]); 
    }

    /**
     * Tests removing all the logros for one cimero
     *
     * @return void
     */

    public function testRemoveAllLogrosForACimero()
    {
        $cimeroId = $this->faker->numberBetween(1, Cimero::count());
        $this->repo->removeAllLogrosForACimero($cimeroId);

         $this->assertDatabaseMissing('logros', [
            'cimero_id' => $cimeroId,
        ]); 
    }

    /**
     * Tests counting logros by a foreign key
     *
     * @return void
     */

    public function testCountLogrosByAForeignKey()
    {
        $foreignKeys = array('cimero_id','cima_id','provincia_id','communidad_id','iberia_id');
        $foreignKey = $foreignKeys[rand(0,count($foreignKeys) - 1)];

        $logros = $this->repo->countLogrosByAForeignKey($foreignKey);
        $this->assertContainsOnlyInstancesOf(Logro::class,$logros);

        foreach($logros as $logro) {
            $this->assertArrayHasKey($foreignKey, $logro);
            $this->assertArrayHasKey('logros_count', $logro);
        }
    }

    /**
     * Tests counting logros by two foreign keys
     *
     * @return void
     */

    public function testGetLogrosGroupedByTwoForeignKeys()
    {
        $foreignKeys = array('cimero_id','cima_id','provincia_id','communidad_id','iberia_id');
        $index1 = rand(0,count($foreignKeys) - 1);

        $foreignKey1 = $foreignKeys[$index1];
        array_splice($foreignKeys, $index1, 1);
        $foreignKey2 = $foreignKeys[rand(0,count($foreignKeys) - 1)];

        $logros = $this->repo->getLogrosGroupedByTwoForeignKeys($foreignKey1,$foreignKey2);
        $this->assertContainsOnlyInstancesOf(Logro::class,$logros);

        foreach($logros as $logro) {
            $this->assertArrayHasKey($foreignKey1, $logro);
            $this->assertArrayHasKey($foreignKey1, $logro);
        }
    }

}
