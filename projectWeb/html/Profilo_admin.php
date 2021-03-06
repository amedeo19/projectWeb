<?php
    include './../html/utilities/db_connect.php';
    include './../html/utilities/functions.php';
    sec_session_start();
    $conn=connectToDatabase();
    $login=login_check($conn);
    $_SESSION["lastPage"] = 'Profilo_admin.php';
    $admin = 3;
    $_SESSION["num"] = $admin;

    if ($login) {


        class Admin {
          public $username;
          public $e_mail_admin;
          public $password;
          public $codice;

          function __construct($username,$e_mail_admin,$password,$codice) {
            $this->username = $username;
            $this->e_mail_admin = $e_mail_admin;
            $this->password = $password;
            $this->codice = $codice;
          }
        }

        $e_mail_admin = $_SESSION['e_mail'];


        $query_sql="SELECT * FROM admin WHERE admin.e_mail_admin = '" . $e_mail_admin . "'";
        $result = $conn->query($query_sql);
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $myAdmin = new Admin($row["username"],$row["e_mail_admin"],$row["password"],$row["codice"]);
         }
       }

    if (isset($_GET['error'])) {
      $format = "col-sm-10 col-10";
      $res = intval($_GET['error']);?>
      <div>
      <?php
      switch ($res) {
        case -1: echo errorOccured($format, "La email seguente non è già collegata ad un account!");
                 break;
        case -2: echo errorOccured($format, "Riempire tutti i campi!");
                 break;
        case -3: echo errorOccured($format, "Connessione errata!");
                 break;
        default: echo errorOccured($format, 'Errore non riconosciuto: Error#'.$res);
                 break;
      };
      ?></div><?php
   }
 }else{
   $login_failed=99;
   header('Location: ./../login/access/login.php?error='.$login_failed); }
 ?>
<!DOCTYPE html>
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
    <link rel="stylesheet" href="./../css/theme.css" type="text/css">

    <!-- Optional JavaScript -->
    <!-- jQuery and validator first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.0/dist/jquery.validate.min.js" integrity="sha384-jR1IKAba71QSQwPRf3TY+RAEovSBBqf4Hyp7Txom+SfpO0RCZPgXbINV+5ncw+Ph" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="./../js/jquery.toast.js"></script>
    <link rel="stylesheet" href="./../css/jquery.toast.css" type="text/css">
    <link href="./../css/bootoast.css" rel="stylesheet" type="text/css">
    <script src="./../js/bootoast.js"></script>
    <!-- Check Name-->
    <script src="./../js/name.js"></script>

    <!-- Control Password-->
    <script src="./../js/control_password.js"></script>

    <!-- Check Form-->
    <script src="./../js/form.js"></script>

    <!-- Enrcypted password-->
    <script src="./../js/sha512.js"></script>

    <!-- Check email
    <script src="./../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>-->

    <!-- Javascript messagges when error -->
    <script src="./../js/messages_it.min.js"></script>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>



    <title>Registrazione</title>

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
                <img src="./../images/FoodImage.jpg" style="max-width:100%" alt="FoodImage" class="img-fluid"></img>
              </figure>
            </div>
          </div>
          <main>
            <section id="schermata_di_registrazione">
      				<form id="inputform" method="post" action="./check_Profilo_admin.php" onsubmit=" return validateForm()" enctype="multipart/form-data">
                <fieldset class= "border border-light mt-2" id="registrazione">
                  <legend class="w-50 text-center">MODIFICA PROFILO</legend>
                  <div class="card card-body bg-secondary">
                    <div class="form-group">
                      <label for="inputEmail">EMAIL: <?php echo $myAdmin->e_mail_admin ?> </label>
                    </div>
          				  <div class="form-group">
            					<label for="inputNome">USERNAME</label>
            					<input type="text" name="nome" class="form-control" id="inputNome" onfocusout="checkName();return false" placeholder="<?php echo $myAdmin->username ?>" required></input>
                      <span id="confirmName" class="confirmMessage"></span>
          				  </div>
                    <div class="form-group">
                      <label for="inputPassword">PASSWORD</label>
                      <input type="password" name="password" class="form-control" id="idPassword" minlength="5" placeholder="Inserisci nuova Password" onfocusout="controlPassword(); return false;" required></input>
                      <span id="confirmMessage" class="confirmMessage"></span>
                    </div>
                    <div class="form-group">
                      <label for="ripetiPassword">RIPETI PASSWORD</label>
                      <input type="password" name="ripetiPassword" class="form-control" id="idRipetiPassword" minlength="5" placeholder="Ripeti Password" onkeyup="controlPassword(); return false;" required></input>
                    </div>
                  </div>
                </fieldset>
                <div class="registrazione col-md-6 offset-md-3">
                  <input type="button" value="Indietro" onClick="location.href='Admin_lista_fornitori.php'" name="Torna al Login"class="btn btn-primary"></input>
                  <input type="submit" class="btn btn-primary avanti" value="Avanti"></input>
                  <input type="hidden" name="sent" value="true"/></input><!-- schermata di conferma-->
                </div>
              </form>
            </section>
          </main>
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

  <script>
  var myVar = setInterval(myTime, 2000);

  function myTime(){
    $.post("check_notify.php",
            {} ,
            function(result){
              switch(result) {
                case "1" : notify();
                  break;
                default :
                break;
              }
            });
  }

  function notify(){
    $.toast({
      text : "E' stato registrato un nuovo utente!",
      showHideTransition : 'slide',  // It can be plain, fade or slide
      bgColor : 'grey',              // Background color for toast
      textColor : 'black',            // text color
      allowToastClose : true,       // Show the close button or not
      hideAfter : 5000,              // `false` to make it sticky or time in miliseconds to hide after
      stack : 5,                     // `fakse` to show one stack at a time count showing the number of toasts that can be shown at once
      textAlign : 'left',            // Alignment of text i.e. left, right, center
      position : 'bottom-left'       // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values to position the toast on page
    });

    // bootoast.toast({
    //   message: "E' stato registrato un nuovo utente!",
    //   type: 'success'
    // });
  }


  </script>

    <script>

    function validateForm() {
      var a = checkName();
      if (a == false) {
        alert("Il nome è errato!");
        return false;
      }
      var f = controlPassword();
      if (f == false) {
        alert("Una delle due password è errata!");
        return false;
      }
    //   formhash();
    }
    </script>

  </body>
</html>
