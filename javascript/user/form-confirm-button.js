// Variables globales
var resultList = [];
var city;
var engine;

/* Récupération de la ville de l'utilisateur à partir de son adresse IP.
   Lancé automatiquement au démarage de la page.
*/

(function(){
  $.getJSON('http://ip-api.com/json/', function(data) {
    city = data.city;
  });
})();

/*Ajout d'un eventListener au chargement de la page.
  Il sert à détecter l'addresse rentré par l'utilisateur.
*/
(function(){
  engine = new PhotonAddressEngine();
  $('#addrArea').typeahead(null, {
    source: engine.ttAdapter(),
    displayKey: 'description'
  })
  $(engine).bind('addresspicker:selected', function (event, selectedPlace) {

});
})();




//A MODIFIER
/**
   Affiche des 5 premiers résultats obtenu lors de la recherche
   sous la barre où l'utilisateur rentre son adresse.
   @param event évènement passé en paramètre.
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
    if(data.length){
      console.log(data);
      changeCSSErrorMessage('erase');
      // Ajout des coordonnées récupéré par le navigateur à l'objet.
      userPosition.lat = data[0].lat;
      userPosition.lon = data[0].lon;

      (mymap == undefined) ? initMap(data[0],undefined, eventsList, 'user',14) :
                             addPositionMarkerOnMap(mymap, layerPositionGroup, data[0]);
    }
    else{
      var info = "Aucun résultat trouvé pour cette adresse."
      changeCSSErrorMessage(false, info);
    }
  })
  .fail(function() { changeCSSErrorMessage(undefined, 'ADDR Reverse Geocoding : Request Failed'); })
}
