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

(function($){
 $.fn.linechart = function(options) {
    var defaults = {
         ////default values here
         csv:'snap.csv',
         w: 815,
         h: 500,
         p: 30,
         padding: 40,
         fields: {
            'total_benefits': {
              //color: 'blue', 
              label: 'Total Benefits',
              title: function(d) { return d.x + ' - ' + millionFormat(d.total_benefits) + ' in outlays.' },
              value: function(d) { return parseFloat(removeFormatting(d.total_benefits)) }
            },
            'total_costs': {
             // color: 'red', 
              label: 'Total Costs',
              title: function(d) { return d.x + ' - ' + millionFormat(d.total_costs) + ' in outlays.' }
            }
         },
         series: ['total_benefits', 'total_costs'],
         labelfield: 'year',
         title: 'Supplemental Nutrition Assistance Costs in Millions'
    };
    var options = $.extend(defaults, options);   ////options will be the parameter scope    
    var removeFormatting = function(str) {
      return str.replace(/[,$]/g, '');
    }
    return this.each(function() {                ////loop through each matched element
      var self = $(this);
      d3.csv(options.csv, function(data) {
        //// parse data
        var maxval = 0,
            sampsize = data.length;
        var label_array = [],
            val_array = [];
        for (var i = 0; i < sampsize; i++) {
          label_array[i] = parseInt(data[i][options.labelfield]);
          val_array[i] = {
            x: label_array[i]
          };
          for (var name in options.fields) {
            
            var value = ('value' in options.fields[name]) ? 
              options.fields[name].value(data[i]):
              parseFloat(removeFormatting(data[i][name]));
            val_array[i][name] = value;
            maxval = Math.max(maxval, value);
          }
        }
        // maxval = (1 + Math.floor(maxval / 10)) * 10;

        ////Scaling
        var xScale = d3.scale.linear()
          .domain([ label_array[0], label_array[sampsize-1] ])
          .range([options.padding, options.w - options.padding]);
        var yScale = d3.scale.linear()
          .domain([0, maxval])
          .range([options.h - options.padding, options.padding]);


        //// set up canvas ???
        var svg = d3.select("#"+self.attr('id'))
           .data([val_array])
         .append("svg:svg")
           .attr("width", options.w + options.p * 2)
           .attr("height", options.h + options.p * 2)
         .append("svg:g")
           .attr("transform", "translate(" + options.p + "," + options.p + ")");

        ////Add axes
        svg.append("g")
            .attr("class", "axis")
            .attr("transform", "translate(0," + (options.h - options.padding) + ")")        
            .call(d3.svg.axis()
                        .scale(xScale)
                        .tickFormat(d3.format('d'))
                        .orient("bottom"));

        svg.append("g")
            .attr("transform", "translate(" + options.padding + ",0)")
            .call(d3.svg.axis()
                        .scale(yScale)
                        .orient("left"));  

        //// Title
        svg.append("svg:text")
           .attr("x", 10)
           .attr("y", 20)
           .attr('font-size', '14pt')
           .text(options.title);     

      // Series 
      var circles = svg.selectAll("circle.line");
      var offset = 0;
      var colors = ['blue', 'red', 'green', 'yellow', 'white'];
      for (var i = 0; i < options.series.length; i++) {
        var name = options.series[i];
        var field = options.fields[name];
        var color = ('color' in field) ? field.color : colors[i];
        //// Line
        svg.append("svg:path")
           .attr("class", "line")
           .attr("fill", "none")
           .attr("stroke", color)
           .attr("stroke-width", 2)
           .attr("d", d3.svg.line()
             .x(function(d) { return xScale(d.x); })
             .y(function(d) { return yScale(d[name]); }));

        //// Circles
        circles.data(val_array)
         .enter().append("svg:circle")
           .attr("class", "line")
           .attr("fill", color)
           .attr("cx", function(d) { return xScale(d.x); })
           .attr("cy", function(d) { return yScale(d[name]); })
           .attr("r", 3)
           .append("svg:title")
           .text(('title' in field) ? 
              field.title : 
              function(d) { return d.x + ' - ' + d[name] });

          //// Legend
          svg.append("svg:rect")
             .attr("x", options.w/2 - 20)
             .attr("y", 50 + offset)
             .attr("stroke", color)
             .attr("height", 2)
             .attr("width", 40);

          svg.append("svg:text")
             .attr("x", 30 + options.w/2)
             .attr("y", 55 + offset)
             .text(('label' in field) ? field.label : name);
          offset += 30;

        }
        
      });
    });
 };
})(jQuery);