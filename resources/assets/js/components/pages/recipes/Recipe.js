import React from 'react';
import { Col, Row } from 'react-bootstrap';


const recipeMetaMap = [
		{ header: 'Category', key: 'category' },
		{ header: 'Cuisine', key: 'cuisine' },
		{ header: 'Rating', key: 'rating' },
		{ header: 'Prep Time', key: 'preptime' },
		{ header: 'Servings', key: 'servings' },
		{ header: 'Cook Time', key: 'cooktime' }
	],
	ingredientItems = ['amount','unit','item'],
	unitReplacements = [
		[/^teaspoons?$/i, 'tsp.'],
		[/^tablespoons?$/i, 'Tbs.']
	],
	ingredientItemWidthMap = {
			item: 8,
			unit: 2,
			amount: 2
	};

const Links = ({ id }) => (
	<span>
		<a href={`/recipes/print/${id}`} target="_blank" rel="noopener">Print</a>&nbsp;|&nbsp; 
		<a href={`/recipes/export/${id}`} target="_blank" rel="noopener">Export</a> 
		<br /><br /> 
		<a href="#top">Return to top</a>
	</span>
);

const Recipe = ({ recipe, isScreenDisplay=true }) => (
	<div id={`recipe-${recipe.id}`} className="recipe"> 
		<h4 id={recipe.name} className="recipe-title">{recipe.title}</h4> 
		<div className="recipe-main"> 
			<dl className="recipe-meta dl-horizontal">
			{
				recipeMetaMap.map(map => <div key={map.key}><dt>{map.header}</dt><dd>{recipe[map.key]}</dd></div>)
			}
			</dl> 
			<h5>Ingredients:</h5> 
			<div className="container-fluid recipe-ingredients"> 
				<Row>
					<Col md={6} sm={12} >
					{
						recipe.ingredients.map((ingredient, i) => (
							<Row key={`${ingredient.item}-${i}`}>
							{
								ingredientItems.map((item, i) => {
									if (item == 'unit') {
										unitReplacements.forEach(function(replacement) {
											ingredient[item] = ingredient[item].replace(replacement[0], replacement[1]);
										});											
									}
									return <Col key={i} xs={ingredientItemWidthMap[item]}>{ ingredient[item] }</Col>;
								})
							}
							</Row>
						))
					}
					</Col>
				</Row> 
			</div> 
			<h5>Instructions:</h5> 
			{ recipe.instructions.map((instruction, i) => <div key={`${instruction}-${i}`}>{ instruction }</div>) }
			{ 'notes' in recipe && <div><h5>Notes</h5>{ recipe.notes.map((note, i) => <div key={`${note}-${i}`}>{ note }</div>) } </div> }
		</div> 
			{ isScreenDisplay && <Links id={recipe.id} /> }
    </div> 
);

export default Recipe;