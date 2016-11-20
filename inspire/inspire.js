
function locationHashChanged() {  
  var path = location.hash(/^#/, '');
  $.get('api.php?path='.$path);
  // if (location.hash === "#somecoolfeature") {  
  //   somecoolfeature();  
  // }  
}  

window.onhashchange = locationHashChanged;