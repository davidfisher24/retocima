<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Faker\Factory as Faker;

use App\Provincia;
use App\Communidad;
use App\Iberia;
use App\Cimero;
use App\Cima;
use App\Services\AreaCompletionService;

class AreaCompletionServiceTest extends TestCase
{


	public function setUp()
	{
	    parent::setUp();
	    $this->service = new AreaCompletionService();
	    $this->faker = Faker::create();
	}

    /**
     * Tests getting a cimeros completed provinces
     *
     * @return void
     */

    public function testGetCimerosCompletedProvinces()
    {
        $cimero = $this->faker->numberBetween(1, Cimero::count());
        $provinces = $this->service->getCimerosCompletedProvinces($cimero);
        $this->assertContainsOnlyInstancesOf(Cima::class,$provinces);

    }

    /**
     * Tests getting cimeros ranked by completed communidads
     *
     * @return void
     */

    public function testGetCimerosCompletedCommunidads()
    {
        $cimero = $this->faker->numberBetween(1, Cimero::count());
        $communidads = $this->service->getCimerosCompletedCommunidads($cimero);
        $this->assertContainsOnlyInstancesOf(Communidad::class,$communidads);

    }

    /**
     * Tests getting cimeros ranked by completed iberias
     *
     * @return void
     */

    public function testGetCimerosCompletedIberias()
    {
        $cimero = $this->faker->numberBetween(1, Cimero::count());
        $iberias = $this->service->getCimerosCompletedIberias($cimero);
        $this->assertContainsOnlyInstancesOf(Iberia::class,$iberias);

    }

    /**
     * Tests getting cimeros who have completed a province
     *
     * @return void
     */

    public function testGetUsersWhoHaveCompletedAProvince()
    {
        $provincia = $this->faker->numberBetween(1, Provincia::count());
        $provincias = $this->service->getUsersWhoHaveCompletedAProvince($provincia);
        $this->assertContainsOnlyInstancesOf(Cimero::class,$provincias);

    }

    /**
     * Tests getting cimeros who have completed a communidad
     *
     * @return void
     */

    public function testGetUsersWhoHaveCompletedACommunidad()
    {
        $communidad = $this->faker->numberBetween(1, Communidad::count());
        $communidads = $this->service->getUsersWhoHaveCompletedACommunidad($communidad);
        $this->assertContainsOnlyInstancesOf(Cimero::class,$communidads);

    }

    /**
     * Tests getting cimeros who have completed an iberia
     *
     * @return void
     */

    public function testGetUsersWhoHaveCompletedAnIberia()
    {
        $iberia = $this->faker->numberBetween(1, Iberia::count());
        $iberias = $this->service->getUsersWhoHaveCompletedACommunidad($iberia);
        $this->assertContainsOnlyInstancesOf(Cimero::class,$iberias);

    }




}
