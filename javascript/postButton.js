
//MAMP
var userPosition = {
  latitude:'',
  longitude:''
};

function setUserPosition(position) {
    userPosition.latitude =  position.coords.latitude,
    userPosition.longitude =  position.coords.longitude,

    $("#lat").val(position.coords.latitude);
    $("#lng").val(position.coords.longitude);

    $.ajax({
      type: "POST",
      url: "http://localhost:8888/index.php",
      data: userPosition,
      success: function(response) {
        console.log(response)
      initMap(userPosition,response);
      },
      dataType: 'json'
    });



}

function askForUserPosition(){
  if(navigator.geolocation)
    position = navigator.geolocation.getCurrentPosition(setUserPosition,erreurPosition);
}

function erreurPosition(error) {
var info = "Erreur lors de la géolocalisation."
switch(error.code) {
case error.TIMEOUT:
  info += "Délais d'attente dépassé."
break;
case error.PERMISSION_DENIED:
info += "Vous avez refusé d'être géolocalisé :("
break;
case error.POSITION_UNAVAILABLE:
  info += "La position n’a pu être déterminée";
break;
case error.UNKNOWN_ERROR:
  info += "Erreur inconnue";
break;
}
$("#infoposition").html(info)
}
