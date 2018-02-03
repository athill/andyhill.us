<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

// use App\Services\Curl;
use App\Services\RecipesService;

class UpdateRecipes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:recipes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the file and cache for recipes';

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
        $service = new RecipesService;
        $result = $service->update();
        $this->info($result);
        //
        // $content = Curl::get('https://www.dropbox.com/s/wclbvga9x50i0wv/recipes.xml?raw=1');
        // dd($content);
    }
}
