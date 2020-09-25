function checkEmail() {

  var badColor = "#ff6666";
  document.getElementById("confirmEmail").style.color = badColor;

  var txt = $("#inputEmail").val();

  var text=/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(txt);
  if (!text){
    document.getElementById("confirmEmail").innerHTML = "La mail deve essere valida";
    return false;
  }else{
    document.getElementById("confirmEmail").innerHTML = "";
    return true;
  }
}
