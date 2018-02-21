<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

use App\Services\AreaCompletionService;

class CacheProvinciasCompletionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:cache:provinciascompletion';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Caches Provincia Completion Statistics';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(AreaCompletionService $areaCompletionService)
    {
        parent::__construct();
        $this->areaCompletionService = $areaCompletionService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = $this->areaCompletionService->getProvincesOrderedByCompletions();
        Redis::set('provinciacompletion', serialize($data));
    }
}
