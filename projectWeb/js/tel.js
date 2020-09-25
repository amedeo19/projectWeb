function checkTel(){

  var badColor = "#ff6666";
  document.getElementById("confirmTel").style.color = badColor;

  var txt = $("#inputTelefono").val();

  if (txt.length!=10) {
    document.getElementById("confirmTel").innerHTML = "Il numero di telefono deve avere 10 cifre";
    return false;
  }else{
    document.getElementById("confirmTel").innerHTML = "";
  }

  return true;
}
