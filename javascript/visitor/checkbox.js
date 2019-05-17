// Tableau global des centres d'intérêts (POI)
var interestChecked = [];
var radius;

/**
  Ajoute/Retire les points d'intérêts (POI) au DOM selon qu'ils soient cochés ou non.
  @param box l'élément du DOM 'input=checkbox'
*/
function caseIsChecked(box){
  var boxName = $(box).attr('name');
  if($(box).prop('checked')){
    $('#interestSelected').append("<input type='hidden' name="+boxName+" id="+boxName+"Checked"+" value="+boxName+">");
  }
  else{
    $('#'+boxName+"Checked").remove();
  }
}

// Décoche les cases de la checkbox et réinitialise les champs cachés
function uncheckAllCases(){
  var childs = $('.checkbox').find("input").each(function (){
    this.checked = false;
  });
  childs = $('#interestSelected').find("input").each(function(){
  this.remove();
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
    url: "http://localhost/NetMap/scripts/getPOI.php",
    data: {data : interestChecked,userPosition,radius},
    success: function(response) {
      var info = "Aucun résultat trouvé."
      changeCSSErrorMessage('erase');
      if(response != null && response.length != 0){
        var info = "Aucun résultat trouvé."
        addPointOfInterest(layerPointOfInterestGroup, response, radius);
        stopLoading();
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
  uncheckAllCases();
}

// Fonction utilitaire servant à afficher la valeur de la range en nombre
(function(){
	$('.range').next().text(1000);
	$('.range').on('input', function(){
    if(mymap != undefined){
      var $set = $(this).val();
      radius = parseInt($set,10);
      addCircleOnPosition(layerCircleGroup,userPosition,'green','green',0.3,0.3,radius);
    }
		var $set = $(this).val();
		$(this).next().text($set);
  });
})()
