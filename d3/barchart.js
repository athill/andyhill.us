$(function() {
	var data = [4, 8, 15, 16, 23, 42, 90];
	var width = 800;

	var chart = d3.select("#viz").append("svg")
	    .attr("class", "chart")
	    .attr("width", 440)
    	.attr("height", 140)
      .append('g')
      	.attr('transform', 'translate(10,15)');

	var x = d3.scale.linear()
	     .domain([0, d3.max(data)])
	     .range([0, width]);



	var y = d3.scale.ordinal()
	    .domain(data)
	    .rangeBands([0, 120]);



 chart.selectAll("rect")
     .data(data)
   .enter().append("rect")
   	 .attr("y", y)
     .attr("width", x)
     .attr("height", y.rangeBand());



chart.selectAll("text")
    .data(data)
  .enter().append("text")
    .attr("x", x)
    .attr("y", function(d) { return y(d) + y.rangeBand() / 2; })
    .attr("dx", -3) // padding-right
    .attr("dy", ".35em") // vertical-align: middle
    .attr("text-anchor", "end") // text-align: right
    .text(String);


chart.selectAll("line")
    .data(x.ticks(10))
  .enter().append("line")
    .attr("x1", x)
    .attr("x2", x)
    .attr("y1", 0)
    .attr("y2", 120)
    .style("stroke", "#ccc");

 chart.selectAll(".rule")
     .data(x.ticks(10))
   .enter().append("text")
     .attr("class", "rule")
     .attr("x", x)
     .attr("y", 0)
     .attr("dy", -3)
     .attr("text-anchor", "middle")
     .text(String);

chart.append("line")
    .attr("y1", 0)
    .attr("y2", 120)
    .style("stroke", "#000");

/* Dynamic chart */
var t = 1297110663, // start time (seconds since epoch)
    v = 70, // start value (subscribers)
    data2 = d3.range(33).map(next); // starting dataset

function next() {
  return {
    time: ++t,
    value: v = ~~Math.max(10, Math.min(90, v + 10 * (Math.random() - .5)))
  }; 
}

setInterval(function() {
  data2.shift();
  data2.push(next());
  redraw();
}, 1500);


var w2 = 20,
    h2 = 80;

var x2 = d3.scale.linear()
    .domain([0, 1])
    .range([0, w2]);

var y2 = d3.scale.linear()
    .domain([0, 100])     
    .rangeRound([0, h2]);

var chart2 = d3.select("#dynamic").append("svg")
    .attr("class", "chart")
    .attr("width", w2 * data2.length - 1)
    .attr("height", h2);

chart2.selectAll("rect")
    .data(data2)
  .enter().append("rect")
    .attr("x", function(d, i) { return x2(i) - .5; })
    .attr("y", function(d) { return h2 - y2(d.value) - .5; })
    .attr("width", w2)
    .attr("height", function(d) { return y2(d.value); });

chart2.append("line")
    .attr("x1", 0)
    .attr("x2", w2 * data2.length)
    .attr("y1", h2 - .5)
    .attr("y2", h2 - .5)
    .style("stroke", "#000");


function redraw() {

  // Update…
   var rect = chart2.selectAll("rect")
       .data(data2, function(d) { return d.time; });
 
   rect.enter().insert("rect", "line")
       .attr("x", function(d, i) { return x2(i + 1) - .5; })
       .attr("y", function(d) { return h2 - y2(d.value) - .5; })
       .attr("width", w2)
       .attr("height", function(d) { return y2(d.value); })
     .transition()
       .duration(1000)
       .attr("x", function(d, i) { return x2(i) - .5; });
 
   rect.transition()
       .duration(1000)
       .attr("x", function(d, i) { return x2(i) - .5; });
 
   rect.exit().transition()
       .duration(1000)
       .attr("x", function(d, i) { return x2(i - 1) - .5; })
       .remove();

}





});