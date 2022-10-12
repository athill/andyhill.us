<?php
namespace App;

use Pecee\SimpleRouter\SimpleRouter;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;
use App\Services\RecipeService;
use App\Services\YoutubeService;

class Router {
    public function route() {
        
        SimpleRouter::get('/api/recipes', function() {
            $recipeService = new RecipeService;
            $response = $recipeService->get();
            return SimpleRouter::response()->json($response, 0);
        });
        SimpleRouter::get('/api/recipes/{id}', function() {
            return 'recipe';
        });
        SimpleRouter::get('/api/recipes/{id}/print', function() {
            return 'recipe print';
        });
        SimpleRouter::get('/api/youtube', function() {
            $youtubeService = new YoutubeService();
            return SimpleRouter::response()->json($youtubeService->get(), 0);
        });
        try {
            SimpleRouter::start();
        } catch (NotFoundHttpException $e) {
            print('404');
        }
    }
}