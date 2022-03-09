const express = require('express');
require('dotenv').config();
const NodeCache = require('node-cache');

const RecipesService = require('./services/RecipesService');

const recipesService = new RecipesService();
const recipesCache = new NodeCache({ stdTTL: 60 * 60 * 24 });

const app = express();
const port = process.env.REACT_APP_SERVER_PORT;

app.get('/', (req, res) => {
  res.send('Hello World!');
});

// recipes
app.get('/recipes', async (req, res) => {
  try {
    let recipes = recipesCache.get('allRecipes');
    if (recipes == null) {
      console.log('fetching');
      recipes = await recipesService.get();
      recipesCache.set('allRecipes', recipes);
    }
    res.status(200).json(recipes);
  } catch (err) {
    console.log(err);
    res.sendStatus(500);
  }
});


app.listen(port, () => {
  console.log(`Example app listening on port ${port}`);
})
