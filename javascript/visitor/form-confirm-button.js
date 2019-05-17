// Variables globales
var resultList = [];
var city;
var engine;

/* Récupération de la ville de l'utilisateur à partir de son adresse IP.
   Lancé automatiquement au démarage de la page.
*/

/*(function(){
  $.getJSON('http://ip-api.com/json/', function(data) {
    city = data.city;
  });
})();
*/

/*Ajout d'un eventListener au chargement de la page.
  Il sert à détecter l'addresse rentré par l'utilisateur.
*/
(function(){
  engine = new PhotonAddressEngine();
  $('#addrArea').typeahead(null, {
    source: engine.ttAdapter(),
    displayKey: 'description'
  })
})();




//A MODIFIER
/**
  Localise l'utilisateur à partir de son adresse.
*/
function locateByAddress() {
  var address = $('#addrArea').val();
  if(city != undefined){
    var nominatim = 'https://nominatim.openstreetmap.org/search?q='+address+','+city+','+
                    'France&format=json&polygon=1&addressdetails=1';
  }
  else{
    var nominatim = 'https://nominatim.openstreetmap.org/search?q='+address+
                    ',France&format=json&polygon=1&addressdetails=1';
  }
  // Requête JSON
  $.getJSON(nominatim,function(data) {
    console.log(data);
    if(data.length){
      changeCSSErrorMessage('erase');
      // Ajout des coordonnées récupéré par le navigateur à l'objet.
      userPosition.lat = data[0].lat;
      userPosition.lon = data[0].lon;

      if(mymap == undefined){
        $.ajax({
          type: "POST",
          //url: "http://localhost:8888/visitorIndex.php",
          url: "http://localhost/NetMap/scripts/getVisitorPOI.php",
          data: userPosition,
          success: function(response) {
            console.log(response)
            if(response != null && response.length != 0){
              initMap(userPosition,response, eventsList, 'visitor',14);
            }
            stopLoading();
          },
          error: function(){
            stopLoading();
            console.log("erreur");
          },
          dataType: 'json'
        });
      }
      else{
        addPositionMarkerOnMap(mymap, layerPositionGroup, userPosition);
        stopLoading();
      }
    }
    else{
    changeCSSErrorMessage(null, 'ADDR Reverse Geocoding : Request Failed');
  }
  })
  .fail(function() { console.log('fuck');changeCSSErrorMessage(null, 'ADDR Reverse Geocoding : Request Failed'); })
}
