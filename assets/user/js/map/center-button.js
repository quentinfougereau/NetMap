// Centre la carte sur la position de l'utilisateur.
function CenterMapOnUserPosition(position,zoom) {
  console.log(zoom);
  (zoom == undefined) ? mymap.setView([position.lat, position.lon], 14,
    {pan:{
        animate: true,
        duration: 1
        },
    zoom: {
        animate: true
    }})
  : mymap.setView([position.lat, position.lon], zoom,
    {pan:{
        animate: true,
        duration: 1
    },
    zoom: {
        animate: true
    }});

 }
