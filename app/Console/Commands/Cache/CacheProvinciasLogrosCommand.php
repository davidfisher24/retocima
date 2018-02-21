<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

use App\Services\ProvinciaLogroService;

class CacheProvinciasLogrosCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:cache:provinciaslogros';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Caches Provincias ranked by logros';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ProvinciaLogroService $provinciaLogroService)
    {
        parent::__construct();
        $this->provinciaLogroService = $provinciaLogroService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data =$this->provinciaLogroService->getAllProvinciasRankedByLogros();
        Redis::set('provinciaslogros', serialize($data));
    }
}
