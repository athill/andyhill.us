import { sortBy, uniqBy } from 'lodash';
import React from 'react';
import { Alert, Col, ControlLabel, Form, FormControl, FormGroup,  Row } from 'react-bootstrap';

import Recipe from './Recipe';

import './recipes.scss';

const Select = ({ id, label, onChange, options=[] }) => (
    <FormGroup controlId={id}>
      <ControlLabel>{ label }:</ControlLabel>
      {' '}
      <FormControl componentClass="select" onChange={onChange}>
      <option></option>
      {
      	options.map(({display, value}, i) => <option key={i} value={value}>{display}</option>)
      }
      </FormControl>
    </FormGroup>
);

const RecipesForm = ({ categories, cuisines, ingredients, onCategoryChange, onCuisineChange, onFilterChange, onIngredientChange }) => (
  <Form inline>
    <FormGroup controlId="filter">
      <ControlLabel>Text:</ControlLabel>
      {' '}
      <FormControl type="text" onChange={onFilterChange} />
    </FormGroup>
    {' '}
    <Select id="category" label="Category" options={categories} onChange={onCategoryChange} />
    {' '}
    <Select id="cuisine" label="Cuisine" options={cuisines} onChange={onCuisineChange} />
    {' '}
    <Select id="ingredient" label="Ingredient" options={ingredients} onChange={onIngredientChange} />
  </Form>
);

const Recipes = ({ recipes }) => (
	<div>
	{
		recipes.map(recipe => <Recipe key={recipe.id} recipe={recipe} />)
	}
	</div>
);

const maxOptionLength = 15;		//// max length of filter option display value
class RecipesPage extends React.Component {
    constructor(props) {
        super(props);

        this.state = { 
        	recipes: [],
        	loadingState: 'loading',
        	textFilter: null,
        	categoryFilter: null,
        	cuisineFilter: null,
        	ingredientFilter: null,
        	categories: [],
        	cuisines: [],
        	ingredients: []
        };
        this._filter = this._filter.bind(this);
        this._getOption = this._getOption.bind(this);
        this._onItemChange = this._onItemChange.bind(this);
        
    }


    _filter() {
    	let { categoryFilter, cuisineFilter, ingredientFilter, textFilter, recipes} = this.state;
    	if (!categoryFilter && !cuisineFilter && !ingredientFilter && !textFilter) {
    		return recipes;
    	}
    	const inString = (needle, haystack) => !needle ? true : haystack.toLowerCase().includes(needle.toLowerCase());
    	return recipes.filter(recipe => {
    		return inString(categoryFilter, recipe.category) &&
    			inString(cuisineFilter, recipe.cuisine) &&
    			inString(ingredientFilter, recipe.ingredients.map(ingredient => ingredient.item).join(' ')) &&
    			(inString(textFilter, recipe.category) || 
						inString(textFilter, recipe.cuisine) ||
						inString(textFilter, recipe.title) ||	
						inString(textFilter, recipe.instructions.join(' ')));
    	});
    }

    _onItemChange(key) {
    	return e => this.setState({ [key]: e.target.value });
    }

    _getOption(option) {
		//// remove everything after semi-colon
		const value =  option.split(';')[0];
		const display = (value.length > maxOptionLength) ? value.substring(0, maxOptionLength) + '...' : value;
		return {
			display, 
			value
		}
    }

    componentDidMount() {
    	fetch('/api/recipes')
    		.then(response => response.json().then(data => {
    			let categories = [],
    					cuisines = [],
    					ingredients = [];
    			const recipes = data.map(recipe => {
    				recipe.category && categories.push(this._getOption(recipe.category));
    				recipe.cuisine && cuisines.push(this._getOption(recipe.cuisine));
    				ingredients = ingredients.concat(recipe.ingredients.map(ingredient => this._getOption(ingredient.item)));
    				return { ...recipe, name: recipe.title.replace(/[^a-zA-Z0-9]/g, '')};
    			});
    			categories = sortBy(uniqBy(categories, 'value'), o => o.display);
    			cuisines = sortBy(uniqBy(cuisines, 'value'), o => o.display);
    			ingredients = sortBy(uniqBy(ingredients, 'value'), o => o.display);
    			this.setState({
    				loadingState: 'loaded',
    				categories,
    				cuisines,
    				ingredients,
    				recipes
    			});
    		}))
    		.catch(error => {
    			console.error(error);
    			this.setState({ loadingState: 'fail' });
    		});
    }

	render() {
		const recipes = this._filter();
		const { categories, cuisines, loadingState, ingredients } = this.state;
		return (
			<div>
				<h2 id="top">Recipes</h2>
				<RecipesForm 
					categories={categories} 
					cuisines={cuisines} 
					ingredients={ingredients} 
					onCategoryChange={this._onItemChange('categoryFilter')}
					onCuisineChange={this._onItemChange('cuisineFilter')}
					onFilterChange={this._onItemChange('textFilter')}
					onIngredientChange={this._onItemChange('ingredientFilter')}
				/>
				<ul id="recipe-list">
				{
					recipes.map(recipe => <li key={recipe.id}><a href={`#${recipe.name}`}>{ recipe.title }</a></li>)
				}
				</ul>
				{ loadingState === 'loading' && <div><i className="fa fa-refresh fa-cog fa-3x fa-fw"></i> Loading ...</div> }
				{ loadingState === 'loaded' && <Recipes recipes={recipes} /> }
				{ loadingState === 'fail' && <Alert bsStyle="danger">We&apos;re sorry, something went wrong.</Alert> }
			</div>		
		);		
	}
}

export default RecipesPage;