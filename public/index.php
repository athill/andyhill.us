<?php
require('../vendor/autoload.php');

use Pecee\SimpleRouter\SimpleRouter;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;
use App\Services\RecipeService;

// function route($pattern, $function) {
//   return function ($path) use ($pattern, $function) {
//     $function($pattern, $path);
//   }
// }

$uri = $_SERVER['REQUEST_URI'];
if (preg_match("/^\/api(\/.*)?/", $uri)) {
  SimpleRouter::get('/api/recipes', function() {
    return 'recipes';
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

  exit(0);
}

readfile('./index.html');


