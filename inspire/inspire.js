$(function() {
	//// build item array
	var $breadcrumbs = $('#breadcrumb');
	var $inspireRoot = $('#inspire-root');
	var $menu = $(menu);
	var items = [];
	var inspire = 'Inspiration';
	var inspireLink = '<a href="/inspire">'+inspire+'</a>';
	$menu.children().each(function(index, elem) {
		$elem = $(elem);
		var anchor = $('a', $elem)[0];
		var children = [];
		$('li a', $elem).each(function(i2, elem2) {
			$elem2 = $(elem2);
			children.push({
				href: elem2.hash,
				display: elem2.innerHTML,
			});
		});
		items.push({
			href: anchor.hash,
			display: anchor.innerHTML,
			children: children
		});
	});

	function buildBreadcrumbs(bcItems) {
		var breadcrumbs = $('<ul />');
		breadcrumbs.append('<li><a href="/">Home</a></li>');
		for (var i = 0; i < bcItems.length; i++) {
			breadcrumbs.append($('<li>' + bcItems[i] + '</li>'));
		}
		$breadcrumbs.html(breadcrumbs);
	}

	function setContent(title, data) {
		var content = $('<div id="quote" />');
		content.append($('<h4>'+title+'</h4>'));
		content.append($('<div id="quote-content">'+data.content.replace(/\n/g, '<br />')+'</div>'));
		content.append($('<div id="quote-credits">'+data.credits+'</div>'));
		$inspireRoot.html(content);
	}

	function item(path) {
		var pathArray = path.split('/');
	  	for (var i = 0; i < items.length; i++) {
	  		if (items[i].href.replace(/\/$/, '') === pathArray[0]) {
	  			var bcLinks = [inspireLink, '<a href="'+items[i].href+'">'+items[i].display+'</a>'];
	  			for (var j = 0; j < items[i].children.length; j++) {
	  				if (items[i].children[j].href === path) {
	  					buildBreadcrumbs(bcLinks.concat([items[i].children[j].display]));
	  					$.getJSON('api.php?path='+path.replace(/^#/, ''), function(data) {
	  						if ('error' in data) {
	  							section(pathArray);
	  						} else {
	  							setContent(items[i].children[j].display, data);
	  						}
	  					});
						return true;
	  				}
	  			}
	  		}
	  	}
	  	return false;		
	}

	function section(pathArray) {
	  	for (var i = 0; i < items.length; i++) {
	  		if (items[i].href.replace(/\/$/, '') === pathArray[0]) {
	  			var display = items[i].display;
	  			buildBreadcrumbs([inspireLink, display]);	  			
	  			var $link = $menu.find('a[href="/inspire/'+items[i].href+'"]');
	  			if ($link.length === 0) {
	  				return false;
	  			}
	  			var $parent = $link.parent();
	  			var $content = $parent.find('ul');
	  			$inspireRoot.html($('<h4>' + display + '</h4>'));
	  			$inspireRoot.append($content);
	  			$menu = $(menu);
	  			return true;
	  		}
	  	}
	  	return false;
	}

	function root() {
	  $inspireRoot.html('<p>Some words that inspire me.</p>' + menu);
	  buildBreadcrumbs([inspire]);		
	}

	function locationHashChanged() {  
	  var path = location.hash.replace(/\/$/, '');
	  var pathArray = path.split('/');
	  var set = false;
	  if (pathArray.length === 2) {
	  	set = item(path);
	  }
	  if (!set && pathArray.length >= 1) {
	  	set = section(pathArray);
	  }
	  if (!set) {
	 		root(); 	
		}
	}

	window.onhashchange = locationHashChanged;
	window.onhashchange();


});


