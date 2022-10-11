<?php
namespace App\Services;

class YoutubeService {
    public function get() {
        // console.log('fetching youtube');
        $key = $_ENV['REACT_APP_YOUTUBE_API_KEY'];
        $maxResults = 1000;
        $url = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=$maxResults&playlistId=PL48l16ugvQtB6vQbtSpnePBWNm2sCmypf&key=$key";
        $json = file_get_contents($url);
        return $json;
        // const response = await fetch(`https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=${maxResults}&playlistId=PL48l16ugvQtB6vQbtSpnePBWNm2sCmypf&key=${key}`)
        // const json = response.json();
        // youtubeCache.set('youtube', json);
        // return json;        
    }
}