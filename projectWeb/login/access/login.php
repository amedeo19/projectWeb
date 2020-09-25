<?php
    include './../../html/utilities/functions.php';
    include './../../html/utilities/db_connect.php';
    sec_session_start();
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
     <link rel="stylesheet" href="./../../css/theme.css" type="text/css">

     <!-- Optional JavaScript -->
     <!-- jQuery and validator first, then Popper.js, then Bootstrap JS -->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.0/dist/jquery.validate.min.js" integrity="sha384-jR1IKAba71QSQwPRf3TY+RAEovSBBqf4Hyp7Txom+SfpO0RCZPgXbINV+5ncw+Ph" crossorigin="anonymous"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

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
  					<p></p>  <!-- forse da levare -->
  				</div>

          <div class="FoodImage col-md-6 offset-md-3">
            <div class="thumbnail mx-auto">
              <figure class="FoodImage">
                <img src="./../../images/FoodImage.jpg" style="max-width:100%" alt="FoodImage" class="img-fluid">
              </figure>
            </div>
          </div>

          <main>

      <?php
        if(isset($_GET['error'])) {
         $format = "col-sm-10 col-10";
         $res = intval($_GET['error']);
         switch ($res) {
           case 0:
             echo errorOccured($format, 'Errore durante il log-in!');
             break;
           case -1:
             echo errorOccured($format, 'Hai effettuato il log-in troppe <br/> volte,
                                         il tuo account è bloccato temporaneamente.<br/>
                                         Riprova più tardi!');
             break;
           case 2:
             echo errorOccured($format, 'Inserire una mail');
             break;
           case 3:
             echo errorOccured($format, 'Inserire la password');
             break;
           case 4:
             echo errorOccured($format, 'Errore di connessione');
             break;
           case 70:
             echo errorOccured($format, 'Credenziali errate!');
             break;
           case 99:
             echo errorOccured($format, "Per effettuare questa funzionalità è richiesto l'accesso");
             break;
           default:
             echo errorOccured($format, 'Errore non riconosciuto: Error#'.$res);
             break;
         };
        }
      ?>
            <form id="inputForm" action="./check.php" method="post">
              <fieldset class= "border border-light mt-2" id="registrazione">
                <legend class="w-50 text-center">LOGIN</legend>
                <div class="card card-body bg-secondary">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" class="form-control" name="email" placeholder="Inserisci Email" required>
                  </div>
                  <div class="form-group">
                    <label for="pwd">Password</label>
                    <input type="password" id="pwd" class="form-control" name="pwd" placeholder="Inserisci Password" required>
                  </div>
                  <div class="registrazione col-md-4 offset-md-4">
                    <input type="button" value="indietro" onClick="location.href='./../../index.html'" name="Torna al Login" class="btn btn-primary">
                    <input type="submit" class="btn btn-primary avanti" value="Invia">
                    <input type="hidden" name="sent" value="true"/><!-- schermata di conferma-->
                  </div>
                </div>
              </fieldset>
            </form>
          </main>
        </div>
      </div>
      <div class="row" id="iscriviti">
        <div class="mx-auto text-center">
          <p> Non sei iscritto? Iscriviti subito! </p>
          <a class="btn btn-primary" href="./../registration/user/registrazione.php" role="button">Iscriviti come Cliente</a>
          <a class="btn btn-primary" href="./../registration/provider/registrazione.php" role="button">Iscriviti come Fornitore</a>
        </div>
      </div>
    </div>
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
  </body>
</html>
