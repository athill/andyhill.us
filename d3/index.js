
$(function() {
    var sampleSVG = d3.select("#viz")
            .append("svg")
            .attr("width", 100)
            .attr("height", 100);    

        sampleSVG.append("circle")
            .style("stroke", "gray")
            .style("fill", "white")
            .attr("r", 40)
            .attr("cx", 50)
            .attr("cy", 50)
            .on("mouseover", function(){d3.select(this).style("fill", "aliceblue");})
            .on("mouseout", function(){d3.select(this).style("fill", "white");})
            .on("mousedown", animate);

            function animate() {
                d3.select(this).transition()
                    .duration(1000)
                    .attr("r", 10)
                  .transition()
                    .delay(1000)
                    .attr("r", 40);
            };

    ////Slide
    /*var w = 960,
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
    }*/

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
        .style("padding", "5px")
        .on("mouseover", function(){d3.select(this).style("background-color", "red")})
        .on("mouseout", function(){d3.select(this).style("background-color", "white")})
        .text(function(d){return d;})
        .style("font-size", "12px");
    });

});

        