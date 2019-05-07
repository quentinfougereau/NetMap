  var mymap;

// Transforme une adresse en coordonnées et construit une carte
function getUserAddr() {
  var location = $("#addrArea").val();
  // Récupération des coordonnées sous la forme (lat,long) depuis l'adresse
  var nominatim = 'https://nominatim.openstreetmap.org/search?format=json&q='+location+',France'; //Transforme l'adresse en coordonnées
  $.getJSON(nominatim, function(data) {
  // Vérifie que les données géographiques existent
  if( data[0] != undefined){
    $("#badPosition").html("");
    // Construction de l'object position
    var pos = {
      latitude:data[0].lat,
      longitude:data[0].lon
    };
    // Initialisation de la map
    initMap(pos);
  }
  else{
    // Ajout du Message d'erreur
    $("#badPosition").html("Pas bien ce que tu as mis dans ce champs");
  }
});
}
