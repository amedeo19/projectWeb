function formhash() { // Per poter essere sicuro dovrebbe essere https in quanto il passaggio dell' html al js non potrebbe esssere sniffato

   var form = $("#inputform");
   var password = document.getElementById("idPassword");
   // Crea un elemento di input che verrà usato come campo di output per la password criptata.
   if (password.value) {
     if ((p == null) || (p === undefined)){
        console.log("p nullo");
     }else{
        console.log("bau");
        document.deleteElement(p);
     }
     var p = document.createElement("input");
     if ((p != null) || (p !== undefined)){
        console.log("creato");
     }
     // Aggiungi un nuovo elemento al tuo form.
     p.name = "p";
     p.type = "hidden";
     p.value = hex_sha512(password.value);


     if ((form == null) || (form === undefined)){
        console.log("form nullo");
     }
     console.log(p.value);
     var div = document.createElement("div");
     div.appendChild(p);
     document.body.appendChild(div);
     // Assicurati che la password non venga inviata in chiaro..value);
  }
  var email = $("#inputEmail").val();
  // Crea un elemento di input che verrà usato come campo di output per la email criptata.
  console.log(email);
  if (email) {
    var email = document.createElement("input");
    // Aggiungi un nuovo elemento al tuo form.
    form.appendChild(email);
    email.name = "email";
    email.type = "hidden";
    email.value = base64_encode(email);
    // Assicurati che la email non venga inviata in chiaro.
    email = "";
    return false;
 }
    $("#inputform").submit();
}
