

$(function() {

	var optionTypes = ['category', 'cuisine', 'ingredients'],
		options = {},
		$filterElems = {},
		$recipeList = $('#recipe-list'),
		$recipes = $('#recipes'),
		$filter = $('#filter'),
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
		var name = getRecipeName(recipe);

		$recipeList.append('<li id="list-'+recipe.id+'"><a href="#'+name+'">'+recipe.title+'</a></li>');
		//// recipe list
		$recipes.append(getRecipeDom(recipe, name));
	});
	$recipeListItems = $('li', $recipeList);
	$recipeItems = $('.recipe', $recipes);

	//// clear filter on page load
	$filter.val('');
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
			var display = (option.length > 20) ? option.substring(0, 20) + '...' : option;
			$filterElems[id].append($('<option value="'+option+'" title="'+option+'">' + display + '</option>'));
		});
		
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