function controlPassword()
{

    var txt = $("#idRipetiPassword").val();
    //Store the Confimation Message Object ...
    var message = document.getElementById('confirmMessage');
    //Set the colors we will be using ...
    var goodColor = "#66cc66";
    var badColor = "#ff6666";
    //Compare the values in the password field
    //and the confirmation field
    message.style.color = badColor;
    if (txt.length<5){
      message.innerHTML = "La password da ripetere è troppo breve!";
    }else if($('#idPassword').val()<5){
      message.innerHTML = "La password è troppo breve!";
    }else{
      message.innerHTML = "";
      if($('#idPassword').val() == txt){
          //The passwords match.
          //Set the color to the good color and inform
          //the user that they have entered the correct password
          message.style.color = goodColor;
          message.innerHTML = "Le password corrispondono!";
          return true;
      }else{
          //The passwords do not match.
          //Set the color to the bad color and
          //notify the user.
          message.innerHTML = "Le password non corrispondono!";
      }
    }
    return false;
}
