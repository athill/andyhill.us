<?php
namespace App;

use Pecee\SimpleRouter\SimpleRouter;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;
use App\Services\RecipeService;

class Router {
    public function route() {
        
        SimpleRouter::get('/api/recipes', function() {
            $recipeService = new RecipeService;
            return SimpleRouter::response()->json($recipeService->get());
        });
        SimpleRouter::get('/api/recipes/{id}', function() {
            return 'recipe';
        });
        SimpleRouter::get('/api/recipes/{id}/print', function() {
            return 'recipe print';
        });
        SimpleRouter::get('/api/youtube', function() {
            $recipeService = new RecipeService();
            return $recipeService->get();
        });
        try {
            SimpleRouter::start();
        } catch (NotFoundHttpException $e) {
            print('404');
        }
    }
}