<?php
require('../vendor/autoload.php');

use App\Router;

// function route($pattern, $function) {
//   return function ($path) use ($pattern, $function) {
//     $function($pattern, $path);
//   }
// }

$uri = $_SERVER['REQUEST_URI'];
if (preg_match("/^\/api(\/.*)?/", $uri)) {
  $router = new Router();
  $router->route();
  exit(0);
}

readfile('./index.html');


