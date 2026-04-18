<?php
namespace App\Services;

use App\Utils;

class RecipeService {
  private $cache;
  private $url = 'https://www.dropbox.com/scl/fi/ou8082ijzqmeeyim3ab0e/recipes.json?rlkey=msr2b0wfv7q7rsak6sm6ig0v8&st=saobss86&dl=0&raw=1';
  private $xml;
  private $logger;
  private $cacheKey = 'recipes';
  private $expireSeconds = 86400;

  public function __construct() {
    $this->logger =  Utils::getLogger();
    $this->cache = Utils::getCache();
  }

  public function get() {
    return $this->getData();
  }

  public function print($id) {
    $data = $this->getData();
    $this->logger->info('printing recipe', ['id' => $id]);
    foreach ($data as $recipe) {
      if (intval($recipe['id']) === intval($id)) {
          return $recipe;
      }
    }
    $this->logger->warning('recipe not found', ['id' => $id]);
    return null;
  }

  private function getData() {
    $cached = $this->cache->get($this->cacheKey);
    if (!is_null($cached)) {
        $this->logger->info('returning cached recipes');
        return json_decode($cached, true);
    }
    $response = json_decode(file_get_contents($this->url), true);

    $this->cache->set($this->cacheKey, json_encode($response), $this->expireSeconds);
    return $response;
  }
}
