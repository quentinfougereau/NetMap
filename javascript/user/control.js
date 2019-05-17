// Variable globale (le controleur)
var info = L.control();

/**
  Initialisation d'un controleur.
  @param map la carte à laquelle on ajoute le controleur.
*/
function controlInit(map){
  // Fonction exécuté à l'ajout du controleur.
  info.onAdd = function (map) {
      this._div = L.DomUtil.create('div', 'popup-info'); // create a div with a class "info"
      this.update();
      return this._div;
  }

  /**
      Fonction exécuté lors de l'update du controleur.
      On cache/affiche la popup et modifie l'aspect du bouton déclenchement l'évènement.
      @param prop l'object contenant le texte à afficher.
  */
  info.update = function (props) {
    if(props != undefined){
      hidePopup(this._div, false);
      var img = '<h4><img src="img/star.svg" id="starInfoIcon"/>'
      var btn = '<button class="styled" type="button" onClick="hidePopup(this.parentNode,'+true+')">X</button>'
        this._div.innerHTML = btn+img+props.name+'</h4>' +
                              '<p><b>Lieu : </b>'+props.place+'</p>' +
                              '<p><b>Adresse : </b>'+props.street+' ('+props.postcode+')</p>' +
                              '<p><a href='+"xd"+'>Lien d\'inscription à l\'évènement</a><p>';
      }
    else{
      hidePopup(this._div, true);
    }
  }
  info.addTo(map);
}

/**
    Met à jour les informations de la popup.
    @param e l'objet contenant les informations à afficher.
*/
function showInfo(e) {
    info.update(e);
}

/**
    Réinitialise les informations de la popup.
    @param e l'objet contenant les informations à afficher.
*/
function resetInfo() {
    info.update();
}

/**
    Fonction éxecutée en cas de mis à jour du controleur sans paramètres
    Elle modifie le style du CSS pour cacher/afficher la popup.
    @param div la DIV où se trouve l'objet.
    @param status un boolean pour décider si l'on affiche/cache la popup.
*/
function hidePopup(div,status){
  if(status){
    $(div).css("background","none");
    $(div).css("box-shadow","none");
    div.innerHTML = "";
  }
  else{
    $(div).css("background","rgba(255,255,255,0.8)");
    $(div).css("box-shadow","0 0 15px rgba(0,0,0,0.2)");
  }
}
