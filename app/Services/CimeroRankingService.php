<?php

namespace App\Services;

use App\Cimero;
use App\Logro;

class CimeroRankingService 
{

	/**
	 * Create a new service instance.
	 *
	 * @return void
	 */
    public function __construct()
    {
    	
    }

    /**
     * Returns all cimeros ranked by numero of logros
     *
     * @collection cimeros ranked by logros
     */

	public function getRankingOfAllCimeros(){
        return Cimero::withCount('logros')->get()->sortByDesc('logros_count');
	}
}