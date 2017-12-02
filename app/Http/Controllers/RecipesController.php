<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use File;

class RecipesController extends Controller
{
    private $xml;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!$this->xml = simplexml_load_file(storage_path('data/recipes/recipes.xml'))){
           trigger_error('Error reading XML file',E_USER_ERROR);
        }
       return $this->getJsonFromXml();
    }

    private function getJsonFromXml($xml=null) : array {
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
