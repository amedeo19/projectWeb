function checkCity(){

  var badColor = "#ff6666";
  document.getElementById("confirmCity").style.color = badColor;

  var txt = $("#inputCittà").val();

  if (txt.length<3){
    document.getElementById("confirmCity").innerHTML = "Il nome della città deve avere almeno 3 lettere";
  }else if (txt.length>25){
    document.getElementById("confirmCity").innerHTML = "Il nome della città non può avere più di 25 lettere";
  }else{
    var text = /^[A-Za-z]+$/.test(txt);
    if (!text){
      document.getElementById("confirmCity").innerHTML = "Il nome della città è composto di sole lettere";
    }else{
      document.getElementById("confirmCity").innerHTML = "";
      return true;
    }
  }
  return false;
}
