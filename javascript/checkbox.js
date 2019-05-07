var interestChecked = [];

function isChecked(box){
  var name = $(box).attr('name');
  if($(box).prop('checked')){
    $('#interestSelected').append("<input type='hidden' name="+name+" id="+name+"Checked"+" value="+name+">");
  }
  else{
    $('#'+name+"Checked").remove()
  }
}

function sendPOI(){
  interestChecked.length = 0;
var childs = $('#interestSelected').children();
  childs.each(function(index){
    var value = $((childs).get(index)).val();
    interestChecked.push(value);
  });

  console.log("TESST : " + interestChecked);

  $.ajax({
    type: "POST",
    url: "http://localhost/NetMap/place/placeIndex.php",
    data: {interests : interestChecked},
    success: function(response) {
      console.log(response);
    },
    dataType: 'json'
  });

}
