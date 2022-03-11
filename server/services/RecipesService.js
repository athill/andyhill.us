const fetch = (...args) => import('node-fetch').then(({default: fetch}) => fetch(...args));
const parseStringPromise = require('xml2js').parseStringPromise;
const _ = require('lodash');
const NodeCache = require('node-cache');

const recipesCache = new NodeCache({ stdTTL: 60 * 60 * 24 });

const RECIPES_URL = 'https://www.dropbox.com/s/wclbvga9x50i0wv/recipes.xml?raw=1';
const maxOptionLength = 15;		//// max length of filter option display value

class RecipesService {

  async getXml() {
    const cache = recipesCache.get('xmlRecipes');
    if (cache) {
      return cache;
    }
    console.log('fetching xml');
    const response = await fetch(RECIPES_URL);
    const xml = await response.text();
    recipesCache.set('xmlRecipes', xml);
    return xml;
  }

  async get() {
    const cache = recipesCache.get('allRecipes');
    if (cache) {
      return cache;
    }
    console.log('building recipes')
    // helpers
    const getKey = (object, key) => object[key] && object[key][0] ? object[key][0].trim() : '';
    const getMultiline = (object, key) => {
      if (object[key] && object[key][0]) {
        let response = object[key][0].trim();
        response = response ? response.split('\n') : [];
        return response;
      } else {
        return [];
      }
    };
    // let's go
    const xml = await this.getXml();
    const { gourmetDoc : { recipe : xmlRecipes } } = await parseStringPromise(xml);
    let categories = [];
    let cuisines = [];
    let ingredients = [];
    const recipes = xmlRecipes.map(xmlRecipe => {
      const id = xmlRecipe['$'].id;;
      const recipe = {
        id,
        instructions: getMultiline(xmlRecipe, 'instructions'),
        notes: getMultiline(xmlRecipe, 'modifications'),
        servings: getKey(xmlRecipe, 'yields'),
        ingredients: xmlRecipe['ingredient-list'][0].ingredient.map(xmlIngredient => {
          const ingredients = {};
          ['amount', 'item', 'key', 'xml'].forEach(key => {
            ingredients[key] = getKey(xmlIngredient, key);
          });
          return ingredients;
        }),
      };
      ['category','cooktime','cuisine','link','preptime','rating','source','title'].forEach(tag => {
        recipe[tag] = getKey(xmlRecipe, tag);
      });
      recipe.category && categories.push(this._getOption(recipe.category));
			recipe.cuisine && cuisines.push(this._getOption(recipe.cuisine));
    	if (recipe.ingredients) {
        ingredients = ingredients.concat(recipe.ingredients.map(ingredient => this._getOption(ingredient.item)));
      }
      recipe.name = recipe.title.replace(/[^a-zA-Z0-9]/g, '')
      return recipe;
    });
    categories = _.sortBy(_.uniqBy(categories, 'value'), o => o.display);
    cuisines = _.sortBy(_.uniqBy(cuisines, 'value'), o => o.display);
    ingredients = _.sortBy(_.uniqBy(ingredients, 'value'), o => o.display);
    const response = {
      categories,
      cuisines,
      ingredients,
      recipes
    };
    recipesCache.set('allRecipes', response);
    return response;
  }

  _getOption(option) {
    //// remove everything after semi-colon
    const value =  option.split(';')[0];
    const display = (value.length > maxOptionLength) ? value.substring(0, maxOptionLength) + '...' : value;
    return {
      display,
      value
    };
  }
}

module.exports = RecipesService;
