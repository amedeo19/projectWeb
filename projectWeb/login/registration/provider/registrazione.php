<?php

  include './../../../html/utilities/db_connect.php';
  include './../../../html/utilities/functions.php';

  sec_session_start();
  $myArray = array();
  $myCat = array();

  class CategoriaScelta {
    public $nome;

    function __construct($nome) {
      $this->nome=$nome;
    }
  }

  $conn = connectToDatabase();

  $query_sql2="SELECT * FROM categoria";
  $result2 = $conn->query($query_sql2);
  if ($result2->num_rows > 0) {
    while ($row = $result2->fetch_assoc()) {
      $myCategoriaScelta = new CategoriaScelta($row["nome"]);
      $myCat[]=$myCategoriaScelta;
    }
  }

  if (isset($_GET['error'])) {
    $format = "col-sm-10 col-10";
    $res = intval($_GET['error']);?>
    <div>
    <?php
    switch ($res) {
      case -1: echo errorOccured($format, "La email seguente è già collegata ad un account!");
               break;
      case -2: echo errorOccured($format, "Riempire tutti i campi!");
               break;
      case -3: echo errorOccured($format, "Connessione errata!");
               break;
      case -4: echo errorOccured($format, "Almeno una delle foto non sono valide, non è un formato riconosciuto!");
               break;
      default: echo errorOccured($format, 'Errore non riconosciuto: Error#'.$res);
               break;
    };
    ?></div><?php
 }
?>

<!DOCTYPE HTML>
<html lang="it">
  <head>
    <!--<base>-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- CSS-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous" type="text/css">
    <link rel="stylesheet" href="./../../../css/theme.css" type="text/css">

    <!-- Optional JavaScript -->
    <!-- jQuery and validator first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.0/dist/jquery.validate.min.js" integrity="sha384-jR1IKAba71QSQwPRf3TY+RAEovSBBqf4Hyp7Txom+SfpO0RCZPgXbINV+5ncw+Ph" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- Check Name-->
    <script src="./../../../js/name.js"></script>

    <!-- Check Name-->
    <script src="./../../../js/surname.js"></script>

    <!-- Control Password-->
    <script src="./../../../js/control_password.js"></script>

    <!-- Control Email-->
    <script src="./../../../js/check_email.js"></script>

    <!-- Check City-->
    <script src="./../../../js/city.js"></script>

    <!-- Check Tel-->
    <script src="./../../../js/tel.js"></script>

    <!-- Check Fomr-->
    <script src="./../../../js/form.js"></script>

    <!-- Enrcypted password-->
    <script src="./../../../js/sha512.js"></script>

    <title>Login</title>
  </head>
  <body style="background-color:#4D4D4D">
    <div class="container" style="margin-bottom:50px;">
    </div>
    <div class="container-fluid">
		  <div class="row">
			  <div class="col-12 col-md-6 offset-md-3">

				 <div class="alert alert-danger alert-js" role="alert" style="display: None">
  					Dati inseriti non corretti
  					<p></p>
          </div>
          <div class="col-md-6 offset-md-3">
            <div class="thumbnail">
              <figure class="FoodImage">
                <img src="./../../../images/FoodImage.jpg" style="width:100%" alt="FoodImage" class="img-fluid w-100"></img>
              </figure>
            </div>
          </div>
          <main>
            <section id="schermata_di_registrazione">
      				<form id="inputform" method="post" action="checkRegistration.php" onsubmit="return validateForm()"  enctype="multipart/form-data">
                <fieldset class= "border border-light mt-2" id="registrazione">
                  <legend class="w-50 text-center">REGISTRAZIONE</legend>
                  <div class="card card-body bg-secondary">
                    <div class="form-group">
                      <label for="inputNome">NOME</label>
                      <input type="text" name="nome" class="form-control" id="inputNome" onfocusout="checkName();return false" placeholder="Inserisci username" required></input>
                      <span id="confirmName" class="confirmMessage"></span>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail">EMAIL</label>
                      <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Inserisci Email" onfocusout="checkEmail(); return false;" required></input>
                      <span id="confirmEmail" class="confirmMessage"></span>
                    </div>
          				  <div class="form-group">
          					<label for="inputCategoria">CATEGORIA</label>
                    <select name="categoria" style="border-radius:15px;background-color:#4D4D4D;" required>

                      <?php foreach ($myCat as $key => $value) { ?>
                        <option name="nomeCat" value="<?php echo $value->nome; ?>"><?php echo $value->nome; ?></option>
                      <?php } ?>

                    </select>
          				  </div>
                    <div class="form-group">
                      <label for="inputPassword">PASSWORD</label>
                      <input type="password" name="password" class="form-control" id="idPassword" minlength="5" placeholder="Inserisci Password" onfocusout="controlPassword(); return false;" required></input>
                      <span id="confirmMessage" class="confirmMessage"></span>
                    </div>
                    <div class="form-group">
                      <label for="ripetiPassword">RIPETI PASSWORD</label>
                      <input type="password" name="ripetiPassword" class="form-control" id="idRipetiPassword" minlength="5" placeholder="Ripeti Password" onkeyup="controlPassword(); return false;" required></input>
                    </div>
                    <div class="form-group">
                      <label for="inputCittà">CITTA'</label>
                      <input type="text" name="città" class="form-control" id="inputCittà" placeholder="Inserisci Città" onfocusout="checkCity(); return false;" required></input>
                      <span id="confirmCity" class="confirmMessage"></span>
                    </div>
                    <div class="form-group">
                      <label for="inputIndirizzo">INDIRIZZO</label>
                      <input type="text" name="indirizzo" class="form-control" id="inputIndirizzo" placeholder="Inserisci Indirizzo" required>
                    </div>
                    <div class="form-group">
                      <label for="inputTelefono">TELEFONO</label>
                      <input type="text" name="telefono" class="form-control" id="inputTelefono" minlength="10" maxlength="10" placeholder="Inserisci Telefono" onfocusout="checkTel(); return false;" required>
                      <span id="confirmTel" class="confirmMessage"></span>
                    </div>
                    <div class="form-group">
                      <label for="inputDesc1">PRIMA DESCRIZIONE</label>
                      <input type="text" name="descrizione1" class="form-control" id="inputDesc1" maxlength="300" placeholder="Inserisci Descrizione" required>
                    </div>
                    <div class="form-group">
                      <label for="inputDesc2">SECONDA DESCRIZIONE</label>
                      <input type="text" name="descrizione2" class="form-control" id="inputDesc2" maxlength="300" placeholder="Inserisci Descrizione" required>
                    </div>
                    <div>
                      <label for="inputImage1">IMMAGINE 1</label>
                      <input type="file" name="immagine1" accept="image/*" id="inputImage1" capture required></input>
                      <canvas style="max-width: 310px" id="canvas1"></canvas>
                    </div>
                    <div>
                      <label for="inputImage2">IMMAGINE 2</label>
                      <input type="file" name="immagine2" accept="image/*" id="inputImage2" capture required></input>
                      <canvas style="max-width: 310px" id="canvas2"></canvas>
                    </div>
                    <div>
                      <label for="inputImage3">IMMAGINE 3</label>
                      <input type="file" name="immagine3" accept="image/*" id="inputImage3" capture required></input>
                      <canvas style="max-width: 310px" id="canvas3"></canvas>
                    </div>
                  </div>
                </fieldset>
                  <div class="registrazione col-md-6 offset-md-3">
                    <input type="button" value="Torna al Login" onClick="location.href='./../../access/login.php'" name="Torna al Login" class="btn btn-primary"></input>
                    <input type="submit" class="btn btn-primary avanti" value="Avanti"></input>
                    <input type="hidden" name="sent" value="true"/></input><!-- schermata di conferma-->
                  </div>
                </form>
              </section>
            </main>
			    </div>
		    </div>
	    </div>

  <script data-cfasync="false" src="./../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
  <script>
  function validateForm() {
    var a = checkName();
    if (a == false) {
      alert("Il nome è errato!");
      return false;
    }
    var b = checkSurname();
    if (b == false) {
      alert("Il cognome è errato!");
      return false;
    }
    var c = checkEmail();
    if (c == false) {
      alert("L' email è errata!");
      return false;
    }
    var d = checkCity();
    if (d == false) {
      alert("La città è errata!");
      return false;
    }
    var e = checkTel();
    if (e == false) {
      alert("Il numero di telefono è errato!");
      return false;
    }
    var f = controlPassword();
    if (f == false) {
      alert("Una delle due password è errata!");
      return false;
    }
    if ((a != false) && (b != false) && (c != false) && (d != false) && (e != false) && (f != false)){
        formhash('inputForm');
    }
  }
  </script>

  <script>

  var input1 = document.querySelector('#inputImage1');
  var input2 = document.querySelector('#inputImage2');
  var input3 = document.querySelector('#inputImage3');

  input1.onchange = function () {
    var file = input1.files[0];

    upload(file);
    drawOnCanvas(file,"canvas1");
  };

  input2.onchange = function () {
    var file = input2.files[0];

    upload(file);
    drawOnCanvas(file,"canvas2");
  };

  input3.onchange = function () {
    var file = input3.files[0];

    upload(file);
    drawOnCanvas(file,"canvas3");
  };

  function upload(file) {
    var form = new FormData(),
    xhr = new XMLHttpRequest();


    form.append('image', file);
  }

  function drawOnCanvas(file,str) {
    var reader = new FileReader();

    reader.onload = function (e) {
      var dataURL = e.target.result,
          c = document.getElementById(str),
          ctx = c.getContext('2d'),
          img = new Image();

      img.onload = function() {
        c.width = img.width;
        c.height = img.height;
        ctx.drawImage(img, 0, 0);
      };

      img.src = dataURL;
    };

    reader.readAsDataURL(file);
  }
  </script>

  </body>
  <footer class="footer">
    <div class="container bg-dark text-white" style="max-width: 100%">
      <div class="row">

        <div class="p-4 col-md-6 offset-md-3">
          <h2 class="mb-2 text-light">Metodi di pagamento</h2>
          <div class="iconpay mb-4">
            <em class="fa fa-3x fa-cc-mastercard mr-2" style="color:#aaaaaa;"></em>
            <em class="fa fa-3x fa-cc-visa mr-2" style="color:#aaaaaa;"></em>
            <em class="fa fa-3x fa-cc-paypal mr-2" style="color:#aaaaaa;"></em>
            <em class="fa fa-3x fa-btc" style="color:#aaaaaa;"></em>
          </div>
          <h2 class="mb-2 text-light">Social</h2>
          <div class="iconsocial">
            <a href="https://www.facebook.com" target="_blank"><em class="fa fa-3x fa-facebook-square zoom mr-2"></em></a>
            <a href="https://www.twitter.com" target="_blank"><em class="fa fa-3x fa-twitter-square zoom mr-2"></em></a>
            <a href="https://www.instagram.com" target="_blank"><em class="fa fa-3x fa-instagram zoom mr-2"></em></a>
            <a href="https://www.telegram.org" target="_blank"><em class="fa fa-3x fa-telegram zoom"></em></a>
          </div>
        </div>
      </div>
      <div class="row">
        <p class="mx-auto">© Copyright 2021 - Tutti i diritti riservati.</p>
      </div>
    </div>
  </footer>
</html>
