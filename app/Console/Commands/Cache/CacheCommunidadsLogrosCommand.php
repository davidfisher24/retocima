<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

use App\Services\CommunidadLogroService;

class CacheCommunidadsLogrosCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:cache:communidadslogros';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Caches Communidads by logro ranking';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(CommunidadLogroService $communidadLogroService)
    {
        parent::__construct();
        $this->communidadLogroService = $communidadLogroService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = $this->communidadLogroService->getAllCommunidadsRankedByLogros();
        Redis::set('communidadslogros', serialize($data));
    }
}
