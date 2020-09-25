<?php
include "utilities/functions.php";
include "utilities/db_connect.php";
sec_session_start();
$conn = connectToDatabase();
$login=login_check($conn);
$cliente = 1;
$_SESSION["num"] = $cliente;
$_SESSION["lastPage"] = 'carrello.php';
  if ($login){
    $myArray = array();


    class Prodotto {
      public $e_mail_fornitore;
      public $nomeProdotto;
      public $prezzo;
      public $descrizione;
      public $img;

      function __construct($e_mail_fornitore,$nomeProdotto,$prezzo,$descrizione, $img) {
        $this->e_mail_fornitore = $e_mail_fornitore;
        $this->nomeProdotto = $nomeProdotto;
        $this->prezzo = $prezzo;
        $this->descrizione = $descrizione;
        $this->img = $img;
      }
    }

    class Cliente {
      public $name;
      public $surname;
      public $e_mail_cliente;
      public $password;
      public $citta;
      public $fotoProfilo;


      function __construct($name,$surname,$e_mail_cliente,$password,$citta, $fotoProfilo) {
        $this->name = $name;
        $this->surname = $surname;
        $this->e_mail_cliente = $e_mail_cliente;
        $this->password = $password;
        $this->citta= $citta;
        $this->fotoProfilo= $fotoProfilo;
      }
    }

    class OrdineProdotto {
      public $e_mail_cliente;
      public $e_mail_fornitore;
      public $nomeProdotto;
      public $quantita;
      public $prezzo;
      public $descrizione;
      public $img;
      public $stato;
      public $data;
      public $ora;

      function __construct($e_mail_cliente,$e_mail_fornitore,$nomeProdotto,$quantita,$prezzo,$descrizione, $img, $stato, $data, $ora) {
        $this->e_mail_cliente = $e_mail_cliente;
        $this->e_mail_fornitore = $e_mail_fornitore;
        $this->nomeProdotto = $nomeProdotto;
        $this->quantita = $quantita;
        $this->prezzo = $prezzo;
        $this->descrizione = $descrizione;
        $this->img = $img;
        $this->stato = $stato;
        $this->data = $data;
        $this->ora = $ora;
      }
    }

    $conn = connectToDatabase();

    //$e_mail_c = "gigi.ino@gmail.com";
    //$e_mail = $_POST['e_mail'];
    $e_mail_c = $_SESSION["e_mail"];


    if(isset($_POST['delete'])) {
      $e_mail_f = $_POST['e_mail_f'];
      $nomeProdotto = $_POST['nomeProdotto'];
      deleteOrdine($e_mail_f, $nomeProdotto);
    }


    $query_sql="SELECT * FROM ordine, prodotto WHERE ordine.e_mail_cliente = '" . $e_mail_c . "' AND prodotto.e_mail_fornitore = ordine.e_mail_fornitore AND prodotto.nomeProdotto = ordine.nomeProdotto AND ordine.stato = 0";
    $result = $conn->query($query_sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $myOrdine = new OrdineProdotto($row["e_mail_cliente"],$row["e_mail_fornitore"],$row["nomeProdotto"],$row["quantita"],$row["prezzo"],$row["descrizione"],$row["img"],$row["stato"],$row["data"],$row["ora"]);
        $myArray[]=$myOrdine;
      }
      $banane = 0;
    } else {
      $banane = 4;
    }
  }else{
  $login_failed=99;
  header('Location: ./../login/access/login.php?error='.$login_failed);
  }

  function deleteOrdine($e_mail_f, $nomeProdotto){
        $conn = connectToDatabase();
        $query_sql = "DELETE FROM ordine WHERE ordine.e_mail_fornitore='" . $e_mail_f . "' AND ordine.nomeProdotto='" . $nomeProdotto . "'";
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
    <title>Carrello</title>
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
              <a class="nav-link" href="ricerca.php">Home</a>
              <!--<a href="home.php" class="btn btn-default navbar-btn btn-lg"><em class="fas fa-home"></em></a>-->
            </li>

            <li class="nav-item">
              <a class="nav-link" href="Profilo_cliente.php">Profilo</a>
              <!--<a href="profile.php" class="btn btn-default navbar-btn btn-lg"><em class="fa fa-fw fa-user-circle-o"></em></a>-->
            </li>
            <li class="nav-item">
              <a class="nav-link" href="carrello.php">Carrello</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="notifiche_cliente.php">Notifiche</a>
            </li>
          </ul>


        </div>


      </div>
</nav>


    <main class="py-3 text-white bg-secondary">
      <div class="container">
                <h1>Carrello</h1>
        <div class="container-fluid content-row">

          <div class="row" >


            <?php foreach ($myArray as $key => $value) { ?>

                  <div class="col-12 .col-sm-6 .col-lg-8" style="padding-bottom:20px;">

              <div class="card h-100">
                <div class="card-header bg-primary">
                  <h5 class="mb-0 text-center"> <?php echo $value->e_mail_fornitore;?></h5>
                </div>
                <div class=".col-sm-4">
                  <img style="float:left;margin:30px;max-height:100px"  src=<?php echo getImgFolder().$value->img?> alt="foto">
                  <p style="padding-top:30px;text-align:left"> <?php echo $value->nomeProdotto; ?> </p>
                  <p style="text-align:left"> quantità: <?php echo $value->quantita; ?> </p>
                  <p style="text-align:left"> prezzo: <?php echo $value->prezzo; ?>€ </p>


                </div>

                  <div class=".col-sm-4">
                  <form style="float:right;margin:20px;padding-top:20px;" action="carrello.php" method="post" >
                    <input type="hidden" name="e_mail_f" value="<?php echo $value->e_mail_fornitore ?>" />
                    <input type="hidden" name="nomeProdotto" value="<?php echo $value->nomeProdotto ?>" />
                        <input type="submit" class="btn btn-primary" value="delete" name="delete">
                  </form>


                    <p style="float:left;margin:20px;padding-top:20px;padding-left:20px;"> prezzo totale: <?php echo $value->prezzo*$value->quantita; ?>€ </p>
                    </div>




              </div>
            </div>


            <?php } ?>



        </div>
        <form action="paga.php" method="post" style="padding-bottom:10px;text-align:right;">
          <input type="hidden" name="e_mail_f" value="<?php echo $myOrdine->e_mail_fornitore; ?>"  />
          <input type="hidden" name="nomeP" value="<?php echo $myOrdine->nomeProdotto; ?>"  />
              <input id="bottoneSpeciale" type="submit" class="btn btn-primary" name="paga" value="ordina">
        </form>
      </div>
    </div>
    </main>
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

    <script type="text/javascript">

    var myOrdine = <?php echo $banane; ?>;
      if(myOrdine == 4){
        $("#bottoneSpeciale").hide();
      }


    </script>
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
        text : 'Il prodotto che hai ordinato è arrivato!',
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
      //   message: 'Il prodotto che hai ordinato è arrivato!',
      //   type: 'success'
      // });
    }


    </script>
  </body>
</html>
