//Pas optimisé du tout.

// Cercle de chargement ajouté à sa DIV.
function startLoading() {
    $('#loading').prepend('<img id="loadingImg" src="img/loading.gif"/>');
}
// Suppression du cercle à sa DIV.
function stopLoading() {
    $('#loadingImg').remove();
}
