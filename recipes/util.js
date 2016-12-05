var recipeMetaMap = [
		{ header: 'Category', key: 'category' },
		{ header: 'Cuisine', key: 'cuisine' },
		{ header: 'Rating', key: 'rating' },
		{ header: 'Prep Time', key: 'preptime' },
		{ header: 'Servings', key: 'servings' },
		{ header: 'Cook Time', key: 'cooktime' }
	],
	ingredientItems = ['amount','unit','item']
	unitReplacements = [
		[/^teaspoons?$/i, 'tsp.'],
		[/^tablespoons?$/i, 'Tbs.']
	],
	ingredientItemWidthMap = {
			item: '8',
			unit: '2',
			amount: '2'
	};


function getRecipeName(recipe) {
	return recipe.title.replace(/[^a-zA-Z0-9]/g, '');
}	

function getRecipeDom(recipe, name, isScreenDisplay) {
	isScreenDisplay = isScreenDisplay !== false;
	var links = '',
		recipeTitleClass = 'recipe-title',
		recipeMainClass = 'recipe-main';
	if (isScreenDisplay) {
		links = '			<a href="printable.php?id='+recipe.id+'" target="_blank">Print</a> | \
			<a href="export.php?id='+recipe.id+'">Export</a> \
			<br /><br /> \
			<a href="#top">Return to top</a>';
		recipeTitleClass += ' recipe-background';
		recipeMainClass += ' recipe-background';			
	}
	var $structure = $('\
		<div id="recipe-'+recipe.id+'" class="recipe"> \
			<h4 id="'+name+'" class="'+recipeTitleClass+'">'+recipe.title+'</h4> \
			<div class="'+recipeMainClass+'"> \
				<dl class="recipe-meta dl-horizontal"></dl> \
				<h5>Ingredients:</h5> \
				<div class="container-fluid recipe-ingredients"> \
					<div class="row"><div class="col-md-6 .col-sm-12"></div></div> \
				</div> \
				<h5>Instructions:</h5> \
				<p>'+recipe.instructions.join('<br />')+'</p> \
			</div> \
 			'+links+'		\
	    </div> \
	');
	//// notes
	if ('notes' in recipe) {
		$('.recipe-main', $structure).append($('<h5>Notes</h5><p>'+recipe.notes.join('<br />')+'</p>'))
	}
	//// meta
	recipeMetaMap.forEach(function(map) {
		$('.recipe-meta' , $structure).append('<dt>'+map.header+'</dt><dd>'+recipe[map.key]+'</dd>');
	});

	//// ingredients
	recipe.ingredients.forEach(function(ingredient) {
		var $row = $('<div class="row" />');
		ingredientItems.forEach(function(item) {
			if (item === 'unit') {
				unitReplacements.forEach(function(replacement) {
					ingredient[item] = ingredient[item].replace(replacement[0], replacement[1]);
				});
			}
			$row.append('<div class="col-xs-'+ingredientItemWidthMap[item]+'">'+ingredient[item]+'</div>');
		});
		$('.recipe-ingredients .col-md-6' , $structure).append($row);
	});

	return $structure;
}
