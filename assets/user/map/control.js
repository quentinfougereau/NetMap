var sidebar = L.control.sidebar('sidebar', {
    position: 'right',
});

var lastEventOpened;

function controlInit(map){
  sidebar.update = function (object){
    $sidebar = $('#sidebar');
    if(object != undefined){
      lastEventOpened = object.id;
      sidebar.setContent('<h1>'+object.name+'</h1>'+
                         '<p><b>Lieu de l\'évènement :</b> '+object.place+'</p>'+
                         '<p><b>Adresse :</b> '+object.street+' ('+object.postcode+')</p>'+
                         '<p id="countdown"></p>'+
                         '<p><b>Si vous désirez participer à l\'évènement, veuillez vous'+
                         ' inscrire en cliquer sur ce <a href="">lien</a>.</b></p>')
      //eventCountDown(object)
    }
    else{
      sidebar.setContent("");
    }
  }
  map.addControl(sidebar);
}


function eventCountDown(object) {
  setInterval(function() {
  var countDownDate = object.date;
  // Get today's date and time
  var now = new Date().getTime();
  var distance = countDownDate - now;

  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  if($('#countdown').length){
    // If the count down is finished, write some text
    if (distance < 0) {
      clearInterval(x);
      $('#countdown').html("<p>Evènement expiré</p>");
    }
    else{
      $('#countdown').html(days + "d " + hours + "h "+
                           minutes + "m " + seconds + "s ");
    }
  }
}, 1000);
}




//mymap.addControl(sidebar);
