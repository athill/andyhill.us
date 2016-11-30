
$(function() {
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

    ////Slide
    var w = 750,
        h = 500,
        y = d3.scale.ordinal().domain(d3.range(50)).rangePoints([20, h - 20]),
        t = Date.now();

    var svg = d3.select("#slide").append("svg:svg")
        .attr("width", w)
        .attr("height", h);

    var circle = svg.selectAll("circle")
        .data(y.domain())
      .enter().append("svg:circle")
        .attr("r", 16)
        .attr("cx", 20)
        .attr("cy", y)
        .each(slide(20, w - 20));

    function slide(x0, x1) {
      t += 50;
      return function() {
        d3.select(this).transition()
            .duration(t - Date.now())
            .attr("cx", x1)
            .each("end", slide(x1, x0));
      };
    }

    d3.text("hist01z1.csv", function(datasetText) {

    var parsedCSV = d3.csv.parseRows(datasetText);

    var sampleHTML = d3.select("#viz2")
        .append("table")
        .style("border-collapse", "collapse")
        .style("border", "2px black solid")

        .selectAll("tr")
        .data(parsedCSV)
        .enter().append("tr")

        .selectAll("td")
        .data(function(d){return d;})
        .enter().append("td")
        .style("border", "1px black solid")
        .style("padding", "2px")
        .on("mouseover", function(){d3.select(this).style("background-color", "red")})
        .on("mouseout", function(){d3.select(this).style("background-color", "white")})
        .text(function(d){return d;})
        .style("font-size", "10px");
    });

});

        