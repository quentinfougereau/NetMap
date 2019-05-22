function changeLockIconCSS() {
    var div = $('.eventPopup .leaflet-popup-content-wrapper a');
    div.hover(function() {
    $('.lockImg').attr('class','fas fa-unlock fa-lg lockImg')
    $('.lockImg').css('color','green')
  },
  function() {
    // on mouseout, reset the background colour
    $('.lockImg').attr('class','fas fa-lock fa-lg lockImg')
    $('.lockImg').css('color','red');
  })
};
