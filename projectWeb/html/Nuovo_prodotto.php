<?php
include 'utilities/functions.php';
include 'utilities/db_connect.php';
sec_session_start();
$_SESSION["lastPage"] = 'Nuovo_prodotto.php';
$conn = connectToDatabase();
$login=login_check($conn);
$fornitore = 2;
$_SESSION["num"] = $fornitore;

if ($login) {
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

  $conn = connectToDatabase();

  $e_mail_f = $_POST['e_mail'];

  $query_sql2="SELECT * FROM fornitore WHERE e_mail_fornitore = '" . $e_mail_f . "'";
  $result2 = $conn->query($query_sql2);
  if ($result2->num_rows > 0) {
    while ($row = $result2->fetch_assoc()) {
      $myFornitore = new Fornitore($row["name"],$row["categoria"],$row["e_mail_fornitore"],$row["password"],$row["citta"],$row["indirizzo"],$row["desc1"],$row["desc2"],$row["img1"],$row["img2"],$row["img3"]);
   }
  }

  function addProdotto($e_mail_f, $data, $img){
        $conn = connectToDatabase();
        $e_mail_fornitore = $e_mail_f;
        $nomeP = $data["nome"];
        $prezzo = $data["prezzo"];
        $desc = $data["desc"];
        $img = $img;

        $query_sql = "INSERT INTO prodotto (e_mail_fornitore, nomeProdotto, prezzo, descrizione, img)
                      VALUES ('$e_mail_fornitore', '$nomeP', '$prezzo', '$desc', '$img')";
        $result = $conn->query($query_sql);

        header('HTTP/1.1 301 Moved Permanently');
        header('Location: fornitore_menu.php');
  }

  if(isset($_POST['avanti']) && (isset($_FILES['immagine']) || is_uploaded_file($_FILES['immagine']['tmp_name']))){

    //if(isset($_FILES['immagine']) || is_uploaded_file($_FILES['immagine']['tmp_name'])){

      $imgDir="./../images";
      $defaultFormat="jpg";
      $myPhoto= $_FILES['immagine'];
      $nomeP = $_POST['nome'];
        //verifica che sia un immagine
      //foreach ($myPhoto as $value) {
        $is_img = getimagesize($_FILES['immagine']['tmp_name']);
        if (!$is_img) {
            header('Location:fornitore_menu.php');
            exit;
        } else {

            $userfile_tmp = $_FILES['immagine']['tmp_name'];

            $userfile_name = $_FILES['immagine']['name'];

            $target_file = $imgDir . $userfile_tmp;

            if (!file_exists($target_file)) {
                //copio il file dalla sua posizione temporanea alla mia cartella upload
                if (move_uploaded_file($userfile_tmp, "$imgDir/$e_mail_f.$nomeP.$defaultFormat")) { // criptare anche le immagini delle mail
                    //Se l'operazione è andata a buon fine...

                    $img="$e_mail_f.$nomeP.$defaultFormat";

                    $_POST['immagine'] = $userfile_name;
                }
            }
        }
      //   $num++;
      // }

    //}
    addProdotto($myFornitore->e_mail_fornitore, $_POST, $img);
  }
  check_logout();
}else{
  $login_failed=99;
  header('Location: ./../login/access/login.php?error='.$login_failed);
}


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

     <!-- Check Name-->
     <script src="./../js/surname.js"></script>

     <!-- Control Password-->
     <script src="./../js/control_password.js"></script>

     <!-- Control Email-->
     <script src="./../js/check_email.js"></script>

     <!-- Check email
     <script src="./../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>-->

     <!-- Javascript messagges when error -->
     <script src="./../js/messages_it.min.js"></script>

     <title>Nuovo prodotto</title>

   </head>

<body class="bg-dark" >
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
         <a class="nav-link" href="Profilo_fornitore.php">Profilo</a>
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

 <!--  <nav class="navbar-expand-md navbar-dark bg-dark navbar">
 <div class="container">
   <button type="button" style="margin-top:5px;" class="navbar-toggler navbar-toggler-right" data-toggle="collapse" data-target="#navbar-menu" aria-expanded="false">
   <span class="sr-only">Toggle navigation</span>
   <span class="navbar-toggler-icon"></span>
 </button>-->

 </div>
</nav>



     <div class="container-fluid py-3 text-white bg-secondary">
   		<div class="row">
   			<div class="col-12 col-md-6 offset-md-3">

   				<div class="alert alert-danger alert-js" role="alert" style="display: None">
   					Dati inseriti non corretti
   					<p></p>  <!-- forse da levare -->
   				</div>
           <div class="col-md-6 offset-md-3">

           </div>
           <main>
             <section id="schermata_di_registrazione" style="margin-bottom:25px;">
       				<form method="post" action="Nuovo_prodotto.php" id="inputform" onsubmit="return validateForm()"  enctype="multipart/form-data">
                 <fieldset class= "border border-light mt-2" id="registrazione">
                   <legend class="w-50 text-center">Nuovo prodotto</legend>
                   <div class="card card-body bg-secondary">
           				  <div class="form-group">
             					<label for="inputNome">NOME</label>
               					<input type="text" name="nome" class="form-control" placeholder="Inserisci nome prodotto" required></input>
                       <span id="confirmName" class="confirmMessage"></span>
           				  </div>
           				  <div class="form-group">
             					<label for="inputPrezzo">PREZZO</label>
             					  <input type="text" name="prezzo" class="form-control"  placeholder="Inserisci prezzo" required></input>
                       <span id="confirmSurname" class="confirmMessage"></span>
           				  </div>
                     <div class="form-group">
                       <label for="inputEmail">DESCRIZIONE</label>
                         <input type="text" name="desc" class="form-control" placeholder="Inserisci descrizione" required></input>
                     </div>
                     <div class="form-group">
                       <label for="inputImage">IMMAGINE PRODOTTO</label>
                       <input type="file" name="immagine" accept="image/*" id="inputImage" capture></input>
                       <canvas style="max-width: 310px" id="canvas"></canvas>
                     </div>

                   </div>
                 </fieldset>
                 <div class="registrazione col-md-6 offset-md-3">

                     <input type="button" value="indietro" onclick="location.href='fornitore_menu.php'" class="btn btn-primary"></input>


                   <input type="hidden" name="e_mail" value="<?php echo $myFornitore->e_mail_fornitore ?>" />
                   <input type="submit" name="avanti" class="btn btn-primary" value="avanti">
                 </div>
               </form>
             </section>
           </main>
   			</div>
   		</div>
 	  </div>

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
        var input = document.querySelector('#inputImage');

        input.onchange = function () {
          var file = input.files[0];

          upload(file);
          drawOnCanvas(file,"canvas");
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
   </body>
 </html>
