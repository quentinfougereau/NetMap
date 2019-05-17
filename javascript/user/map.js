// Déclaration de variables globales
var mymap;
var mymapZoom;
var tileLayer;
var layerPositionGroup;
var layerPointOfInterestGroup;
var layerEventGroup;
var layerCircleGroup;
var localisationBar;
var allowSelfLocation = false;

// Fonctions relatives à la carte.

/**
    Initialisation de la carte et affichage de diverses informations.
    @param position La position de l'utilisateur.
    @param pointOfInterest les POI affichés pour la view 'visitor'
    @param events les évènements envoyés par le serveur.
    @param view la vue utilisateur ou visiteur.
    @param zoom le zoom avec lequel la carte est initialisé
*/
function initMap(position, pointOfInterest, events, view, zoom){
  // Suppression des précédents messages d'erreurs de géolocalisation.
  $("#infoposition").html("");

  // Initialisation du conteneur de la carte (view : user)
  if(view === 'user') {
    mymap = L.map('mapid',{
      center:[position.lat, position.lon],
      zoom: zoom,
      minZoom: 5,
      maxZoom: 17,
      fadeAnimation: true,
      zoomAnimation: true
    });
  }
  // Initialisation du conteneur de la carte sans intéractions (view : visiteur).
  else{
    mymap =  L.map('mapid',{
      center:[position.lat, position.lon],
      keyboard: false,
      dragging: false,
      zoomControl: false,
      boxZoom: false,
      doubleClickZoom: false,
      scrollWheelZoom: false,
      tap: false,
      touchZoom: false,
      zoom: zoom,
      minZoom: 5,
      maxZoom: 17
    });
    setFakeEventMarker(layerEventGroup);
  }

  // Initialisation du groupe de marqueurs de position de l'utilisateur.
  tileLayer = L.layerGroup().addTo(mymap);
  // Initialisation du groupe de marqueurs de position de l'utilisateur.
  layerPositionGroup= L.layerGroup().addTo(mymap);
  // Initialisation du groupe de marqueurs des centres d'intérêts.
  layerPointOfInterestGroup = L.layerGroup().addTo(mymap);
  // Initialisation du groupe de marqueurs des évènements
  layerEventGroup = L.layerGroup().addTo(mymap);
  // Initialisation du groupe de marqueurs pour l'affichage de cercles dynamiquement
  layerCircleGroup= L.layerGroup().addTo(mymap);

  // Remplissage du conteneur de la carte.
  fillMap(tileLayer);
  // Ajout des boutons à la carte
  localisationBar = addButtonsOnMap(localisationBar,mymap)
  localisationBar.addTo(mymap)
  // Ajout des évènements à la carte
  addClickEventOnMap(mymap,layerPositionGroup);
  // Ajout d'un marqueur sur la position de l'utilisateur.
  addPositionMarkerOnMap(mymap, layerPositionGroup, position, zoom);
  // Ajout des points d'intérêts passés en paramètre.
  addPointOfInterest(layerPointOfInterestGroup,pointOfInterest);
  // Ajout des points des évènements passés en paramètre.
  addEvents(layerEventGroup, events);
  controlInit(mymap); // Controler gérant l'affichage des popups d'évènements

}

/**
 Remplissage du contenur de la carte à l'aide de l'API OpenStreetMap.
 @param tileLayer le layer à remplir.
*/
function fillMap(tilelayer){
  L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
      attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
      minZoom: 5,
      maxZoom: 17,
      color:'red',
      id: 'mapbox.streets',
      accessToken: 'pk.eyJ1Ijoic2Vhc29ueGRrIiwiYSI6ImNqdjJlZjVxZjA1NDU0M21wbmg2eThlbnkifQ.CzDcGBZxuQgRiOuIXnea3A'
  }).addTo(tileLayer);
}

// Fonctions relatives à la position de l'utilisateur

/**
 Ajout d'un marqueur de la position de l'utilisateur sur la carte.
 @param map la carte sur laquelle on affiche les marqueurs.
 @param layerPositionGroup le layer contenant la position de l'utilisateur.
 @param position la position de l'utilisateur (un objet sous la forme .lat/.long)
 @param zoom le zoom avec lequel la carte est initialisé
*/
function addPositionMarkerOnMap(map, layerPositionGroup, position, zoom){
  // Efface les marqueurs précédemments ajoutés.
  layerPositionGroup.clearLayers();
  // Création du marqueur et ajout au groupe qui lui est associé.
  let marker = L.marker([position.lat, position.lon],{icon:customIcon('red'),autoPan:true,draggable:true}).addTo(layerPositionGroup);
  getDataAddress(position,'user',marker,addToolTipOnMarker);

  // Centre la carte selon la position du marqueur
  CenterMapOnUserPosition(position,zoom)
  addCircleOnPosition(layerCircleGroup,userPosition,'green','green',0.3,0.3,1000);
  mymapZoom = map.getZoom();

  /*Test*/
  marker.on('dragend', function(event) {
    this._tooltip.remove();
    var position = marker.getLatLng();
    userPosition.lat = position.lat;
    userPosition.lon = position.lng;
    getDataAddress(userPosition,'user',this,addToolTipOnMarker);
    CenterMapOnUserPosition(userPosition,zoom)
    mymapZoom = map.getZoom();
 });
}

 function addToolTipOnMarker(marker,tooltipClassName,address){
   marker.bindTooltip(address,{
     opacity:0.9,
     permanent:true,
     direction:'right',
     className:tooltipClassName
   }).openTooltip();
 }

 /**
  Ajout d'un cercle sur la carte autours de la position de l'utilisateur.
  @param layerPositionGroup le layer contenant la position de l'utilisateur.
  @param position la position de l'utilisateur (un objet sous la forme .lat/.long)
  @param color la couleur du contours du cercle.
  @param fillColor la couleur de l'intérieur du cercle.
  @param opacity l'opacité des bordures du cercle.
  @param fillOpacity l'opacité de de l'intérieur du cercle.
  @param radius le rayon du cercle.
 */
 function addCircleOnPosition(layerPositionGroup,position,color,fillColor,opacity,fillOpacity,radius){
   // On efface les points/cercles générés lors de la dernière recherche
   layerPositionGroup.clearLayers();
   if(radius > 800)
     mymap.setView([userPosition.lat, userPosition.lon], 14);
   else{
     mymap.setView([userPosition.lat, userPosition.lon], 15);
    }
   var circle = L.circle([position.lat, position.lon], {
           color: color,
           fillColor: fillColor,
           opacity:opacity,
           fillOpacity: fillOpacity,
           radius: radius+100,
           weight: 1
       }).addTo(layerPositionGroup);
     }

// Fonctions relatives aux points d'intérêts

/**
    Ajout des points d'intérêts dans le layer passé en paramètre.
    @param layerPointOfInterestGroup le layer contenant les marqueurs des POI.
    @param pointOfInterest les points d'intérêts sous format JSON.
    @param radius rayon définissant la taille du cercle.
*/
function addPointOfInterest(layerPointOfInterestGroup, pointOfInterest, radius){
layerPointOfInterestGroup.clearLayers();
layerCircleGroup.clearLayers();
  if(pointOfInterest != undefined){
    //addCircleOnPosition(layerPointOfInterestGroup,userPosition,'green','green',0.2,0,radius)
    for(let data of pointOfInterest)
      getDataAddress(data,'POI', layerPointOfInterestGroup, setPointOfInterestMarker)
    }
}

/**
  Récupération de la chaine de caractère de l'adresse.
  @param myData la donnée à traiter.
  @param dataType le type de données 'user' ou 'POI'
  @param callbackArgument argument exécuté par la fonction callback.
  @param callback fonction à éxecuter en fin de fonction.
  @return l'adresse sous la forme d'une chaine de caractère.
*/
function getDataAddress(myData,dataType,callbackArgument, callback){
  // Objet contenant les champs de l'adresse
  var POIAddress = {
    house_number: undefined,
    road: undefined,
    postcode: undefined,
    city: undefined
  };

  if(myData.address == undefined){
    // Récupération de la réponse en JSON
    $.getJSON(reverseGeocoding(myData,dataType), function(data) {
      $POIAddress = fillAddressObject(POIAddress,data);
      (dataType == 'user') ? callback(callbackArgument,'tooltip-pos',addressObjectToString(POIAddress))
                           : callback(myData,addressObjectToString(POIAddress),callbackArgument);
     })
     .done(function() { changeCSSErrorMessage('erase'); })
     .fail(function() { (dataType == 'user') ?
                        changeCSSErrorMessage(undefined, 'Geolocalisation : Request Failed') :
                        changeCSSErrorMessage(undefined, 'POI Reverse Geocoding : Request Failed');
                      })
  }
  else{
    $POIAddress = fillAddressObject(POIAddress,myData);
    (dataType == 'user') ? callback(callbackArgument,'tooltip-pos',addressObjectToString(POIAddress))
                         : callback(myData,addressObjectToString(POIAddress),callbackArgument);
  }
}

 /** Envoie d'une requête nominatim pour obtenir une liste d'adresse potentielle à partir de coordonnées.
   @param data la donnée contenant les coordonnées.
   @param dataType le type de donnée (position de l'utilisateur ou position d'un POI).
   @return le résultat de la recherche.
 */
 function reverseGeocoding(data,dataType){
     if(dataType == 'user')
       var location = "lat="+data.lat+'&lon='+data.lon;
     else if(dataType == 'POI'){
       var location = "lat="+data.lat+'&lon='+data.lon;
     }
     else{
       console.log('error')
       return;
     }
     return "https://nominatim.openstreetmap.org/reverse?format=json&"+location+"&zoom=18&addressdetails=1";
   }

/**
  Remplissage de l'objet adresse à partir des données reçu.
  @param addressObject l'object dans lequel rentré dans l'adresse.
  @param data les données contenant l'adresse (format JSON).
*/
function fillAddressObject(addressObject,data){
  for (let property in data.address)
    if(data.address.hasOwnProperty(property))
      if(data.address[property] != undefined)
        switch (property){
          case 'house_number':addressObject.house_number = data.address[property]+' ';break;
          case 'road':addressObject.road = data.address[property]+'<br>';break;
        }
        return addressObject;
}
/**
  Récupération de la chaine de caractère de l'adresse.
  @param addressObject l'adresse rangé dans un objet.
  @return l'adresse sous la forme d'une chaine de caractère.
*/
function addressObjectToString(addressObject){
  var address = "";
  for(field in addressObject){
    if(addressObject[field] === undefined){
      continue;
    }
    else if(field === "road" && addressObject.city != undefined){
      return addressObject[field]
    }
    else{
      address+=addressObject[field]+" ";
    }
  }
  return address;
}

  /**
    Ajout des évènement/icones/popups au marqueur du POI.
    @param data le point d'intérêt.
    @param address adresse du point d'intérêt (POI).
    @param layerPointOfInterestGroup layer contenant les marqueurs des POI.
  */
  function setPointOfInterestMarker(data, address, layerPointOfInterestGroup){
    // Ajout du marqueur uniquement si la data est un point.
    // L'API peut retourner des chemins etc..
    if(data.type === "node"){
        // A remplacer par un switch pour chaque type d'amenity
        // Ajout des icones et des popups selon le type de marqueur.
        if(data.tags.amenity === 'restaurant'){
          var marker = L.marker(
            [data.lat, data.lon],{
            icon:L.divIcon({
              html: '<i class="fas fa-utensils fa-2x"></i>',
              iconSize: [20, 20],
              className: 'restaurantIcon'
            })
          }).addTo(layerPointOfInterestGroup);
          marker.bindPopup('<h4>'+data.tags.name+'</h4>'+
                           '<h2>'+data.tags.amenity+'</h2>'+
                           '<p><b>Adresse : </b>'+address+'</p>'
                           ,{
            maxWidth: '400',
            width: '200',
            className : 'POIPopup'
          });
        }
        else if(data.tags.tourism === 'museum'){
          var marker = L.marker(
            [data.lat, data.lon],{
            icon:L.divIcon({
              html: '<i class="fas fa-archway fa-lg"></i>',
              iconSize: [20, 20],
              className: 'museumIcon'
            })
          }).addTo(layerPointOfInterestGroup);
          marker.bindPopup('<h4>'+data.tags.name+'</h4>'+
                           '<h2>'+data.tags.tourism+'</h2>'+
                           '<p><b>Adresse : </b>'+address+'</p>'
                           ,{
            maxWidth: '400',
            width: '200',
            className : 'POIPopup'
          });
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


  // Fonctions relatives aux évènements

  /**
    Parcourt des données passées en paramètre et ajout d'un marqueur pour
    chaque EVENT présent dans les données.
    @param layerEventGroupa layer contenant les marqueurs des évènements.
    @param events les données JSON contenant les évènements
  */
  function addEvents(layerEventGroup, events){
    // On parcourt les données et on ajoute un marqueur pour chaque évènement de data
    if(events != undefined){
      for(let data of events){
        setEventMarker(data,layerEventGroup);
      }
    }
  }

  /**
  Ajout des évènement/icones/popups au marqueur de l'évènement.
  @param data un évènement.
  @param layerEventGroup layer contenant les marqueurs des évènements.
  */
  function setEventMarker(data, layerEventGroup){
    var marker = L.marker(
      [data.lat, data.lon],{
      icon:L.divIcon({
        html: '<i class="fas fa-star fa-3x eventIcon"></i>',
        iconSize: [20, 20],
        className: 'myDivIcon'
      })
    }).addTo(layerEventGroup);
    // Ajout d'évènement mouserover aux markers
    marker.on('click', function (e) {
      info.update(data);
      eventIsVisited(e,'black')
    });
  }


  // Fonctions relatives aux boutons

  /**
  Ajout des boutons à leur barre
  @param bar la barre à laquelle ajouter les boutons.
  @return bar la barre remplie.
  */
  function addButtonsOnMap(bar){
      var centerButton =  L.easyButton({
      id: 'centerButton',
      states:[{
        stateName: 'default',
        onClick: function(button){
          CenterMapOnUserPosition(userPosition,14);
        },
        title: 'Centre la carte sur ta position si tu t\'es perdu',
        icon: "fas fa-expand fa-la"
      }]
    });

    var selfLocateButton =  L.easyButton({
      id: 'selfLocate',
      leafletClasses: true,
      states:[{
        stateName: 'default',
        onClick: function(button){
            allowSelfLocation = true;
            changeIconCursor(allowSelfLocation);
            button.state('clicked');
        },
        title: 'Clic sur le bouton puis sur la carte pour te localiser manuellement.',
        icon: "fas fa-map-marker-alt fa-la"
      },{
        stateName: 'clicked',
        onClick: function(button){
          allowSelfLocation = false;
          changeIconCursor(allowSelfLocation);
          button.state('default');
        },
        title: 'Clic sur la carte pour déposer un marqueur.\nClique sur le bouton pour annuler la localisation manuelle.',
        icon: "fas fa-map-marker-alt fa-la"
      }]
    });

    var eventsButton =  L.easyButton({
      id: 'events',
      leafletClasses: true,
      states:[{
        stateName: 'show',
        onClick: function(button){
            layerEventGroup.remove();
            button.state('hide');
        },
        title: 'Masque tous les évènements sur la carte',
        icon: "fas fa-star fa-la"
      },{
        stateName: 'hide',
        onClick: function(button){
          layerEventGroup.addTo(mymap);
          addEvents(layerEventGroup, eventsList)
          button.state('show');
        },
        title: 'Affiche tous les évènements sur la carte',
        icon: "far fa-star fa-la"
      }]
    });

    var deletePOIButton =  L.easyButton({
      id: 'POI',
      leafletClasses: true,
      states:[{
        stateName: 'default',
        onClick: function(button){
            layerPointOfInterestGroup.clearLayers();
        },
        title: "Supprime les points d'intérêts affichés sur la carte",
        icon: "fas fa-trash-alt fa-la"
      }]
    });

    bar = L.easyBar([
        selfLocateButton,
        centerButton,
        eventsButton,
        deletePOIButton
      ]
      //,{position:'left'}
    );
    return bar;
  }

  /**
    Fonction permettant de changer la couleur d'un bouton d'évènement.
    @param button le bouton dans le dom.
    @param button la couleur du bouton (string)
  */
  function eventIsVisited(button,color){
    if(button == undefined)
      return;
    console.log($(button.sourceTarget._icon.firstChild));
    $(button.sourceTarget._icon.firstChild).css("-webkit-text-stroke-width","1px");
    $(button.sourceTarget._icon.firstChild).css("-webkit-text-stroke-color", color);
    $(button.sourceTarget._icon.firstChild).css("transition", '1s');
    $(button.sourceTarget._icon.firstChild).css("animation", 'none');
    $(button.sourceTarget._icon.firstChild).attr('class', 'fas fa-star eventIcon fa-2x');
  }

  /**
    Fonction permettant de récupérer un bouton à l'intérieur de son groupe.
    @param bar la barre où se situe le bouton.
    @param buttonName le nom du bouton.
    @param button le bouton avec le nom buttonName.
  */
  function getButton(bar,buttonName){
    for(let button of bar._buttons)
      if(button.button.id == buttonName)
        return button;
  }
