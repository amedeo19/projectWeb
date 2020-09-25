<?php
include "utilities/functions.php";
include "utilities/db_connect.php";
sec_session_start();
$conn=connectToDatabase();
$login=login_check($conn);
$_SESSION["lastPage"] = 'ricerca.php';
$cliente = 1;
$_SESSION["num"] = $cliente;

    if ($login){
      $myArray = array();

    class Fornitore {
      public $name;
      public $categoria;
      public $e_mail_fornitore;
      public $password;
      public $citta;
      public $indirizzo;
      public $desc1;
      public $desc2;
      public $img1;
      public $img2;
      public $img3;

      function __construct($name,$categoria,$e_mail_fornitore,$password,$citta, $indirizzo, $desc1, $desc2, $img1, $img2, $img3) {
        $this->name = $name;
        $this->categoria = $categoria;
        $this->e_mail_fornitore = $e_mail_fornitore;
        $this->password = $password;
        $this->citta= $citta;
        $this->indirizzo = $indirizzo;
        $this->desc1 = $desc1;
        $this->desc2 = $desc2;
        $this->img1 = $img1;
        $this->img2 = $img2;
        $this->img3 = $img3;
      }
    }

    $conn = connectToDatabase();

    $e_mail_c = $_SESSION["e_mail"];
    //$e_mail_c = "gigi.ino@gmail.com";

    $query_sql="SELECT * FROM fornitore";
    $result = $conn->query($query_sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $myFornitore = new Fornitore($row["name"],$row["categoria"],$row["e_mail_fornitore"],$row["password"],$row["citta"],$row["indirizzo"],$row["desc1"],$row["desc2"],$row["img1"],$row["img2"],$row["img3"]);
         $myArray[]=$myFornitore;
     }
    }
    check_logout();
  }else{
    $login_failed=99;
    header('Location: ./../login/access/login.php?error='.$login_failed);
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
    <script src="./../js/jquery.toast.js"></script>
    <link rel="stylesheet" href="./../css/jquery.toast.css" type="text/css">
    <link href="./../css/bootoast.css" rel="stylesheet" type="text/css">
    <script src="./../js/bootoast.js"></script>
    <script src="./../js/messages_it.min.js"></script>
    <title>Ricerca</title>
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

        <!--  <a href="profile.php" class="btn btn-default navbar-btn btn-lg"><em class="fa fa-fw fa-user-circle-o"></em></a>
          <a href="cart.php" class="btn btn-default navbar-btn btn-lg"><span class=""><em class="fa fa-fw fa-shopping-cart"></em></span></a>
          <a href="notifications.php" class="btn btn-default navbar-btn btn-lg"><span class=""><em class="fa fa-fw fa-bell-o"></em></span></a>-->


        </div>

      <!--  <nav class="navbar-expand-md navbar-dark bg-dark navbar">
      <div class="container">
        <button type="button" style="margin-top:5px;" class="navbar-toggler navbar-toggler-right" data-toggle="collapse" data-target="#navbar-menu" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="navbar-toggler-icon"></span>
      </button>-->

      </div>
</nav>
    <main class="py-3 text-white bg-secondary">
      <div class="container">
                <h1>Ricerca ristoranti</h1>
        <div class="container-fluid content-row">
          <div class="row text-center">
            <div class="card mx-auto">
              <!--<div class="card-header bg-primary">
                <h3 class="mb-0 text-center">Filtri</h3>
              </div>
<!--              <div class="card-body justify-content-between">
                <form action="menu.php" method="get">
                  <label class="ml-1"><input type="checkbox"  name="piccante" value="P"/> Piccante</label>
                  <label class="ml-1"><input type="checkbox"  name="glutine" value="G"/> Senza glutine</label>
                  <label class="ml-1"><input type="checkbox"  name="vegetariano" value="V"/> Vegetariano</label><br>
                  <button type="submit" class="btn align-bottom btn-primary">
                  <em class="fa fa-filter" aria-hidden="true"> Filtra</em>
                  </button>
                </form>
              </div>-->
            </div>
          </div>
          <div class="row">

            <?php foreach ($myArray as $key => $value) { ?>


                      <div class="col-md-6 mt-2">

              <div class="card h-100">
                <div class="card-header bg-primary">
                  <h5 class="mb-0 text-center"> <?php echo $value->name; ?> </h5>
                </div>
                <img class="img-fluid w-100" style="max-height:280px;" src=<?php echo getImgFolder().$value->img1?> alt="foto">
                <div class="card-body text-center vcenter" style="padding-bottom:0px;">
                    <p> <?php echo $value->desc1; ?> </p>
                </div>
                <div class="card-footer force-to-bottom text-center">
                    <form action="menu.php" method="post" >
                        <input type="hidden" name="e_mail" value="<?php echo $value->e_mail_fornitore ?>" />
                          <input type="submit" class="btn btn-primary" value="View menu" />
                    </form>
                </div>
              </div>
            </div>

            <?php } ?>





        </div>
      </div>
      <div style="padding-top:20px;">
        <form action="ricerca.php" method="post" style="padding-bottom:10px;text-align:right;">
              <input type="submit" class="btn btn-primary" name="logout" value="logout">
        </form>
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
