<?php
include "utilities/functions.php";
include "utilities/db_connect.php";
sec_session_start();
$conn = connectToDatabase();
$login=login_check($conn);
$_SESSION["lastPage"] = 'menu.php';
$cliente = 2;
$_SESSION["num"] = $cliente;

if ($login) {
  $myArray = array();
  $myArray2 = array();


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

$conn = connectToDatabase();


$e_mail_f = $_POST['e_mail'];
$e_mail_c = $_SESSION["e_mail"];
//$e_mail_f = "lan.guo@gmail.com";



$query_sql="SELECT * FROM cliente WHERE cliente.e_mail_cliente = '" . $e_mail_c . "'";
$result = $conn->query($query_sql);
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $myCliente = new Cliente($row["name"],$row["surname"],$row["e_mail_cliente"],$row["password"],$row["citta"],$row["fotoProfilo"]);
 }
}

$query_sql="SELECT * FROM prodotto WHERE e_mail_fornitore = '" . $e_mail_f . "'";
$result = $conn->query($query_sql);
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $myProdotto = new Prodotto($row["e_mail_fornitore"],$row["nomeProdotto"],$row["prezzo"],$row["descrizione"],$row["img"]);
     $myArray[]=$myProdotto;
 }
}

$query_sql2="SELECT * FROM fornitore WHERE e_mail_fornitore = '" . $e_mail_f . "'";
$result2 = $conn->query($query_sql2);
if ($result2->num_rows > 0) {
  while ($row = $result2->fetch_assoc()) {
    $myFornitore = new Fornitore($row["name"],$row["categoria"],$row["e_mail_fornitore"],$row["password"],$row["citta"],$row["indirizzo"],$row["desc1"],$row["desc2"],$row["img1"],$row["img2"],$row["img3"]);
     $myArray2[]=$myFornitore;
 }
}

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
    <script src="./../js/messages_it.min.js"></script>
    <script src="./../js/jquery.toast.js"></script>
    <link rel="stylesheet" href="./../css/jquery.toast.css" type="text/css">
    <link href="./../css/bootoast.css" rel="stylesheet" type="text/css">
    <script src="./../js/bootoast.js"></script>
    <title><?php echo $myFornitore->name ?> menù</title>
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
          <a class="nav-link" href="Notifiche.php">Notifiche</a>
        </li>
      </ul>

    <!--  <a href="profile.php" class="btn btn-default navbar-btn btn-lg"><em class="fa fa-fw fa-user-circle-o"></em></a>
      <a href="cart.php" class="btn btn-default navbar-btn btn-lg"><span class=""><em class="fa fa-fw fa-shopping-cart"></em></span></a>
      <a href="notifications.php" class="btn btn-default navbar-btn btn-lg"><span class=""><em class="fa fa-fw fa-bell-o"></em></span></a>-->


    </div>


  </div>
</nav>
    <main>
      <div class="py-3 text-white bg-secondary">
        <div class="container">
          <div class="row">
            <div class="align-self-center col-md-6 ">
                <h1>Menu <?php echo $myFornitore->name ?> </h1>
                <br>
                <p><em> <?php echo $myFornitore->desc2 ?> </em></p>

            </div>
          <div class="col-md-6 p-0">
            <div id="carousel1" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner" role="listbox">
                  <div class="carousel-item active">
                    <img src=<?php echo getImgFolder().$myFornitore->img2?> alt="locale 1" class="d-block img-fluid w-100" style="max-width:100%;height:300px;">
                  </div>
                  <div class="carousel-item">
                    <img class="d-block img-fluid w-100" alt="locale 2" src=<?php echo getImgFolder().$myFornitore->img3?> data-holder-rendered="true" style="max-width:100%;height:300px;">
                  </div>

                </div>
                <a class="carousel-control-prev" href="#carousel1" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a>
                <a class="carousel-control-next" href="#carousel1" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a>
              </div>
            </div>

            <div class="row text-center">
              <div class="card mx-auto">
              </div>
            </div>
          </div>
        </div>
      </div>


      <div class="py-3 text-white bg-secondary">
        <div class="container">
          <div class="row">


            <?php foreach ($myArray as $key => $value) { ?>


                          <div class="col-md-6 mt-2">
                  <div class="card h-100">
                  <div class="card-header bg-primary">
                    <h5 class="mb-0 text-center"> <?php echo $value->nomeProdotto; ?> </h5>
                  </div>
                  <img class="img-fluid w-100" style="max-height:280px;" src=<?php echo getImgFolder().$value->img?> alt="foto">
                  <div class="card-body text-center vcenter" style="padding-bottom:0px;">
                    <p> <?php echo $value->descrizione; ?> </p>
                    <h3> <?php echo $value->prezzo; ?> €</h3>
                  </div>
                  <div class="card-footer force-to-bottom text-center">
                    <form id="<?php echo $value->nomeProdotto ?>">

                          <label>Quantità: <input type="number" id="quantita" name="quantita" value="1" min="1" max="20" required></label><br>
                          <input type="hidden" name="e_mail" id="e_mail" value="<?php echo $value->e_mail_fornitore ?>" />
                          <input type="hidden" name="nomeP" id="nomeP" value="<?php echo $value->nomeProdotto ?>" />
                          <input type="button" id="add" onclick="add2cart('<?php echo $value->nomeProdotto ?>')" class="btn btn-success fa fa-shopping-cart" value="Aggiungi al carrello" name="add">

                    </form>
                  </div>
                </div>
              </div>

                <?php } ?>



          </div>
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

<script type='text/javascript'>

function add2cart(id){

    var quantita = document.getElementById(id).quantita.value;

    if(quantita < 1 || quantita > 20){
      $.toast({
        text : "Quantita selezionata errata",
        showHideTransition : 'slide',  // It can be plain, fade or slide
        bgColor : 'grey',              // Background color for toast
        textColor : 'black',            // text color
        allowToastClose : true,       // Show the close button or not
        hideAfter : 5000,              // `false` to make it sticky or time in miliseconds to hide after
        stack : 5,                     // `fakse` to show one stack at a time count showing the number of toasts that can be shown at once
        textAlign : 'left',            // Alignment of text i.e. left, right, center
        position : 'bottom-left'       // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values to position the toast on page
      });
      return false;
    } else {


    // $('input[name^="add"]').click(function(e){
    //   e.preventDefault();
      // var quantita = $('input[name^="quantita"]').val();
      // var e_mail = $('input[name^="e_mail"]').val();
      // var nomeP = $('input[name^="nomeP"]').val();
      var quantita = document.getElementById(id).quantita.value;
      var e_mail = document.getElementById(id).e_mail.value;
      var nomeP = document.getElementById(id).nomeP.value;

      // $.ajax({
      //         type: 'post',
      //         url: 'menu.php',
      //         data: {
      //           quantita: quantita,
      //           e_mail: e_mail,
      //           nomeP: nomeP,
      //           "callFunc1": "1"
      //         }
      //         success : function(response) { console.log(1); }
      // })
      $.post(
        'add2card.php',
        {quantita: quantita, e_mail: e_mail, nomeP: nomeP},
        function(data){
          $('body').append(data);
        });


        $.toast({
          text : "Prodotto aggiunto al carrello",
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
      	//   message: 'Prodotto aggiunto al carrello',
      	//   type: 'success'
      	// });
      }
}
//});

</script>

  </body>
</html>
