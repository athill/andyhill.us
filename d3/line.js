$(function() {
  $('#line-chart').linechart({
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