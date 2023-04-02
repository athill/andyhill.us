<?php
namespace App\Services;

use App\Utils;

class FoodService {
  public function get() {
    $path = $_ENV['REACT_APP_DATA_ROOT'] . '/food/data.json';
    $logger = Utils::getLogger();
    $logger->info('food path: ' . $path);
    $data = file_get_contents($path);
    return json_decode($data);
  }
}
