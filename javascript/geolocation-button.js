// Objet représentant la position de l'utilisateur
var userPosition = {
  latitude: undefined,
  longitude: undefined
};

// Passage des coordonnées de géolocalisation à l'objets userPosition et initialisation de la carte
function setUserPosition(position) {

    // Ajout des coordonnées récupéré par le navigateur à l'objet.
    userPosition.latitude =  position.coords.latitude;
    userPosition.longitude =  position.coords.longitude;

    // Modification/Suppression du message d'erreur précédemment rencontrés.
    // On vérifie la taille du message d'erreur, si il est différent de 0
    // il existe et on doit alors le supprimer.
    var errorMessage = $("#infoposition").html().length;
    if(errorMessage != 0){
      changeCSSErrorMessage('erase');
    }
    // Vérification de l'existence de la carte. Si elle n'existe pas, on la créé,
    // sinon on met à jour la position de l'utilisateur
    if(mymap == undefined){
      // Initialisation de la carte avec le profil 'user'.
      initMap(userPosition,undefined, 'user');
    }
    else{
      // Ajoute un marqueur sur la position de l'utilisateur.
      addPositionMarker(mymap, layerPositionGroup, userPosition);
    }
}

// Demande d'autorisation de la géolocalisation à l'utilisateur.
// Si la réponse est positive, le premier argument est lancé,
// sinon on lance le deuxième.
function askForUserPosition(){
  if(navigator.geolocation)
    position = navigator.geolocation.getCurrentPosition(setUserPosition,erreurPosition);
}

// Retour de messages d'erreurs relatifs à la demande de géolocalisation.
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

  // Ajout du message d'erreur à la DIV d'affichage des erreurs.
  changeCSSErrorMessage(null);
  $("#infoposition").html(info)
  }

// Modification du style de l'affichage des messages d'erreurs.
// Si l'argument est égal à 'erase' on le rend invisible,
// sinon on l'affiche.
function changeCSSErrorMessage(status){
  console.log(status);
  if(status === 'erase'){
    $('.error').css('transform', 'scale(0) rotate(-12deg)');
    $('.error').css('opacity','0');
}
    else {
    $('.error').css('transform', 'scale(1) rotate(0)');
    $('.error').css('opacity','0.8');
  }
}
