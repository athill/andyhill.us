# andyhill.us

My personal website. Built with [React](https://reactjs.org/) and [PHP](https://www.php.net/)

## Developing

```
$ docker compose build

$ docker compose run --rm composer install

$ docker compose run --rm npm i

$ docker compose run --rm npm run build

$ docker compose up -d site
```

Site is available at http://localhost

Requires `REACT_APP_YOUTUBE_API_KEY` to be set for the Covers page to work.
