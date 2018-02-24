<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Services\InspireService;

class MakeInspire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:inspire {category} {title}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a new inspire file.';

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
        $category = $this->argument('category');
        $title = $this->argument('title');
        // make thing
        $service = new InspireService;
        $result = $service->makeInspire($category, $title);
    
    }
}
