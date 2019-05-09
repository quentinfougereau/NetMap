// Déclaration de variables globales
var mymap;
var layerPositionGroup;
var layerPointOfInterestGroup;
var status = false;

// Initialisation de la carte et affichage de diverses informations :
// position, points d'intérêts.
// Affichage de la view 'user' par défaut.
function initMap(position, pointOfInterest, view){
  // Suppression des précédents messages d'erreurs de géolocalisation .
  $("#infoposition").html("");

  // Initialisation du conteneur de la carte et autorisation des interactions (view:user).
  if(view === 'user') {
    mymap = L.map('mapid',{
      center:[position.latitude, position.longitude],
      zoom: 14,
    });
  }
  // Initialisation du conteneur de la carte et désactivation des intéractions (view:visiteur).
  else{
    mymap =  L.map('mapid',{
      center:[position.latitude, position.longitude],
      keyboard: false,
      dragging: false,
      zoomControl: false,
      boxZoom: false,
      doubleClickZoom: false,
      scrollWheelZoom: false,
      tap: false,
      touchZoom: false,
      zoom: 15,
      minZoom: 15,
      maxZoom: 15
    });
  }

  // Initialisation du groupe de marqueurs des centres d'intérêts.
  layerPointOfInterestGroup = L.layerGroup().addTo(mymap);
  // Initialisation du groupe de marqueurs de position de l'utilisateur.
  layerPositionGroup= L.layerGroup().addTo(mymap);

  // Remplissage du conteneur de la carte.
  fillMap(mymap);
  // Ajout d'un marqueur sur la position de l'utilisateur.
  addPositionMarker(mymap, layerPositionGroup, position);
  // Ajout des points d'intérêts passés en paramètre.
  if(pointOfInterest != null)
    addPointOfInterest(layerPointOfInterestGroup,pointOfInterest);
  }

// Remplissage du contenur de la carte.
function fillMap(map){
  L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
      attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
      maxZoom: 15,
      color:'red',
      id: 'mapbox.streets',
      accessToken: 'pk.eyJ1Ijoic2Vhc29ueGRrIiwiYSI6ImNqdjJlZjVxZjA1NDU0M21wbmg2eThlbnkifQ.CzDcGBZxuQgRiOuIXnea3A'
  }).addTo(map);
}

// Ajout d'un marqueur de la position de l'utilisateur sur la carte.
function addPositionMarker(map, layerPositionGroup, position){
  // Efface les marqueurs précédemments ajoutés.
  layerPositionGroup.clearLayers();
  // Création du marqueur et ajout au groupe qui lui est associé.
  let marker = L.marker([position.latitude, position.longitude],{autoPan:true}).addTo(layerPositionGroup);
  marker.bindPopup("<b>Vous êtes ici<b>.");

  // Ajout d'un évènement 'mouseover' au marqueur : fermeture/ouverture popup.
  marker.on('mouseover', function (e) {
  this.openPopup();
  });
  marker.on('mouseout', function (e) {
  this.closePopup();
  });

  // Centre la carte selon la position du marqueur
  map.panTo(new L.LatLng(position.latitude, position.longitude))
 }

 // Ajout d'un cercle autours de la position de l'utilisateur selon le radius
 // passé en paramètre.
 function addCircleOnPosition(layerPositionGroup,position,color,fillColor,opacity,radius){
   if(radius > 1000)
     mymap.setView([userPosition.latitude, userPosition.longitude], 14);
   else {
     mymap.setView([userPosition.latitude, userPosition.longitude], 20);
   }
   var circle = L.circle([position.latitude, position.longitude], {
           color: color,
           fillColor: fillColor,
           fillOpacity: opacity,
           radius: radius
           //weight: 1
       }).addTo(layerPositionGroup);
     }

// Parcourt des données passées en paramètre et ajout d'un marqueur pour
// chaque POI présent dans les données.
// Ajout du cercle de taille radius.
function addPointOfInterest(layerPointOfInterestGroup, pointOfInterest, radius){
  // On efface les points générés lors de la dernière recherche
  layerPointOfInterestGroup.clearLayers();
  addCircleOnPosition(layerPointOfInterestGroup,userPosition,'white','red',0.3,radius+100)
  // On parcourt les données et si il s'agit de point sur la carte, on l'affiche.
  for(let data of pointOfInterest){
    getPointOfInterestAdress(data, layerPointOfInterestGroup, setPointOfInterestMarker,radius)
  }
}

// Ajout des évènement/icones/popups au marqueur.
// A compléter au fur et à mesure.
function setPointOfInterestMarker(data, address, layer,radius){
  // Ajout du marqueur uniquement si la data est un point.
  // L'API peut retourner des chemins etc..
  if(data.type === "node"){
      // A remplacer par un switch pour chaque type d'amenity
      // Ajout des icones et des popups selon le type de marqueur.
      if(data.tags.amenity === 'restaurant'){
        var restaurantIcon = L.icon({
          iconUrl: 'img/food.png',
          iconSize: [20,20], // size of the icon
        });
        var marker = L.marker([data.lat, data.lon],{icon:restaurantIcon,autoPan: false}).addTo(layerPointOfInterestGroup);
        marker.bindPopup("<span><b>"+data.tags.name+"</b></span></br><span>"+data.tags.amenity+"</span></br><span>Adresse : "+address+"</span>")
      }
      else if(data.tags.tourism === 'museum'){
        var museumIcon = L.icon({
          iconUrl: 'img/museum.png',
          iconSize: [20,20], // size of the icon
        });
        var marker = L.marker([data.lat, data.lon],{icon:museumIcon,autoPan: false}).addTo(layerPointOfInterestGroup);
        marker.bindPopup("<span><b>"+data.tags.name+"</b></span></br></span>"+data.tags.tourism+"</span></br><span>Adresse : "+address+"</span>")
      }
      else if(data.tags.amenity === 'bench'){
        var marker = createCircleMarker(data).addTo(layerPointOfInterestGroup);
        marker.bindPopup("<b>("+data.tags.amenity+")<b><br/>"+data.tags.material)
      }
      else{/*Affichage d'un message d'erreur*/return;}

      // Ajout d'évènement mouserover aux markers
      marker.on('mouseover', function (e) {
        this.openPopup();
      });
      marker.on('mouseout', function (e) {
        this.closePopup();
      });
  }
}

// Récupère une localisation et la transmet via l'API Nominatim pour obtenir
// l'adresse complète. Parse l'adresse et appelle ensuite setPointOfInterestMarker
// pour ajouter le marqueurs à la carte avec son adresses respective.
function getPointOfInterestAdress(myData,layer, callback,radius){
  let location = "lat="+myData.lat+'&lon='+myData.lon;
  var nominatim = "https://nominatim.openstreetmap.org/reverse?format=json&"+location+"&zoom=18&addressdetails=1";
  var address ="";

  //Objet contenant les champs de l'adresse
  var POIAddress = {
    house_number: undefined,
    road: undefined,
    postcode: undefined,
    city: undefined
  };
  // Récupération de la réponse en JSON
  $.getJSON(nominatim, function(data) {
    // Vérifie que la requête retourne au moins un résultat.
    if( data != undefined){
      for(let subData in data.address){
        var attrName = subData;
        switch (attrName) {
          case 'house_number':
            POIAddress.house_number=data.address[subData];
            break;
          case 'road':
            POIAddress.road=data.address[subData];
            break;
          case 'postcode':
            POIAddress.postcode=data.address[subData];
            break;
          case 'city':
            POIAddress.city=data.address[subData];
            break;
          default:
            break;
          }
        }
      // Parcourt des champs de l'objets pour les ajouter à la variable adresse.
      for(field in POIAddress){
        if(POIAddress[field] === undefined){
          continue;
        }
        else if(field === "road" && POIAddress.city != undefined){
          address+=POIAddress[field]+", ";
        }
        else{
          address+=POIAddress[field]+" ";
        }
      }
    }
    setPointOfInterestMarker(myData, address, layer, radius)
    });
  }
