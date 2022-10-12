const express = require('express');
require('dotenv').config();
var xpath = require('xpath');
const dom = require('xmldom').DOMParser

const RecipesService = require('./services/RecipesService');
const YoutubeService = require('./services/YoutubeService');

const recipesService = new RecipesService();
const youtubeService = new YoutubeService();

const app = express();
const port = process.env.REACT_APP_SERVER_PORT;

app.get('/', (req, res) => {
  res.send('Hello World!');
});

// recipes
app.get('/api/recipes', async (req, res) => {
  try {
    let recipeData = await recipesService.get();
    res.status(200).json(recipeData);
  } catch (err) {
    console.log(err);
    res.sendStatus(500);
  }
});

app.get('/api/recipes/:id', async (req, res) => {
  try {
    const { recipes } = await recipesService.get();
    const recipe = recipes.filter(recipe => recipe.id === req.params.id);
    if (recipe.length === 0) {
      res.sendStatus(404);
    }
    res.status(200).json(recipe[0]);
  } catch (err) {
    console.log(err);
    res.sendStatus(500);
  }
});

app.get('/export/recipes/:id', async (req, res) => {
  let xml = await recipesService.getXml();
  const doc = new dom().parseFromString(xml);
  const recipe = xpath.select(`//recipe[@id=${req.params.id}]`, doc);
  res.type('text/xml').send('<?xml version = "1.0"?>\n' + recipe.toString());
});

app.get('/api/youtube', async (req, res) => {
  try {
    const response = await youtubeService.get();
    res.status(200).json(response);
  } catch (err) {
    console.log(err);
    res.sendStatus(500);
  }
});

app.listen(port, () => {
  console.log(`Example app listening on port ${port}`);
})