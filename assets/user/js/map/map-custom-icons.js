/**
    Création d'un marqueur personnalisé à afficher sur la carte
    @param position La position de l'utilisateur.
    @return le marqueur personnalisé.
*/
function createCircleMarker(position){
  let options = {
    radius: 8,
    fillColor: "red",
    color: "black",
    weight: 1,
    opacity: 1,
    fillOpacity: 0.8
  }
  return L.circleMarker(position);
}

/**
    Modification de la couleur de l'icône de marqueur existant.
    @param color la couleur du marqueur.
    @return l'icône à ajouter au marqueur.
*/
function customIcon(color){
  var icon = new L.Icon({
    iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-'+color+'.png',
    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
    iconSize: [25, 41],
    iconAnchor: [12, 41],
    popupAnchor: [1, -34],
    shadowSize: [41, 41]
  });
  return icon;
}
