<?php
namespace App\Services;

use App\Utils;

class YoutubeService {
    private $cacheKey = 'youtube';
    private $expireSeconds = 86400;

    public function get() {
        $logger = Utils::getLogger();
        $cache = Utils::getCache();
        $cached = $cache->get($this->cacheKey);
        if (!is_null($cached)) {
            $logger->info('returning cached youtube');
            return json_decode($cached);
        }

        $logger->info('fetching youtube');
        $key = $_ENV['REACT_APP_YOUTUBE_API_KEY'];
        $maxResults = 50;
        $result = [];
        $baseUrl = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=$maxResults&playlistId=PL48l16ugvQtB6vQbtSpnePBWNm2sCmypf&key=$key";
        $logger->info($baseUrl);
        try {
            $contents = file_get_contents($baseUrl);
        } catch (Exception $e) {
            $logger->error($e->getMessage());
            throw $e;
        }
        $response = json_decode($contents, true);
        $result = array_merge($result, $response['items']);
        while (isset($response['nextPageToken'])) {
            $response = json_decode(file_get_contents($baseUrl . "&pageToken=" . $response['nextPageToken']), true);
            $result = array_merge($result, $response['items']);
        }
        $cache->set($this->cacheKey, json_encode($result), $this->expireSeconds);
        return $result;
    }
}