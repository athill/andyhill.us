<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Services\NewsService;

class UpdateNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:news {category?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update news feeds';

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
        $service = new NewsService;
        $result = $service->update($category);
        // log result
        call_user_func_array([$this, $result['type']], [$result['message']]);
    }
}
