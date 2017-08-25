<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Faker\Factory as Faker;

use App\Logro;
use App\Services\CommunidadLogroService;
use App\Repositories\LogroRepository;

class CommunidadLogroServiceTest extends TestCase
{


	public function setUp()
	{
	    parent::setUp();
	    $this->service = new CommunidadLogroService(new LogroRepository(new Logro));
	    $this->faker = Faker::create();
	}

    /**
     * Tests getting a ranking of cimas by number of logros
     *
     * @return void
     */

    public function testGetAllCommunidadsRankedByLogros(){

        $ranking = $this->service->getAllCommunidadsRankedByLogros();
        $this->assertContainsOnlyInstancesOf(Logro::class,$ranking);
    }

}
