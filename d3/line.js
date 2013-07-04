$(function() {
  $('#line-chart2').linechart({
    title: 'Total Federal Receipts and Outlays in Millions: 1901–2011 (2012-2017 projected)',
    csv: './data/line.csv',
    fields: {
      'TotalReceipts': {
        title: function(d) { 
          return d.x + ' - ' + millionFormat(d.TotalReceipts)  + 
            ' in receipts.\nBalance: ' + d.TotalSurplusOrDeficit + 'M'; }
      },
      'TotalOutlays': {
        title: function(d) { 
          return d.x + ' - ' + millionFormat(d.TotalOutlays)  + 
            ' in outlays.\nBalance: ' + d.TotalSurplusOrDeficit + 'M'; }
      },
      'TotalSurplusOrDeficit': {

      }
    },
    series: ['TotalOutlays', 'TotalReceipts'],
    labelfield: 'Year',
    padding: 60
  });
  // $('circle.line').tooltip();
  // $('svg circle').click(function() {
  //     console.log('hovering');
  // });
});




function millionFormat(integer) {
  return '$' + addCommas(integer) + 'M';
}

function addCommas(nStr) {
  nStr += '';
  x = nStr.split('.');
  x1 = x[0];
  x2 = x.length > 1 ? '.' + x[1] : '';
  var rgx = /(\d+)(\d{3})/;
  while (rgx.test(x1)) {
    x1 = x1.replace(rgx, '$1' + ',' + '$2');
  }
  return x1 + x2;
}

d3.csv("./data/line.csv", function(data1) { 

    /* Read CSV file: first row =>  year,top1,top5  */
    var maxval = 0,
        sampsize = 0;
    var label_array = new Array(),
        val_array1 = new Array();

    var projected = 2012;

    sampsize = data1.length;

    for (var i=0; i < sampsize; i++) {
       label_array[i] = parseInt(data1[i].Year);
       val_array1[i] = { x: label_array[i], y: parseFloat(removeCommas(data1[i].TotalReceipts)), 
          z: parseFloat(removeCommas(data1[i].TotalOutlays)), 
          balance: data1[i].TotalSurplusOrDeficit };
       maxval = Math.max(maxval, parseFloat(removeCommas(data1[i].TotalReceipts)), 
          parseFloat(removeCommas(data1[i].TotalOutlays)) );
     }

     function removeCommas(val) {
       return val.replace(/,/g, '');
     }

    // console.log(val_array1);

     maxval = (1 + Math.floor(maxval / 10)) * 10;   


   var  w = 815,
        h = 500,
        p = 30,
        x = d3.scale.linear().domain([ label_array[0], label_array[sampsize-1] ]).range([0, w]),
        y = d3.scale.linear().domain([0, maxval]).range([h, 0]);

   var vis = d3.select("#line-chart")
       .data([val_array1])
     .append("svg:svg")
       .attr("width", w + p * 2)
       .attr("height", h + p * 2)
     .append("svg:g")
       .attr("transform", "translate(" + p + "," + p + ")");


   var rules = vis.selectAll("g.rule")
      .data(x.ticks(15))
     .enter().append("svg:g")
       .attr("class", "rule");

   // Draw grid lines
   rules.append("svg:line")
    .attr("x1", x)
    .attr("x2", x)
    .attr("y1", 0)
    .attr("y2", h - 1);

   rules.append("svg:line")
    .attr("class", function(d) { return d ? null : "axis"; })
    .data(y.ticks(10))
    .attr("y1", y)
    .attr("y2", y)
    .attr("x1", 0)
    .attr("x2", w - 10);

   // Place axis tick labels
   rules.append("svg:text")
    .attr("x", x)
    .attr("y", h + 15)
    .attr("dy", ".71em")
    .attr("text-anchor", "middle")
    .text(x.tickFormat(10))
    .text(String);

   rules.append("svg:text")
    .data(y.ticks(12))
    .attr("y", y)
    .attr("x", 40)
    .attr("dy", ".35em")
    .attr("text-anchor", "end")
    .text(y.tickFormat(8));


   // Series I
   vis.append("svg:path")
       .attr("class", "line")
       .attr("fill", "none")
       .attr("stroke", function(d) { return (d.x >= projected) ? 'red' : "maroon";  })
       .attr("stroke-width", 2)
       .attr("d", d3.svg.line()
         .x(function(d) { return x(d.x); })
         .y(function(d) { return y(d.y); }));

  var circles = vis.selectAll("circle.line");

   circles.data(val_array1)
     .enter().append("svg:circle")
       .attr("class", "line")
       .attr("fill", function(d) { return (d.x >= projected) ? 'red' : "maroon";  })
       .attr("cx", function(d) { return x(d.x); })
       .attr("cy", function(d) { return y(d.y); })
       .attr("r", 3)
        // .on("mouseover", function(){d3.select(this).style("fill", "green");})
        // .on("mouseout", function(){d3.select(this).style("fill", "maroon");}); 
      .append("svg:title")
      .text(function(d) { return d.x + ' - ' + millionFormat(d.y)  + ' in receipts.\nBalance: ' + d.balance + 'M'; });


   // Series II
   vis.append("svg:path")
       .attr("class", "line")
       .attr("fill", "none")
       .attr("stroke", function(d) { return (d.x >= projected) ? 'blue' : "darkblue";  })
       .attr("stroke-width", 2)
       .attr("d", d3.svg.line()
         .x(function(d) { return x(d.x); })
         .y(function(d) { return y(d.z); }));

   circles.data(val_array1)
     .enter().append("svg:circle")
       .attr("class", "line")
       .attr("fill", function(d) { return (d.x >= projected) ? 'blue' : "darkblue";  } )
       .attr("cx", function(d) { return x(d.x); })
       .attr("cy", function(d) { return y(d.z); })
       .attr("r", 3)
       .append("svg:title")
       .text(function(d) { return d.x + ' - ' + millionFormat(d.z) + ' in outlays.\nBalance: ' + d.balance + 'M'; });

   // -----------------------------
   // Add Title then Legend
   // -----------------------------
   vis.append("svg:text")
       .attr("x", w/4)
       .attr("y", 20)
       .text("Total Federal Receipts and Outlays in Millions: 1901–2011 (2012-2017 projected)");

   vis.append("svg:rect")
       .attr("x", w/2 - 20)
       .attr("y", 50)
       .attr("stroke", "darkblue")
       .attr("height", 2)
       .attr("width", 40);

   vis.append("svg:text")
       .attr("x", 30 + w/2)
       .attr("y", 55)
       .text("Total Outlays");

   vis.append("svg:rect")
       .attr("x", w/2 - 20)
       .attr("y", 80)
       .attr("stroke", "maroon")
       .attr("height", 2)
       .attr("width", 40);

   vis.append("svg:text")
       .attr("x", 30 + w/2)
       .attr("y", 85)
       .text("Total Receipts");


}); 
