import React from 'react';
import { Col, Row } from 'react-bootstrap';

import Recipe from './Recipe';

import './recipes.scss';

const Recipes = ({ recipes }) => (
	<div>
	{
		recipes.map(recipe => <Recipe key={recipe.id} recipe={recipe} />)
	}
	</div>
);


class RecipesPage extends React.Component {
    constructor(props) {
        super(props);

        this.state = { 
        	recipes: [],
        	text: null,
        	category: null,
        	cuisine: null,
        	ingredient: null
        };
        this._filter = this._filter.bind(this);
        // this._menuClose = this._menuClose.bind(this);
    }

    _filter() {
    	return this.state.recipes;
    }

    componentDidMount() {
    	fetch('/api/recipes')
    		.then(response => response.json().then(data => {
    			this.setState({
    				recipes: data.map(recipe => ({ ...recipe, name: recipe.title.replace(/[^a-zA-Z0-9]/g, '')}))
    			});
    		}))
    		.catch(error => {
    			console.error(error);
    		});
    }

	render() {
		const recipes = this._filter();
		return (
			<div>
				<h2 id="top">Recipes</h2>

				<ul id="recipe-list">
				{
					recipes.map(recipe => <li key={recipe.id}><a href={`#${recipe.name}`}>{ recipe.title }</a></li>)
				}
				</ul>
				<Recipes recipes={recipes} />
			</div>		
		);		
	}
}


export default RecipesPage;