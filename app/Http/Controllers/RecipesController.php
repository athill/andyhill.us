<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use File;

class RecipesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recipesxml = File::get(storage_path('data/recipes/recipes.xml'));
        dd($recipesxml);
        return ['foo' => 'bar'];
    }

 
}
