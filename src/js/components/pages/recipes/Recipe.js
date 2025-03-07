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
		<a href={`/print/recipes/${id}`} target="_blank" rel="noreferrer">Print</a>&nbsp;|&nbsp;
		<a href={`/export/recipes/${id}`} target="_blank" rel="noreferrer">Export</a>
		<br /><br />
		<a href="#top">Return to top</a>
	</span>
);

const Source = ({ recipe }) => {
  if (recipe.link && recipe.source) {
    return <div><dt>Source</dt><dd><a href={recipe.link} target="_blank" rel="noreferrer">{recipe.source}</a></dd></div>
  } else if (recipe.link) {
    const display = recipe.link.replace(/\w+:\/\/([^/]+).*/, '$1');
    return <div><dt>Source</dt><dd><a href={recipe.link} target="_blank" rel="noreferrer">{display}</a></dd></div>
  } else if (recipe.source) {
    return <div><dt>Source</dt><dd>{recipe.source}</dd></div>
  } else {
    return null;
  }
};


const Recipe = ({ recipe, isScreenDisplay=true }) => (
	<div id={`recipe-${recipe.id}`} className="recipe">
		<h4 id={recipe.name} className="recipe-title">{recipe.title}</h4>
		<div className="recipe-main">
			<dl className="recipe-meta dl-horizontal">
			{
				recipeMetaMap.map(map => <div key={map.key}><dt>{map.header}</dt><dd>{recipe[map.key]}</dd></div>)
			}
            <Source recipe={recipe} />
			</dl>
			<h5>Ingredients:</h5>
			<div className="container-fluid recipe-ingredients">
				<Row>
					<Col>
          <table className='recipe-ingredients'>
					{
						recipe.ingredients.map((ingredient, i) => (
							<tr key={`${ingredient.item}-${i}`}>
							{
								ingredientItems.map((item, i) => {
									if (item === 'unit' && item.unit) {
										unitReplacements.forEach(function(replacement) {
											ingredient[item] = ingredient[item].replace(replacement[0], replacement[1]);
										});
									}
									return <td key={i}>{ ingredient[item] || '' }</td>;
								})
							}
							</tr>
						))
					}
          </table>
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
