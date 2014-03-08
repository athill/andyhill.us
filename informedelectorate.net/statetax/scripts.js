var max = {};		//// maximum values for primary areas
var scales = {};	//// scaling functions by area
var colorcode = {	//// color multipliers
	r: 0.2,
	g: 1,
	b: 0.1
};
var dollars;		//// format function for dollars

//// Build max map	
for (var state in data) {
	for (var type in data[state]) {
		if (!(type in max) || parseInt(data[state][type]) > parseInt(max[type])) {
			max[type] = data[state][type];
		}
	}
}

//// Build basic scaling functions
for (var type in max) {
	scales[type] = d3.scale.linear()
							.domain([0, max[type]])
							.range([255, 0])
}


$(function() {
	//Width and height
	var w = 400;
	var h = 250;
	dollars = d3.format('$0,0');
	//// set up tooltip
	var tip = d3.tip()
	  .attr('class', 'd3-tip')
	  .offset([0, -10])
	  .html(function(d) {
	  	var area = $('input[name=option]:checked').val();
	  	// console.log(d);
	  	var name = d.properties.NAME;
	  	//
	    return getTooltip(name, area);
	  });

	//// area
	var area = $('input[name=option]:checked').val();

	//Define map projection
	var projection = d3.geo.albersUsa()
						   .translate([w/2, h/2])
						   .scale([500]);

	//Define path generator
	var path = d3.geo.path()
					 .projection(projection);

	//Create SVG element
	var svg = d3.select("#state_map")
				.append("svg")
				.attr("width", w)
				.attr("height", h);
	//// Initialize tooltip
	svg.call(tip);

	//Load in GeoJSON data
	d3.json(webroot+"/js/states.json", function(json) {
		
		//Bind data and create one path per GeoJSON feature
		svg.selectAll("path")
		   .data(json.features)
		   .enter()
		   .append("path")
		   .attr("d", path)
		   .attr('class', 'state')
		   .attr('id', function(d) { return d.properties.NAME; })
		   .style("fill", function(d) {
		   		var name = d.properties.NAME;
		   		return getRgb(name, area)
		   	})
		   .on('mouseover', tip.show)
		   .on('mouseout', tip.hide)
	});

	//// Change option
	$('#interface-container').on('click', 'input[name=option]', function(e)  {
		var area = $('input[name=option]:checked').val();
		$('.state').each(function(i, elem) {
			var name = $(this).attr('id');
			$(this).css('fill', getRgb(name, area));
		});
	});
});



function getRgb(name, area) {
	if (!(name in data)) return {};
	var rgb = {};
	var areas = area.split('+');
	//// create area in scales if it doesn't exist
	if (!(area in scales)) {
		var mx = 0;
		for (var i = 0; i < areas.length; i++) {
			mx += parseInt(max[areas[i]]);
		}
		scales[area] = d3.scale.linear()	
							.domain([0, mx])
							.range([255, 0]);
	}
	//// build rgb
	for (var color in colorcode) {
		var value = 0;
		for (var i = 0; i < areas.length; i++) {
			value += parseInt(data[name][areas[i]]);
		}
		rgb[color] = Math.floor(scales[area](value)*colorcode[color]);
	}
	var rgbstr = 'rgb('+rgb.r+','+rgb.g+','+rgb.b+')';
	return rgbstr;
}

function getTooltip(name, area) {
	var value = name;
	if (name in data) {
		var areas = area.split('+');
		var total = 0;
		for (var i = 0; i < areas.length; i++) {
			var a = areas[i];
			total += parseInt(data[name][a]);
		}
		value += ' - ' + dollars(total);
	} 
	return value;	
}