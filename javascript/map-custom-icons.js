// Création d'un marqueur personnalisé à afficher sur la carte
// A modifier si nécessaire
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
