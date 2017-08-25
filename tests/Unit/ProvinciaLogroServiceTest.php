<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Faker\Factory as Faker;

use App\Logro;
use App\Services\ProvinciaLogroService;
use App\Repositories\LogroRepository;

class ProvinciaLogroServiceTest extends TestCase
{


	public function setUp()
	{
	    parent::setUp();
	    $this->service = new provinciaLogroService(new LogroRepository(new Logro));
	    $this->faker = Faker::create();
	}

    /**
     * Tests getting a ranking of cimas by number of logros
     *
     * @return void
     */

    public function testGetAllProvinciasRankedByLogros(){

        $ranking = $this->service->getAllProvinciasRankedByLogros();
        $this->assertContainsOnlyInstancesOf(Logro::class,$ranking);
    }

}
