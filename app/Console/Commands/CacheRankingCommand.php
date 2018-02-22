<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

use App\Services\CimeroLogroService;

class CacheRankingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:cache:ranking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Caches Base Ranking Statistics';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(CimeroLogroService $cimeroLogroService)
    {
        parent::__construct();
        $this->cimeroLogroService = $cimeroLogroService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = $this->cimeroLogroService->getRankingOfAllCimeros();
        Redis::set('ranking', serialize($data));
    }
}