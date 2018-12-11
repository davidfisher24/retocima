<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Cimero;

class cacheRanking extends Command
{
    protected $signature = 'cache:ranking';
    protected $description = 'Cache ranking from db to json';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        foreach(Cimero::all() as $cimero) $cimero->calculateLogros();
        echo("Done");
    }
}
