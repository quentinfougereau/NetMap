/* Création d'un évènement clic lié au document. Il sert à gérer les différents éléments
   pouvant recevoir un clic suite à une intération avec l'icône de localisation manuelle.
*/
function documentClickEvent(){
  // Evenement utilisé pour supprimer le curseur modifié en cas de clic à l'extérieur de la carte.
  $(document).on('click',function(event) {
    // Renvoie les élement qui ont subit l'event 'clic'.
    target = $(event.target);
    // Renvoie l'ID du premier élément qui a subit l'event 'clic'.
    target = target[0].id;
    // Si la cible est la carte, on ne fait rien.
    if(target == 'mapid'){}
    /* Si la cible n'est n'est pas la carte, on modifie la variable
       allowSelfLocation empêchant de déposer le marqueur sur la carte.
       On réinitialise également le curseur par celui par défaut.
    */
    else{
      allowSelfLocation = false;
      changeIconCursor(allowSelfLocation);
      changeSelfLocateButtonState(localisationBar,'default')
    }
  });
}
/**
Dépot d'un  marqueur de position suite à un clic sur la carte.
@param map la carte sur laquelle est ajouté l'évènement.
@param layerPositionGroup groupe de marqueur où est stockée la position de l'utilisateur.
*/
function addClickEventOnMap(map,layerPositionGroup){
documentClickEvent();
map.on('click', function(e){
  if(allowSelfLocation){
    var coord = e.latlng;
    userPosition.lat = coord.lat;
    userPosition.lon = coord.lng;
    addPositionMarkerOnMap(map, layerPositionGroup, userPosition);
    //CenterMapOnUserPosition(userPosition)

    allowSelfLocation = false;
    changeIconCursor(allowSelfLocation);
    changeSelfLocateButtonState(localisationBar,'default');
    }
});
}
/**
  Permet de changer le type d'icône du curseur.
  @param status true --> l'icône devient une croix.
  @param status false --> l'icône est réinitialisée par défaut.
*/
function changeIconCursor(status){
  L.DomUtil.addClass(mymap._container,'crosshair-cursor-enabled');
  L.DomUtil.removeClass(mymap._container,'crosshair-cursor-enabled');
  if(status)
    $('.leaflet-container').css('cursor','crosshair');
  else{
    $('.leaflet-container').css('cursor','');
  }
}

  /**
    Permet de changer l'état du bouton de localisation.
    @param bar la barre sur laquelle se trouve le bouton.
    @param state l'état que prend le bouton
  */
  function changeSelfLocateButtonState(bar,state){
    let button = getButton(bar, 'selfLocate')
    button.state(state);
  }
