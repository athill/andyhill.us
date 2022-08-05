const fetch = (...args) => import('node-fetch').then(({default: fetch}) => fetch(...args));
const NodeCache = require('node-cache');

const youtubeCache = new NodeCache({ stdTTL: 60 * 60 * 24 });

class YoutubeService {

  async get() {
    // const cache = youtubeCache.get('youtube');
    // if (cache) {
    //   return cache;
    // }
    console.log('fetching youtube');
    const key = process.env.REACT_APP_YOUTUBE_API_KEY;
    const maxResults = 50;
    let results = [];
    const baseUrl=`https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=${maxResults}&playlistId=PL48l16ugvQtB6vQbtSpnePBWNm2sCmypf&key=${key}`
    let response = await fetch(baseUrl)
    let json = await response.json();
    results = results.concat(json.items); 
    while (json.nextPageToken) {
      console.log('in here');
      response = await fetch(`${baseUrl}&pageToken=${json.nextPageToken}`);
      json = await response.json();
      results = results.concat(json.items);     
    }
    youtubeCache.set('youtube', json);
    // console.log(results);
    console.log('results', results.length);
    return results;
  }
}

module.exports = YoutubeService;
