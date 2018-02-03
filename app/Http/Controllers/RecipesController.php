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

    private function getDataFromXml($xml=null) : array {
        $xml = is_null($xml) ? $this->xml : $xml;
        $recipes = [];
        foreach ($xml as $recipe) {
            $json = [
                'id' => (string) $recipe['id'],
                'instructions' => explode("\n", (string) $recipe->instructions)
            ];
            if ($recipe->modifications && strlen(trim((string) $recipe->modifications)) > 0) {
                $json['notes'] = explode("\n", (string) $recipe->modifications);
            }
            //// simple tags
            $tagnames = ['title', 'category','cuisine','rating','preptime','servings','cooktime'];
            foreach ($tagnames as $tagname) {
                $json[$tagname] = (string)$recipe->{$tagname};
            }
            //// instructions
            $ingredients = [];
            foreach ($recipe->{'ingredient-list'}->ingredient as $ingredient) {
                $ingredients[] = [
                    'amount' => (string) $ingredient->amount,
                    'unit' => (string) $ingredient->unit,
                    'item' => (string) $ingredient->item,
                    'key' => (string) $ingredient->key
                ];
            }
            $ingredients = [];
            foreach ($recipe->{'ingredient-list'}->ingredient as $ingredient) {
                $ingredients[] = [
                        'amount' => (string) $ingredient->amount,
                        'unit' => (string) $ingredient->unit,
                        'item' => (string) $ingredient->item,
                        'key' => (string) $ingredient->key
                ];
            }
            $json['ingredients'] = $ingredients;
            $recipes[] = $json;
        }
        return $recipes;
    }

 
}
