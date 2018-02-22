<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Services\InspireService;

class UpdateInspire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:inspire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the inspire page';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $service = new InspireService;
        $result = $service->update();
        // log result
        call_user_func_array([$this, $result['type']], [$result['message']]);
    }
}
