const fetch = (...args) => import('node-fetch').then(({default: fetch}) => fetch(...args));
const NodeCache = require('node-cache');

const youtubeCache = new NodeCache({ stdTTL: 60 * 60 * 24 });

class YoutubeService {

  async get() {
    const cache = youtubeCache.get('youtube');
    if (cache) {
      return cache;
    }
    console.log('fetching youtube');
    const key = process.env.REACT_APP_YOUTUBE_API_KEY;
    const maxResults = 1000;
    const response = await fetch(`https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=${maxResults}&playlistId=PL48l16ugvQtB6vQbtSpnePBWNm2sCmypf&key=${key}`)
    const json = response.json();
    youtubeCache.set('youtube', json);
    return json;
  }
}

module.exports = YoutubeService;
