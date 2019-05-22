// Variable globale (le controleur)
var checkbox = L.control({position: 'bottomleft'});
// Tableau global des centres d'intérêts (POI)
var interestChecked = [];
var radius;


/**
  Initialisation d'un controleur.
  @param map la carte à laquelle on ajoute le controleur.
*/
function checkboxControlInit(map){
  // Fonction exécuté à l'ajout du controleur.
  checkbox.onAdd = function (map) {
      this._div = L.DomUtil.create('div', 'checkbox'); // create a div with a class "checkbox"
      L.DomEvent.disableClickPropagation(this._div);
      initCheckbox(this._div)

      return this._div;
  }
  checkbox.addTo(map);
}

/**
    Fonction éxecutée en cas de mis à jour du controleur sans paramètres
    Elle modifie le style du CSS pour cacher/afficher la popup.
    @param div la DIV où se trouve l'objet.
    @param status un boolean pour décider si l'on affiche/cache la popup.
*/

function initCheckbox(div){

    var  choiceDiv = '<div class="choice">'
    var  closeDiv =  '</div>'

    // Case musée
    var museum= '<div>'+
        '<input type="checkbox" id="museum" name="museum" onClick="caseIsChecked(this)" unchecked>'+
        '<label for="musées">Musées</label>'+
        '</div>'


    // Case restaurant
    var restaurant = '<div>'+
        '<input type="checkbox" id="restaurant" name="restaurant" onClick="caseIsChecked(this)" unchecked>'+
        '<label for="restaurant">Restaurant</label>'+
        '</div>'

    // Range (sélection du RADIUS)
    var range = '<div id="rangeRadius">'+
          '<input id="range" type="range" value="1000" min="500" max="2000" step="100">'+
          '<output></output>'+
          '</div>'

    // Bouton de recherche
    var searchButton = '<div id="POIButton">'+
          '<input type="button" value="Chercher" onClick="sendCheckedCases()"/>'+
          '</div><div id="interestSelected"></div>'

    div.innerHTML = choiceDiv+museum+restaurant+closeDiv+range+searchButton;
    addEventToRange(div);

  }

  function addEventToRange(div){
    console.log(div.children[1].nextSibling)
        $(div.children[1].children[1]).text(1000);
        $(div.children[1].children[0]).on('input', function(){
          if(mymap != undefined){
            var $set = $(this).val();
            radius = parseInt($set,10);
            addCircleOnPosition(layerCircleGroup,userPosition,'green','green',0.3,0.3,radius);
          }
          var $set = $(this).val();
          $(this).next().text($set);
        });
  }

  // Envoie des cases cochées (POI) au serveur via AJAX.
  function sendCheckedCases(){
    if(mymap == undefined || mymap == null){
      //Affichage d'un message d'erreur à ajouter
      return;
    }
    startLoading();
    interestChecked.length = 0;


    // Ajout des cases cochées dans le tableau
    var childs = $('#interestSelected').children();
    childs.each(function(index){
      var value = $((childs).get(index)).val();
      interestChecked.push(value);
    });

    // Récupération du radius de la range.
    radius = parseInt($('#rangeRadius').find("output").html(),10);

    // Envoie des POI au serveur PHP via une requête AJAX.
    $.ajax({
      type: "POST",
      url: "../scripts/getPOI.php",
      data: {data : interestChecked,userPosition,radius},
      success: function(response) {
        //console.log(response)
        console.log(userPosition)
        console.log(interestChecked)
        changeCSSErrorMessage('erase');
        if(response != null && response.length != 0){
          var info = "Aucun résultat trouvé."
          addPointOfInterest(layerPointOfInterestGroup, response, radius);
          stopLoading();
          ajaxInsertPOI(response);
        }
        else{
          //Erreur à afficher//
          var info = "Aucun résultat trouvé."
          changeCSSErrorMessage(false, info)
          layerPointOfInterestGroup.clearLayers();
          layerCircleGroup.clearLayers();
          stopLoading();
        }
      },
      error: function(error){
        var info = "Il y a eu un soucis dans la recherche des points d'intérêts."
        changeCSSErrorMessage(false, info)
        layerPointOfInterestGroup.clearLayers();
        layerCircleGroup.clearLayers();
        stopLoading();
      },
      dataType: 'json'
    });
  }

  /**
    Ajoute/Retire les points d'intérêts (POI) au DOM selon qu'ils soient cochés ou non.
    @param box l'élément du DOM 'input=checkbox'
  */
  function caseIsChecked(box){
    var boxName = $(box).attr('name');
    if($(box).prop('checked')) {
      $('#interestSelected').append("<input type='hidden' name="+boxName+" id="+boxName+"Checked"+" value="+boxName+">");
    }
    else {
      $('#'+boxName+"Checked").remove();
    }
  }

  // Décoche les cases de la checkbox et réinitialise les champs cachés
  function uncheckAllCases() {
    //var childs = $('.checkbox').find("input").each(function (){
  //    this.checked = false;
    //});
    childs = $('#interestSelected').find("input").each(function(){
    this.remove();
    });
  }

  function ajaxInsertPOI(nodes) {
    $.ajax({
      type: "POST",
      url: "../scripts/insertPOI.php",
      data: {data : nodes},
      success: function(response) {
        console.log(response);
      },
      error: function(error) {
      },
      dataType: 'text'
    });
  }