// Tableau global des centres d'intérêts (POI)
var interestChecked = [];

// Ajoute/Retire les POI au DOM selon qu'ils soient cochés ou non.
// Dans notre cas l'attribut est l'input (this) du onClick où la fonction est appelée
function isChecked(box){
  var name = $(box).attr('name');
  if($(box).prop('checked')){
    $('#interestSelected').append("<input type='hidden' name="+name+" id="+name+"Checked"+" value="+name+">");
  }
  else{
    $('#'+name+"Checked").remove();
  }
}

// Décoche les cases de la checkbox et réinitialise les champs cachés
function uncheckAll(box){
  var childs = $('.checkbox').find("input").each(function (){
    this.checked = false;
  });
  childs = $('#interestSelected').find("input").each(function(){
  this.remove();
  });
}

// Ajout des centres d'intérêts au tableau en fonction du DOM et envoie
// des données au serveur via AJAX.
function sendPOI(){
  // Vérification de l'initialisation de la map
  // Si la carte n'est pas initialisée, on quitte.
  if(mymap == undefined || mymap == null){
    //Affichage d'un message d'erreur à ajouter
    return;
  }
  // Réinitialisation du tableau
  interestChecked.length = 0;


  // Ajoute les POI cochés du DOM dans le tableau
  var childs = $('#interestSelected').children();
  childs.each(function(index){
    var value = $((childs).get(index)).val();
    interestChecked.push(value);
  });

  // Récupère le radius de la range.
  var radius = parseInt($('#rangeRadius').find("output").html(),10);

  // Envoie des POI au serveur PHP via une requête AJAX.
  $.ajax({
    type: "POST",
    url: "http://localhost/NetMap/route/route_place.php",
    data: {data : interestChecked,userPosition,radius,action:"addPlaces"},
    success: function(response) {
      //On ajoute les POI sur la carte
      if(response != null && response.length != 0){
        //addCircleOnPosition(layerPointOfInterestGroup,userPosition,'white','red',0.3,radius+100)
        addPointOfInterest(layerPointOfInterestGroup, response, radius);
      }
    },
    dataType: 'json'
  });
  uncheckAll();
}

// Fonction utilitaire servant à afficher la valeur de la range en nombre
// Cercle du radius à ajouter lorsque la requête PHP prendra compte de
// ce nombre.
(function(){
	$('.range').next().text(1000);
	$('.range').on('input', function(){
		var $set = $(this).val();
		$(this).next().text($set);
  });
})()
