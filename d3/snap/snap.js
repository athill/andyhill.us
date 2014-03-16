$(function() {
  $('#cost').linechart();

  $('#participation').linechart({
    fields: {
          'avg_participation': {
            color: 'blue', 
            label: 'Average Population',
            title: function(d) { return d.x + ' - ' + addCommas(d.avg_participation); },
            value: function(d) { return parseFloat(d.avg_participation*1000); }
      },
    },
    series: ['avg_participation'],
    padding: 60,
    title: 'U.S. Population using SNAP',

  });

  $('#percent').linechart({
    fields: {
          'totalpercent': {
            color: 'blue', 
            label: 'Percent of U.S. Population',
            title: function(d) { return d.x + ' - ' + d.totalpercent.toPrecision(4)+'%'; },
            value: function(d) { return parseFloat(((d.avg_participation*1000)/d.population)*100); }
      }
    },
    series: ['totalpercent'],
    title: 'Percent of U.S. Population using SNAP',

  });
});