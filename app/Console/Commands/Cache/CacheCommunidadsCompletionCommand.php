<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

use App\Services\AreaCompletionService;

class CacheCommunidadsCompletionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:cache:communidadscompletion';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Caches Communidad Completion Statistics';

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
        $data = $this->areaCompletionService->getCommunidadsOrderedByCompletions();
        Redis::set('communidadcompletion', serialize($data));
    }
}
