// Initialise la map et la remplie, la rafraichie si déjà initialisée
function initMap(position, pointOfInterest){
  // Si la carte est affiché, on enlève les précédents messages d'erreurs
  $("#infoposition").html("");
  // Vérifie si la carte existe déjà ou non
  var container = L.DomUtil.get('mapid'); if(container != null){ container._leaflet_id = null; }
  // Initialise la carte et empêche toute forme de zoom
  var mymap =  L.map('mapid',{
      center:[position.latitude, position.longitude],
      keyboard: false,
      dragging: false,
      zoomControl: false,
      boxZoom: false,
      doubleClickZoom: false,
      scrollWheelZoom: false,
      tap: false,
      touchZoom: false,
      zoom: 13,
      minZoom: 13,
      maxZoom: 13
    });
  // Initialise un groupe de markers pour afficher la position de l'utilisateur
  var layerPositionGroup = L.layerGroup().addTo(mymap);
  // Remplie la carte
  fillMap(mymap);
  // Initialise un groupe de markers pour afficher les points d'intérêts si il en existe
  var layerPointOfInterestGroup = L.layerGroup().addTo(mymap);
  if(pointOfInterest != null)
    addPointOfInterest(layerPointOfInterestGroup,pointOfInterest)
  // Ajoute un marqueur sur la position de l'utilisateur
  addPositionMarker(layerPositionGroup, position);

}



// Remplie les tiles de la map
function fillMap(map){
  L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
      attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
      maxZoom: 13,
      id: 'mapbox.streets',
      accessToken: 'pk.eyJ1Ijoic2Vhc29ueGRrIiwiYSI6ImNqdjJlZjVxZjA1NDU0M21wbmg2eThlbnkifQ.CzDcGBZxuQgRiOuIXnea3A' //changer la clé si nécessaire
  }).addTo(map);
}

function addPositionMarker(layerPositionGroup, position){
  // Efface les marqueurs précédants
  layerPositionGroup.clearLayers();
  let marker = L.marker([position.latitude, position.longitude]).addTo(layerPositionGroup);
  marker.bindPopup("<b>Vous êtes ici<b>.").openPopup();
 }

function addPointOfInterest(layerPointOfInterestGroup, pointOfInterest){
  layerPointOfInterestGroup.clearLayers();
  for(let data of pointOfInterest){
    if(data.type === "node"){
      let marker = L.marker([data.lat, data.lon],{autoPan: false}).addTo(layerPointOfInterestGroup);
      marker.bindPopup("<b>"+data.tags.amenity+"<b><br/>."+data.tags.name)
    }
  }
}
