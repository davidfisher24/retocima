<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;

class WriteThroughLogros implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @param response
     * @return void
     */
    public function handle(Request $request)
    {   
        $cimaId = $request->has('cima') ? $request->get('cima') :  json_decode($request->get('logro'))->cima_id;
        // Ranking is the most important here and should always be kept up to date
        // Cimero provincias and communidads completadas are the slowest to calculate
    }
}
