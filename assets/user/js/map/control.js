var sidebar = L.control.sidebar('sidebar', {
    position: 'right',
});

var lastEventOpened;
var myInterval;

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
                         ' inscrire en cliquer sur ce <a href="../route/route_event.php?get_event=1&id_event=' + object.id + '">lien</a>.</b></p>')
      eventCountDown(object)

    }
    else {
      sidebar.setContent("");
    }
    console.log(myInterval)
  }
  map.addControl(sidebar);
}


function eventCountDown(object) {
  myInterval = setInterval(function() {
  var countDownDate;
  (object.start.length) ? countDownDate = Date(object.date+'T'+object.start) : countDownDate = new Date(object.date+'T00:00')
  // Get today's date and tim
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
