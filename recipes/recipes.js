

$(function() {

	var optionTypes = ['category', 'cuisine', 'ingredients'],
		options = {},
		$filterElems = {},
		$recipeList = $('#menu'),
		$recipes = $('#recipes'),
		$filter = $('#filter'),
		recipeMetaMap = [
			{ header: 'Category', key: 'category' },
			{ header: 'Cuisine', key: 'cuisine' },
			{ header: 'Rating', key: 'rating' },
			{ header: 'Prep Time', key: 'preptime' },
			{ header: 'Servings', key: 'servings' },
			{ header: 'Cook Time', key: 'cooktime' }
		],
		ingredientItems = ['amount','unit','item'],
		$recipeListItems = [];
		$recipeItems = [];
	//// set up option types
	optionTypes.forEach(function(optionType) {
		options[optionType] = {};
	});	
	//// loop through recipes
	recipes.forEach(function(recipe) {
		//// build filter arrays
		optionTypes.forEach(function(optionType) {
			if (optionType === 'ingredients') {
				recipe.ingredients.forEach(function(ingredient) {
					options.ingredients[ingredient.item] = null;
				});
			} else {
				options[optionType][recipe[optionType]] = null;	
			}
		});
		var name = recipe.title.replace(/[^a-zA-Z0-9]/g, '');

		$recipeList.append('<li id="list-'+recipe.id+'"><a href="#'+name+'">'+recipe.title+'</a></li>');
		//// recipe list
		$recipes.append(getRecipeDom(recipe, name));
	});
	$recipeListItems = $('li', $recipeList);
	$recipeItems = $('.recipe', $recipes);

	//// change handler for filter
	$filter.keyup(function(e) {
		e.preventDefault();
		updateFilter();
	});

	//// generate dom arrays for options
	for (var optionType in options) {
		var id = optionType === 'ingredients' ? 'ingredient' : optionType;
		$filterElems[id] = $('#' + id);
		//// convert to array and sort
		options[optionType] = Object.keys(options[optionType]);
		options[optionType].sort();
		if (options[optionType].length && options[optionType][0] !== '') {
			$filterElems[id].append('<option />');
		}
		$filterElems[id].change(function(e) {
			updateFilter();
		});
		//// append to select
		options[optionType].forEach(function(option) {
			$filterElems[id].append($('<option>' + option + '</option>'));
		});
		
	}

	function getRecipeDom(recipe, name) {
		var $structure = $('<div id="recipe-'+recipe.id+'" class="recipe"> \
			<h2 id="'+name+'"><span class="recipe-title">'+recipe.title+'</span></h2> \
			<div class="recipe-main"> \
				<table class="recipe-meta"><tbody></tbody></table> \
				<h3>Ingredients:</h3> \
				<table class="recipe-ingredients"><tbody></tbody></table> \
				<h3>Instructions:</h3> \
				<p>'+recipe.instructions.join('<br />')+'</p> \
			</div> \
		</div> \
		<a href="printable.php?id='+recipe.id+'" target="_blank">Print</a> | \
		<a href="export.php?id='+recipe.id+'">Export</a> \
		<br /><br /> \
		<a href="#top">Return to top</a> \
		<br /><br /> \
		');
		//// meta
		recipeMetaMap.forEach(function(map) {
			$('.recipe-meta tbody' , $structure).append('<tr><th>'+map.header+'</th><td>'+recipe[map.key]+'</td></tr>');
		});

		recipe.ingredients.forEach(function(ingredient) {
			var $tr = $('<tr />');
			ingredientItems.forEach(function(item) {
				$tr.append('<td>'+ingredient[item]+'</td>');
			});
			$('.recipe-ingredients tbody' , $structure).append($tr);
		});

		return $structure;
	}

	function updateFilter() {
		var ids = [];
		var filterValues = {};
		for (var filter in $filterElems) {
			filterValues[filter] = $filterElems[filter].val();
		}
		recipes.forEach(function(recipe) {
			var add = true;
			if (filterValues.category !== '' && recipe.category !== filterValues.category) {
				add = false;
			}
			if (add && filterValues.cuisine !== '' && recipe.cuisine !== filterValues.cuisine) {
				add = false;
			}
			if (add && filterValues.ingredient !== '') {
				var addIt = false;
				for (var i = 0; i < recipe.ingredients.length; i++) {
					if (recipe.ingredients[i].item === filterValues.ingredient) {
						addIt = true;
						break;
					}
				}
				if (!addIt) {
					add = false;
				}
			}
			var filter = $filter.val().toLowerCase();
			if (add && filter !== '') {
				var addIt = false;
				if (inString(filter, recipe.category) || 
						inString(filter, recipe.cuisine) ||
						inString(filter, recipe.title) ||	
						inString(filter, recipe.instructions.join(' ')) 
					) {
					addIt = true;
				}
				if (!addIt) {
					for (var i = 0; i < recipe.ingredients.length; i++) {
						if (inString(filter, recipe.ingredients[i].item)) {
							addIt = true;
							break;
						}
					}
				}
				if (!addIt) {
					add = false;
				}
			}
			if (add) {
				ids.push(recipe.id);
			}
		});

		var $listItems = $recipeListItems.filter(function(index, elem) {
			var id = $(elem).attr('id').replace('list-', '');
			return ids.indexOf(id) !== -1;
		});
		$recipeList.html($listItems);

		var $items = $recipeItems.filter(function(index, elem) {
			var id = $(elem).attr('id').replace('recipe-', '');
			return ids.indexOf(id) !== -1;
		});
		$recipes.html($items);
	}

	function inString(needle, haystack) {
		return haystack.toLowerCase().indexOf(needle) > -1;
	}

});