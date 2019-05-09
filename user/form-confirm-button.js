// Transforme une adresse en coordonnées et construit une carte
function getUserAddr() {
  if($("#postalCodeArea").val() == ""){
    // Ajout du message d'erreur : code postale nécessaire
    // Gestion du CSS à ajouter pour pouvoir afficher le message.
    $("#infoposition").html("<span>Pas de code postale pas de résultat<span>");
    return;
  }
  // Modification de la syntaxe de l'addresse pour pouvoir l'inclure dans
  // la requette envoyée à NOMINATIM.
  var address = $("#addrArea").val();
  var postalCode = $("#postalCodeArea").val();

  var location = address;
  location+= ','+postalCode;

  // Récupération des coordonnées sous la forme (lat,lon) depuis l'addresse
  // enregistré via l'API NOMINATIM.
  var nominatim = 'https://nominatim.openstreetmap.org/search?format=json&q='
                  +location+',France';

  // Récupération de la réponse envoyée par NOMINATIM en format JSON.
  $.getJSON(nominatim, function(data) {
  // Vérification de l'existence d'un résultat pour l'adresse envoyée.
  // On sélectionne data[0] car c'est le premier résultat retourné
  // qui nous intéresse (le plus pertinent).
  if( data[0] != undefined){
    $("#infoposition").html("");
    // Ajout des coordonnées récupéré dans la réponse à l'objet.
    userPosition.latitude = data[0].lat;
    userPosition.longitude = data[0].lon;

    if(mymap == undefined){
      // Initialisation de la carte avec le profil 'user'.
      initMap(userPosition,undefined, 'user');
      }
      else{
        // Ajout d'un marqueur sur la position de l'utilisateur.
        addPositionMarker(mymap, layerPositionGroup, userPosition);
      }
    }
  else{
    // Ajout du message d'erreur : pas de résultat.
    // Gestion du CSS à ajouter pour pouvoir afficher le message.
    $("#infoposition").html("<span>Aucun résultat trouvé pour l'adresse"+
                      address+" et le code postale "+postalCode+"</span>");
  }
});
}
