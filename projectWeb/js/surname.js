function checkSurname(){

  var badColor = "#ff6666";
  document.getElementById("confirmSurname").style.color = badColor;

  var txt = $("#inputCognome").val();

  if (txt.length<3){
    document.getElementById("confirmSurname").innerHTML = "Il cognome deve avere almeno 3 lettere";
  }else if (txt.length>20){
    document.getElementById("confirmSurname").innerHTML = "Il cognome non può avere più di 20 lettere";
  }else{
    var text = /^[A-Za-z]+$/.test(txt);
    if (!text){
      document.getElementById("confirmSurname").innerHTML = "Il cognome deve essere composto di sole lettere";
    }else{
      document.getElementById("confirmSurname").innerHTML = "";
      return true;
    }
  }
  return false;
}
