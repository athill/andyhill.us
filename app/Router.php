<?php
namespace App;

use Pecee\SimpleRouter\SimpleRouter;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;
use App\Services\RecipeService;
use App\Services\YoutubeService;
use App\Services\FoodService;

class Router {
  public function route() {

    SimpleRouter::get('/api/recipes', function() {
        $recipeService = new RecipeService;
        $response = $recipeService->get();
        return SimpleRouter::response()->json($response, 0);
    });
    SimpleRouter::get('/export/recipes/{id}', function($id) {
        $recipeService = new RecipeService;
        $response = $recipeService->export($id);

        SimpleRouter::response()->header('Content-Type: text/xml');
        echo $response;
        exit(0);
    });
    SimpleRouter::get('/api/recipes/{id}', function($id) {
        $recipeService = new RecipeService;
        $response = $recipeService->print($id);
        return SimpleRouter::response()->json($response, 0);
    });
    SimpleRouter::get('/api/youtube', function() {
        $youtubeService = new YoutubeService();
        return SimpleRouter::response()->json($youtubeService->get(), 0);
    });
    SimpleRouter::get('/api/food', function() {
      $foodService = new FoodService();
      return SimpleRouter::response()->json($foodService->get(), 0);
    });


    SimpleRouter::get('/data', function ($path) {
      $path = preg_replace('#/$#', '', $path);
      $basename = basename($path);
      $ext = pathinfo($path, PATHINFO_EXTENSION);
      if ($ext === 'jpg') {
        header("Content-type: image/jpeg");
      }
      $image = $_ENV['REACT_APP_DATA_ROOT'].preg_replace('#/data#', '', $path);
      readfile($image);
      exit(0);
    })->setMatch('#/data/.*#');
    // SimpleRouter::get('/api/info', function() {
    //     phpinfo();
    //     exit(0);
    // });
    try {
        SimpleRouter::start();
    } catch (NotFoundHttpException $e) {
        print('404');
    }
  }
}
