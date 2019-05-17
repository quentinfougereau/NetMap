// Variables globales
var resultList = [];
var city;

/* Récupération de la ville de l'utilisateur à partir de son adresse IP.
   Lancé automatiquement au démarage de la page.
*/
/*(function(){
  $.getJSON('http://ip-api.com/json/', function(data) {
    city = data.city;
  });
})();*/

/*Ajout d'un eventListener au chargement de la page.
  Il sert à détecter l'addresse rentré par l'utilisateur.
*/
window.addEventListener("load", function(){
    // Récupération de la div où afficher les résultats.
    var name_input = document.getElementById('addrArea');
    // Ajout d'un eventListener à la div lorsque l'utilisateur presse une touche.
    name_input.addEventListener("keyup", function(event){showSearchResults(event)});
});

//A MODIFIER
/**
   Affiche des 5 premiers résultats obtenu lors de la recherche
   sous la barre où l'utilisateur rentre son adresse.
   @param event évènement passé en paramètre.
*/
function showSearchResults(event) {
  // Récupération de la valeur du champs texte
  var address = $('#addrArea').val();
  var parentDiv = $('.searchResultContainer').children();
  //Si l'input de l'utilisateur est vide on return
  if(address.length == 0){
    console.log("test")
    cleanResultsDiv(parentDiv,null)
    return;
  }
  // Réinitialisation du tableau à chaque nouvelle recherche
  resultList.length = 0;
  var count;
  // Définition de la requête
  if(city != undefined){
    var nominatim = 'https://nominatim.openstreetmap.org/search?q='+address+','+city+','+'France&format=json&polygon=1&addressdetails=1';
  }
  else{
    var nominatim = 'https://nominatim.openstreetmap.org/search?q='+address+',France&format=json&polygon=1&addressdetails=1';
  }
  // Requête JSON
  $.getJSON(nominatim,function(data) {
    if(data.length != 0){
      for(i=0 ;(i<data.length && i<5) ; i++) {
        parentDiv.eq(i).off('click');
        dataParsing(data[i]);
        resultToString(resultList[i], address, parentDiv.eq(i))
        count++;
      }
      cleanResultsDiv(parentDiv,5-count);
    }
    else{
      cleanResultsDiv(parentDiv)
    }
  })
  .done(function() { changeCSSErrorMessage('erase'); })
  .fail(function() { changeCSSErrorMessage(undefined, 'Auto Complete : Request Failed'); })
}

/**
   Ajout des données récupérées dans l'objet addressObject et ajout de l'objet
   au tableau.
   @param data l'object contenant les données géographiques.
*/
function dataParsing(data){
  var addressObject = {
    lon: data.lon,
    lat: data.lat,
    address: {
      house_number:data.address.house_number,
      road:data.address.road,
      postcode: data.address.postcode,
      county: data.address.county
    }
  }
  resultList.push(addressObject);
}

/**
   Transforme l'adresse contenu dans l'objet result en string.
   @param result l'object contenant les données géographiques.
   @param userInput l'adresse rentré par l'utilisateur
   @param container le container dans lequel ajouter les informations à afficher.
*/
function resultToString(result, userInput, container){
  var str =" ";
    if( (result.address.county != undefined) && (result.address.county.toUpperCase() == userInput.toUpperCase()) ){
      str = '<p>'+result.address.county;
      if(result.address.postcode != undefined)
        str+='<br>'+result.address.postcode+'</p>';
      else { str+='</p>' }
      printData(container,result,str,true)
  }
  else{
    str+="<p>"
    for (var property in result.address) {
      if(result.address.hasOwnProperty(property))
        if(result.address[property] != undefined){
          switch (property){
            case 'house_number':str+=result.address[property]+', ';break;
            case 'road':str+=result.address[property]+'<br>';break;
            case 'postcode':str+=result.address[property]+' ';break;
            case 'county': str+=result.address[property];break;
          }
        }
      }
      str+='</p>'
      printData(container,result,str,false);
    }
  }

  /**
     Ajout des adresses à la DIV et modificiation du style pour affichage.
     @param container le parent contenant les divs à afficher.
     @param data les données auxquelles ajouter les évènement.
     @param resultString l'adresse contenu dans data sous format String.
     @param resultIsCity booléen pour connaître la nature du résultat.
  */
function printData(container,data,resultString,resultIsCity){
    container.html(resultString);
    container.css('border','solid 1px rgba(255,255,255, 0.9)')
    if(resultIsCity){
      container.click(function() {
        resultEvent(data,12);
      });

    }
    else{
      container.click(function() {
        resultEvent(data,14);
      });
  }
}

/**
   Evènement initialisant la carte lors d'un clic sur le résultat.
   @param data les données contenant les coordonnées géographiques.
   @param zoom le zoom avec lequel initialisé la carte.
*/
function resultEvent(data,zoom){
  userPosition.lat = data.lat;
  userPosition.lon= data.lon;
  if(mymap == undefined){
    initMap(userPosition,undefined, eventsList, 'user',zoom);
  }
  else{
    addPositionMarkerOnMap(mymap, layerPositionGroup, userPosition, zoom)
  }
  $('#addrArea').val("");
  cleanResultsDiv($('.searchResultContainer').children());
}


/**
   Supprime les DIV inutilisées et initialisée à la précédente recherche.
   ie: 4 résultats trouvés à la précédente recherche, 2 à la nouvelle.
   --> On supprime les 2 divs inutilisées.
   @param parent le parent des divs à supprimer.
   @param index le nombre de div à supprimer.
*/
function cleanResultsDiv(parent,index){
  if(index == null || index == undefined){
    parent.each(function(e){
      parent.eq(e).html("");
      parent.eq(e).off('click');
      parent.eq(e).css('border','solid 0px rgba(255,255,255, 0)')
    });
  }
  else{
    for(i=4; i>index;i--)
      parent.eq(index).html("");
  }
}

/* Transforme l'adresse en coordonnées à l'aide de l'API NOMINATIM et
   localisation de l'utilisateur à partir des coordonnées récupérées.
*/
function locateByAddress(){
  var address = $('#addrArea').val();
  if(address.length == 0){
    return;
  }
  var nominatim = 'https://nominatim.openstreetmap.org/search?q='+address+',France&format=json&polygon=1&addressdetails=1';
  $.getJSON(nominatim,function(data) {
    if(data){
      changeCSSErrorMessage('erase');
      // Ajout des coordonnées récupéré par le navigateur à l'objet.
      userPosition.latitude =  data[0].lat;
      userPosition.longitude =  data[0].lon;
      if(mymap == undefined){
        initMap(userPosition,undefined, eventsList, 'user',14);
      }
      else{
        addPositionMarkerOnMap(mymap, layerPositionGroup, userPosition);
      }
    }
    else{
      var info = "Aucun résultat trouvé pour cette adresse."
      changeCSSErrorMessage(false, info);
    }
  })
  .done(function() { changeCSSErrorMessage('erase'); })
  .fail(function() { changeCSSErrorMessage(undefined, 'ADDR Reverse Geocoding : Request Failed'); })
}
