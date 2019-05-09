
 // Fonction permettant à l'utilisateur d'ajouter manuellement sa position sur la carte.
 function addUserPositionOnClick(map,layerPositionGroup){
  // Vérification de l'initialisation de la map
  // Si la carte n'est pas initialisée, on quitte.
    if(map == undefined || map == null)
      return;
      addClickEventOnMap(map,layerPositionGroup);
      addClickEventOnDocument(map);
  }

  // Création d'un évènement clic lié au document. Il sert à gérer les différents éléments
  // pouvant recevoir un clic suite à un clic sur l'icône de localisation manuelle.
  function addClickEventOnDocument(map){
    // Evenement 'click' associé au document.
    // Utilisé pour supprimer l'icône en cas de clic à l'extérieur de la carte.
    $(document).on('click',function(event) {
      // Renvoie l'élement 'père' de l'élément qui a subit l'event 'clic'.
      target = $(event.target);
      // Renvoie l'ID de l'élément père de l'élément qui a subit l'event 'clic'.
      target = target.closest("#mapid").context.id;
      // Si la cible est la carte, on supprime les events et l'icône qui suivait
      // le marqueur.
      if(target == 'mapid'){
        map.off('click');
        $(document).off('click');
        iconFollowCursor(false);
      }
      // Si la cible est l'icone on supprime les events et l'icône qui suivait
      // le marqueur. On doit rajouter à nouveau l'icone puisqu'un click sur l'icône
      // ne doit avoir aucun effet jusqu'à un clic sur la carte
      else if(target == 'selfLocation-pin' ){
        iconFollowCursor(false);
        iconFollowCursor(true);
      }
      else{
        // Si la cible n'est ni la carte ni l'icône on supprime les events et l'icône qui suivait
        // le marqueur.
        map.off('click');
        $(document).off('click');
        iconFollowCursor(false);
      }
    });
  }

  // Création d'un évènement clic lié à la carte. Son rôle est de permettre de récupérer
  // des coordonnées géographiques suite à un clic.
function addClickEventOnMap(map,layerPositionGroup){
  // Evenement 'click' associé à la carte.
  // Un clique sur la carte retourne une position utilisée pour initialiser
  // un marqueur sur la carte.
  map.on('click', function(e){
    var coord = e.latlng;
    userPosition.latitude = coord.lat;
    userPosition.longitude = coord.lng;
    addPositionMarker(map, layerPositionGroup, userPosition);
    // Centrage de la carte en fonction des coordonnées du marqueurs.
    map.panTo(new L.LatLng(coord.lat, coord.lng));
    });
  }


  // Permet à l'icône de suivre ou non le curseur de l'utilisateur.
  // status = true ==> l'icône suit le curseur,
  // status = false ==> l'icône est supprimée.
  function iconFollowCursor(status){
    if(status){
      // Ajoute l'icone dans le DOM
      $('#button').prepend('<img id="movedSelfLocate-pin" src="img/position.png" />');
      // Déplace l'icone suivant le mouvement du curseur
      $(document).mousemove(function(e) {
        $('#movedSelfLocate-pin').offset({
          left: e.pageX-12,
          top: e.pageY-28
        });
      });
    }
    else{
      $('#movedSelfLocate-pin').remove();
    }
}
