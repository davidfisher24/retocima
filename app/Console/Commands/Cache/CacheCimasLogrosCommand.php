<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

use App\Services\CimaLogroService;

class CacheCimasLogrosCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:cache:cimaslogros';

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
    public function __construct(CimaLogroService $cimaLogroService)
    {
        parent::__construct();
        $this->cimaLogroService = $cimaLogroService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = $this->cimaLogroService->getAllCimasRankedByLogros();
        Redis::set('cimaslogros', serialize($data));
    }
}
