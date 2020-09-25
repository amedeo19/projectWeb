function checkName(){

  var badColor = "#ff6666";
  document.getElementById("confirmName").style.color = badColor;

  var txt = $("#inputNome").val();


  if (txt.length<3){
    document.getElementById("confirmName").innerHTML = "Il nome deve avere almeno 3 lettere";
  }else if (txt.length>15){
    document.getElementById("confirmName").innerHTML = "Il nome non può avere più di 15 lettere";
  }else{
    var text = /^[A-Za-z]+$/.test(txt);
    if (!text){
      document.getElementById("confirmName").innerHTML = "Il nome deve essere composto di sole lettere";
    }else{
      document.getElementById("confirmName").innerHTML = "";
      return true;
    }
  }
  return false;
}
