<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Cache;
use Log;

use App\Services\RecipesService;

class RecipesController extends Controller
{
    private $xml;
    private $data;

    public function __construct() {
        //// for debugging
        // Cache::clear(RecipesService::CACHE_KEY);
        if (!Cache::has(RecipesService::CACHE_KEY)) {
            $service = new RecipesService;
            $service->update();
        }
        $this->data = Cache::get(RecipesService::CACHE_KEY);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return $this->data;
    }

    public function print($id) {
        foreach ($this->data as $recipe) {
            if ($recipe['id'] === $id) {
                return view('print-recipe', ['recipe' => $recipe]);
            }
        }
    }

    public function export($id) {
        $content = $this->xml->xpath("//recipe[@id=$id]");
        return response($content[0]->asXml(), '200')->header('Content-Type', 'text/xml');
    }
}
