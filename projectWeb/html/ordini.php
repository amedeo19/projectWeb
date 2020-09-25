<?php
include 'utilities/functions.php';
include 'utilities/db_connect.php';
sec_session_start();
$conn = connectToDatabase();
$login=login_check($conn);
$_SESSION["lastPage"] = 'ordini.php';
$fornitore = 2;
$_SESSION["num"] = $fornitore;

if ($login) {
    $myArray = array();

    class Cliente {
      public $name;
      public $surname;
      public $e_mail_cliente;
      public $password;
      public $citta;
      public $telefono;
      public $fotoProfilo;


      function __construct($name,$surname,$e_mail_cliente,$password,$citta, $telefono, $fotoProfilo) {
        $this->name = $name;
        $this->surname = $surname;
        $this->e_mail_cliente = $e_mail_cliente;
        $this->password = $password;
        $this->citta= $citta;
        $this->telefono= $telefono;
        $this->fotoProfilo= $fotoProfilo;
      }
    }

    class Ordine {
      public $e_mail_cliente;
      public $e_mail_fornitore;
      public $quantita;
      public $nomeProdotto;
      public $stato;
      public $data;
      public $ora;
      public $luogo;

      function __construct($e_mail_cliente,$e_mail_fornitore, $quantita, $nomeProdotto, $stato, $data, $ora, $luogo) {
        $this->e_mail_cliente = $e_mail_cliente;
        $this->e_mail_fornitore = $e_mail_fornitore;
        $this->quantita = $quantita;
        $this->nomeProdotto = $nomeProdotto;
        $this->stato = $stato;
        $this->data = $data;
        $this->ora = $ora;
        $this->luogo = $luogo;
      }
    }


    /*if (!login_check($mysqli)) {
      header('Location: login.php?error=99');
    } else if (isset($_SESSION["email"]) && !isAdmin($_SESSION["email"], $mysqli)) {
      header('Location: index.html');
    }*/

    //$e_mail_f = "lan.guo@gmail.com";
    //$e_mail = $_POST['e_mail'];
    $e_mail_f = $_SESSION["e_mail"];

    if(isset($_POST['delete'])) {
      $e_mail_f = $_SESSION["e_mail"];
      $e_mail_c = $_POST['e_mail_c'];
      $nomeProdotto = $_POST['nomeProdotto'];
      $messaggio = "Il tuo ordine è stato spedito, sta per arrivare";
      invia_notifica($e_mail_f, $e_mail_c, $messaggio, $conn);
      deleteOrdine($e_mail_f, $nomeProdotto, $e_mail_c);
    }

    $query_sql="SELECT * FROM ordine WHERE ordine.e_mail_fornitore = '" . $e_mail_f . "' AND ordine.stato = 1 ORDER BY ordine.data";
    $result = $conn->query($query_sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $myOrdine = new Ordine($row["e_mail_cliente"],$row["e_mail_fornitore"],$row["quantita"],$row["nomeProdotto"],$row["stato"],$row["data"],$row["ora"],$row["luogo"]);
        $myArray[]=$myOrdine;
      }
    }

    function trovaCliente($e_mail_c){
      $conn = connectToDatabase();
      $query_sql2="SELECT * FROM cliente WHERE e_mail_cliente = '" . $e_mail_c . "'";
      $result2 = $conn->query($query_sql2);
      if ($result2->num_rows > 0) {
        while ($row = $result2->fetch_assoc()) {
          $myCliente = new Cliente($row["name"],$row["surname"],$row["e_mail_cliente"],$row["password"],$row["citta"],$row["telefono"],$row["fotoProfilo"]);
       }
      }
      return $myCliente;
    }
    check_logout();
  }else{
    $login_failed=99;
    header('Location: ./../login/access/login.php?error='.$login_failed);
}

function deleteOrdine($e_mail_f, $nomeProdotto, $e_mail_c){
      $conn = connectToDatabase();
      $query_sql = "DELETE FROM ordine WHERE ordine.e_mail_fornitore='" . $e_mail_f . "' AND ordine.nomeProdotto='" . $nomeProdotto . "' AND ordine.e_mail_cliente='" . $e_mail_c . "'";
      $result = $conn->query($query_sql);
}

?>


<!DOCTYPE html>
<html lang="it-IT">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="./../css/theme.css" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.0/dist/jquery.validate.min.js" integrity="sha384-jR1IKAba71QSQwPRf3TY+RAEovSBBqf4Hyp7Txom+SfpO0RCZPgXbINV+5ncw+Ph" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="./../js/messages_it.min.js"></script>
    <script src="./../js/jquery.toast.js"></script>
    <link rel="stylesheet" href="./../css/jquery.toast.css" type="text/css">
    <link href="./../css/bootoast.css" rel="stylesheet" type="text/css">
    <script src="./../js/bootoast.js"></script>
    <title>Lista ordini</title>
  </head>
  <body class="bg-dark">
    <nav class="navbar-expand-md navbar-dark bg-dark navbar">
      <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
    <!--    <a class="navbar-brand" href="index.php"><img src="image/Food.jpg" alt="logo"></a>  -->
        <button type="button" style="margin-top:5px;" class="navbar-toggler navbar-toggler-right" data-toggle="collapse" data-target="#navbar-menu" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse text-center" style="margin-top:10px;" id="navbar-menu">
          <ul class="navbar-nav mx-auto">
            <li class="nav-item">
              <a class="nav-link" href="fornitore_menu.php">Home</a>
              <!--<a href="home.php" class="btn btn-default navbar-btn btn-lg"><em class="fas fa-home"></em></a>-->
            </li>

            <li class="nav-item">
              <a class="nav-link" href="./Profilo_fornitore.php">Profilo</a>
              <!--<a href="profile.php" class="btn btn-default navbar-btn btn-lg"><em class="fa fa-fw fa-user-circle-o"></em></a>-->
            </li>
            <li class="nav-item">
              <a class="nav-link" href="ordini.php">Ordini</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="notifiche_fornitore.php">Notifiche</a>
            </li>
          </ul>

        <!--  <a href="profile.php" class="btn btn-default navbar-btn btn-lg"><em class="fa fa-fw fa-user-circle-o"></em></a>
          <a href="cart.php" class="btn btn-default navbar-btn btn-lg"><span class=""><em class="fa fa-fw fa-shopping-cart"></em></span></a>
          <a href="notifications.php" class="btn btn-default navbar-btn btn-lg"><span class=""><em class="fa fa-fw fa-bell-o"></em></span></a>-->


        </div>


      </div>
</nav>
    <main class="py-3 text-white bg-secondary">
      <div class="container">
                <h1>Lista ordini</h1>
        <div class="container-fluid content-row">
          <div class="row text-center">
            <div class="card mx-auto">

            </div>
          </div>
          <div class="row">

            <?php foreach ($myArray as $key => $value) {
                $cliente = trovaCliente($value->e_mail_cliente);
            ?>


                      <div class="col-12 .col-sm-6 .col-lg-8">

              <div class="card h-100">
                <div class="card-header bg-primary">
                  <h5 class="mb-0 text-center">nome cliente: <?php echo $cliente->name;?> </br> telefono: <?php echo $cliente->telefono;?></h5>
                </div>
                <div class="card-body text-left" style="padding-bottom:10px;">
                    <p> <?php echo $value->nomeProdotto;?> </p>
                    <p>quantità: <?php echo $value->quantita;?> </p>
                    <p>data: <?php echo $value->data;?> </p>
                    <p>ora: <?php echo $value->ora;?> </p>
                    <p>luogo: <?php echo $value->luogo;?> </p>


                </div>
                <div class="card-footer force-to-bottom text-right">
                  <form action="" method="post">
                      <input type="hidden" name="nomeProdotto" value="<?php echo $value->nomeProdotto ?>" />
                      <input type="hidden" name="e_mail_c" value="<?php echo $value->e_mail_cliente ?>" />
                    <input type="submit" class="btn btn-primary" name="delete" value="spedisci ordine" >
                  </form>
                </div>
              </div>
            </div>

            <div class="card-body" style="padding-bottom:0px;">
            </div>

            <?php } ?>



        </div>
      </div>
    </main>
    <footer class="footer">
  <div class="container bg-dark text-white">
    <div class="row">

      <div class="p-4 col-md-6">
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

  <script>
  var myVar = setInterval(myTime, 2000);

  function myTime(){
    $.post("check_notify.php",
            {} ,
            function(result){
              console.log(result);
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
      text : "I clienti hanno ordinato un prodotto!",
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
    //   message: 'I clienti hanno ordinato un prodotto!',
    //   type: 'success'
    // });
  }


  </script>
</html>
