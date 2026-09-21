const recipeMetaMap = [
		{ header: 'Category', key: 'category' },
		{ header: 'Cuisine', key: 'cuisine' },
		{ header: 'Rating', key: 'rating' },
		{ header: 'Prep Time', key: 'preptime' },
		{ header: 'Servings', key: 'servings' },
		{ header: 'Cook Time', key: 'cooktime' }
	],
	unitReplacements = [
		[/^teaspoons?$/i, 'tsp.'],
		[/^tablespoons?$/i, 'Tbs.']
	];

const Links = ({ id }) => (
	<span>
		<a href={`/print/recipes/${id}`} target="_blank" rel="noreferrer">Print</a>
	</span>
);

const Source = ({ recipe }) => {
  if (recipe.link && recipe.source) {
    return <a href={recipe.link} target="_blank" rel="noreferrer">{recipe.source}</a>
  } else if (recipe.link) {
    const display = recipe.link.replace(/\w+:\/\/([^/]+).*/, '$1');
    return <a href={recipe.link} target="_blank" rel="noreferrer">{display}</a>
  } else if (recipe.source) {
    return recipe.source
  } else {
    return null;
  }
};


const Recipe = ({ recipe, isScreenDisplay=true }) => (
	<div id={`recipe-${recipe.id}`} className="recipe">
		<h4 id={recipe.name}>{recipe.title}</h4>
		<div>
			<table>
        <tbody>
          {
            recipeMetaMap.map(map => (
              <tr key={map.key}>
                <th scope="row" className="text-left">{map.header}</th>
                <td>{recipe[map.key]}</td>
              </tr>
            ))
          }
          <tr>
            <th scope="row" className="text-left">Source</th>
            <td><Source recipe={recipe} /></td>
          </tr>
        </tbody>
			</table>
			<h5>Ingredients:</h5>
			<div className="container-fluid recipe-ingredients">
          <table className="table-auto">
            <tbody>
					{
						recipe.ingredients.map(({ amount, unit, item }, i) => (
							<tr key={`${item}-${i}`}>
                <td className="p-1">{ amount?.replace(' ', '\u00A0') || '' }</td>
                <td className="p-1">{ unit ||  '' }</td>
                <td className="p-1">{ item || '' }</td>
							</tr>
						))
					}
          </tbody>
          </table>
			</div>
			<h5>Instructions:</h5>
      <ol className="list-decimal">
			{ recipe.instructions.map((instruction, i) => <li key={`${instruction}-${i}`}>{ instruction }</li>) }
      </ol>
			{ recipe.notes && <div><h5>Notes</h5>{ recipe.notes.map((note, i) => <div key={`${note}-${i}`}>{ note }</div>) } </div> }
		</div>
			{ isScreenDisplay && <Links id={recipe.id} /> }
    </div>
);

export default Recipe;
