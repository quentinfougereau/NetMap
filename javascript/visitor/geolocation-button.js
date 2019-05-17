// Objet de portée globale représentant la position de l'utilisateur.
var userPosition = {
  lat: undefined,
  lon: undefined
};

/**
    Passage des coordonnées de géolocalisation à l'objets userPosition et initialisation de la carte.
    @param position La position de l'utilisateur.
*/
function setUserPosition(position) {
    // Ajout des coordonnées récupéré par le navigateur à l'objet.
    userPosition.lat =  position.coords.latitude;
    userPosition.lon =  position.coords.longitude;

    /* Modification/Suppression du message d'erreur précédemment rencontrés.
       On vérifie la taille du message d'erreur, si il est différent de 0
       il existe et on doit alors le supprimer.
    */
    var errorMessage = $("#infoposition").html().length;
    if(errorMessage != 0){
      changeCSSErrorMessage('erase');
    }
    /* Vérification de l'existence de la carte. Si elle n'existe pas on la créé,
       sinon on met à jour la position de l'utilisateur.
    */
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

/* Demande d'autorisation de la géolocalisation à l'utilisateur.
   Si la réponse est positive, le premier argument est lancé,
   sinon on lance le deuxième.
*/
function askForGeolocalisation(){
  startLoading();
  if(navigator.geolocation)
    position = navigator.geolocation.getCurrentPosition(setUserPosition,getGeolocalisationError);
}

/**
    Fonction éxecutée lors d'une erreur de géolocalisation.
    @return Le message d'erreur.
*/
function getGeolocalisationError(error) {
  var info = "Error during geolocalisation : "
  switch(error.code) {
    case error.TIMEOUT:
      info += "connection timeout."
    break;
    case error.PERMISSION_DENIED:
    info += "you refused to be automaticaly geolocalised."
    break;
    case error.POSITION_UNAVAILABLE:
      info += "couldn't determine your exact location.";
    break;
    case error.UNKNOWN_ERROR:
      info += "unknown error.";
    break;
  }
  changeCSSErrorMessage(null,info);
  stopLoading();
}


/**
    Modification du style de l'affichage des messages d'erreurs.
    @param status 'erase' pour supprimer le message d'erreur.
    @param info le message d'erreur à afficher.
*/
function changeCSSErrorMessage(status, info){
  if(status === 'erase'){
    $('.error').css('transform', 'scale(0) rotate(-12deg)');
    $('.error').css('opacity','0');
}
    else {
    $("#infoposition").html(info);
    $('.error').css('transform', 'scale(1) rotate(0)');
    $('.error').css('opacity','0.8');

  }
}
