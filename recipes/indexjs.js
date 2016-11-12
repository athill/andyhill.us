

$(function() {

	var optionTypes = ['category', 'cuisine', 'ingredients'],
		options = {},
		$filterElems = {},
		$recipeList = $('#recipe-list'),
		$recipes = $('#recipes'),
		$filter = $('#filter'),
		$recipeListItems = [];
		$recipeItems = [],
		maxOptionLength = 15;		//// max length of filter option display value
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
		var seenValues = {};	
		options[optionType].forEach(function(option) {
			//// remove everything after semi-colon
			var display = value = option.split(';')[0];
			//// deal with long values
			if (display.length > maxOptionLength) {
				 display = display.substring(0, maxOptionLength) + '...';
			}
			//// add value
			if (!(value.toLowerCase() in seenValues)) {
				$filterElems[id].append($('<option value="'+value+'" title="'+value+'">' + display + '</option>'));
				seenValues[value.toLowerCase()] = null;
			}
			
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