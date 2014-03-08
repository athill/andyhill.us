// var data = {};
var max = {};
var types = [];
var scales = {};
var colorcode = {
	r: 0.2,
	g: 1,
	b: 0.1
};
var dollars;
// var app = {
// 	color: color
// };

// alert(app.color.g);


// $.getJSON('data.json', function(d) {
// 	data = d;
	
	
for (var state in data) {
	for (var type in data[state]) {
		if (!(type in max)) {
			// console.log('not in max '+type);
			types.push(type);
			max[type] = data[state][type];
		} else if (parseInt(data[state][type]) > parseInt(max[type])) {
			max[type] = data[state][type];
		} else {
			// console.log(max[type] + ': ' +data[state][type]);
		}
	}
}
for (var type in max) {
	scales[type] = d3.scale.linear()
							.domain([0, max[type]])
							.range([255, 0])
}
	// console.log(scales);
// });

$(function() {
	//Width and height
	var w = 400;
	var h = 250;
	dollars = d3.format('$0,0');

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



	//// AREA
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
		   .append("title")
	});


	$('#interface-container').on('click', 'input[name=option]', function(e)  {
		var area = $('input[name=option]:checked').val();
		$('.state').each(function(i, elem) {
			var name = $(this).attr('id');
			$(this).css('fill', getRgb(name, area));
			// if (name in data) {
			// 	$title = $('title', $(this));
			// 	$title.text(getTooltip(name, area));
			// }
		});
	});
});



function getRgb(name, area) {
	if (!(name in data)) return {};
	// var mult = getMult(name, area);
	var rgb = {};
	var areas = area.split('+');
	// console.log(areas);
	for (var color in colorcode) {
		rgb[color] = 0;
		var str = '';
		for (var i = 0; i < areas.length; i++) {
			var a = areas[i];
			var value = data[name][a];
			var scale = scales[a](value);
			var c = parseInt(colorcode[color]*scale);
			rgb[color] += c;
			str += value+'|'+c+'-';
		}
		rgb[color] = Math.floor(rgb[color] / areas.length);
		// console.log(rgb[color]+' '+areas.length);

	}
	return 'rgb('+rgb.r+','+rgb.g+','+rgb.b+')';
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



// function getMult(name, area) {
// 		var mult = 1;

// 		if (name in data && max[area] !== 0) {
// 			var value = parseInt(data[name][area]);
// 			var mx = max[area];
// 			mult = (value/mx)/100; 
// 			console.log(name+'; value: '+ value +'max: '+mx+' mult: '+mult);
// 		} else {
// 			mult = 0.5;
// 		} 
// 		mult = ((mult*255));
// 		return mult;
// }

// function numberWithCommas(x) {
//     return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
// }
	
