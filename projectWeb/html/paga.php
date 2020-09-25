<?php
include "utilities/functions.php";
include "utilities/db_connect.php";
sec_session_start();
$conn = connectToDatabase();
$login=login_check($conn);
$_SESSION["lastPage"] = 'paga.php';
$cliente = 1;
$_SESSION["num"] = $cliente;

if ($login){

  $myArray = array();
  $myLuogo = array();

  $dataOggi = date("Y/m/d");
  class Puntoconsegna {
    public $luogo;

    function __construct($luogo) {
      $this->luogo = $luogo;
    }
  }

  $conn = connectToDatabase();


  $e_mail_f = $_POST['e_mail_f'];
  $e_mail_c = $_SESSION["e_mail"];
  $nomeP = $_POST['nomeP'];
  //$_SESSION["notifica"] = 0;

  $query_sql2="SELECT * FROM puntoconsegna";
  $result2 = $conn->query($query_sql2);
  if ($result2->num_rows > 0) {
    while ($row = $result2->fetch_assoc()) {
      $myPuntoconsegna = new Puntoconsegna($row["luogo"]);
      $myLuogo[]=$myPuntoconsegna;
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
    <title>Conferma ordine</title>
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


        </div>

      </div>
</nav>
    <main class="py-3 text-white bg-secondary">
      <div class="container">
                <h1 style="padding-bottom:40px;">Conferma ordine</h1>
        <div class="container-fluid content-row" style="padding-bottom:30px;">

          <div class="" style="text-align:center;">

              <div class=".col-sm-4">
                <form id="<?php echo $e_mail_c; ?>">
                      <label class="mb-0 text-center">Scegli il luogo di consegna:
                          <select name="luogo" style="border-radius:15px;background-color:#4D4D4D;" styledSelect="background-color:#4D4D4D;" required>

                            <?php foreach ($myLuogo as $key => $value) { ?>
                              <option name="luogo" id="luogo" value="<?php echo $value->luogo; ?>"><?php echo $value->luogo; ?></option>
                            <?php } ?>

                          </select>
                      </label><br/><br/>

                      <label class="mb-0 text-center" style="padding-bottom:20px;">  Inserisci la data di consegna: <input style="border-radius:15px;background-color:#4D4D4D;" min="<?php $dataOggi ?>" type="date" id="data" name="data" required/>
                      </label><br/><br/>

                      <label class="mb-0 text-center" style="padding-bottom:20px;">  Inserisci l'ora di consegna: <input style="border-radius:15px;background-color:#4D4D4D;" type="time" name="ora" id="ora" required/>
                      </label><br/><br/>


                      <div class="btn-group btn-group-toggle" style="padding-bottom:40px;" data-toggle="buttons">
                        <label class="btn btn-secondary active">
                          <input type="radio" id="option1" value="consegna" autocomplete="off" checked> Pagamento alla consegna
                        </label>
                        <label class="btn btn-secondary">
                          <input type="radio" id="option2" value="carta" autocomplete="off"> Carta di credito
                        </label>
                      </div>

                    </div>


                    <div style="padding-bottom:10px;text-align:right;padding-right:30px;">
                      <input type="button" class="btn btn-primary" value="indietro" onclick="location.href='carrello.php'">
                        <input type="hidden" id="e_mail_c" name="e_mail_c" value="<?php echo $e_mail_c; ?>"  />
                        <input type="hidden" id="e_mail_f" name="e_mail_f" value="<?php echo $e_mail_f; ?>"  />
                        <input type="hidden" id="nomeP" name="nomeP" value="<?php echo $nomeP; ?>"  />
                      <input type="button" id="ordina" name="ordina" onclick="invia('<?php echo $e_mail_c; ?>')" class="btn btn-primary" value="ordina">

                    </div>
                </form>


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

function invia(id){

      var luogo = document.getElementById(id).luogo.value;
      var e_mail_c = document.getElementById(id).e_mail_c.value;
      var e_mail_f = document.getElementById(id).e_mail_f.value;
      var nomeP = document.getElementById(id).nomeP.value;
      var data = document.getElementById(id).data.value;
      var ora = document.getElementById(id).ora.value;

      var data2 = new Date();
      var giorno= data2.getDate();
      var mese= data2.getMonth()+1;
      var anno= data2.getFullYear();
      var ore= data2.getHours();
      var minuti= data2.getMinutes();

      if(ora.substring(0,2) < 8 || ora.substring(0,2) > 21){
        $.toast({
          text : "A quell'ora il negozio non spedisce nulla",
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
      } else if(data.substring(0,4) == anno && data.substring(5,7) == mese && data.substring(8,10) == giorno){
        if(ora.substring(0,2) >= ore){
          if(ora.substring(3,5) >= minuti){
            $.post(
              'Invia_ordine.php',
              {luogo: luogo, e_mail_c: e_mail_c,  e_mail_f: e_mail_f, nomeP: nomeP, data: data, ora: ora},
              function(data){
                $('body').append(data);
              });


              $.toast({
                text : "Prodotto ordinato",
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
              //   message: 'Prodotto ordinato',
              //   type: 'success'
              // });

              $("#ordina").hide();

          } else {
            $.toast({
              text : "Non torniamo indietro nel tempo, minuti errati",
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
          }
        } else {
          $.toast({
            text : "Non torniamo indietro nel tempo, ora errata",
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
        }
      }else if(data.substring(0,4) >= anno){
          if(data.substring(5,7) == mese){
                if(data.substring(8,10) < giorno){
                  $.toast({
                    text : "Non torniamo indietro nel tempo, giorno errato",
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
                    $.post(
                      'Invia_ordine.php',
                      {luogo: luogo, e_mail_c: e_mail_c,  e_mail_f: e_mail_f, nomeP: nomeP, data: data, ora: ora},
                      function(data){
                        $('body').append(data);
                      });


                      $.toast({
                        text : "Prodotto ordinato",
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
                    	//   message: 'Prodotto ordinato',
                    	//   type: 'success'
                    	// });

                      $("#ordina").hide();
                  }
    } else if(data.substring(5,7) > mese){
      $.post(
        'Invia_ordine.php',
        {luogo: luogo, e_mail_c: e_mail_c,  e_mail_f: e_mail_f, nomeP: nomeP, data: data, ora: ora},
        function(data){
          $('body').append(data);
        });


        $.toast({
          text : "Prodotto ordinato",
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
        //   message: 'Prodotto ordinato',
        //   type: 'success'
        // });

        $("#ordina").hide();
    } else {
      $.toast({
        text : "Non torniamo indietro nel tempo, mese errato",
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
    }
  } else {
    $.toast({
      text : "Non torniamo indietro nel tempo, anno errato",
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
  }
}


</script>

  </body>
</html>
