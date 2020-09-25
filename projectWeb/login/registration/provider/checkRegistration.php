<?php
  include './../../../html/utilities/db_connect.php';
  include './../../../html/utilities/functions.php';

    sec_session_start();
    if (isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['categoria'])
      && isset($_POST['password']) && isset($_POST['ripetiPassword']) && isset($_POST['città']) && isset($_POST['indirizzo'])
      && isset($_POST['telefono']) && isset($_POST['descrizione1']) && isset($_POST['descrizione2'])
      && (isset($_FILES['immagine1']) || is_uploaded_file($_FILES['immagine1']['tmp_name']))    // img1
      && (isset($_FILES['immagine2']) || is_uploaded_file($_FILES['immagine2']['tmp_name']))    // img2
      && (isset($_FILES['immagine3']) || is_uploaded_file($_FILES['immagine1']['tmp_name']))) { // img3

      $email = $_POST['email'];
      $pwd = $_POST['password'];
      $mysqli = connectToDatabase();

      if ($mysqli->connect_error) {
        header('Location:registrazione.php?error=-3');
        exit;
      }

      /* controllo che l'email non sia già presente*/
      $res = checkEmail($email,$mysqli);
      if ($res) {
        header('Location:registrazione.php?error=-1');
        exit;
      }

      $imgDir="./../../../images";
      $num=1;
      $defaultFormat="jpg";
      $myPhoto= array("immagine1","immagine2","immagine3");
        //verifica che sia un immagine
      foreach ($myPhoto as $value) {
        $is_img = getimagesize($_FILES[$value]['tmp_name']);
        if (!$is_img) {
            header('Location:registrazione.php?error=-4');
            exit;
        } else {

            $userfile_tmp = $_FILES[$value]['tmp_name'];

            $userfile_name = $_FILES[$value]['name'];

            $target_file = $imgDir . $userfile_tmp;

            if (!file_exists($target_file)) {
                //copio il file dalla sua posizione temporanea alla mia cartella upload
                if (move_uploaded_file($userfile_tmp, "$imgDir/$email.$num.$defaultFormat")) { // criptare anche le immagini delle mail
                    //Se l'operazione è andata a buon fine...
                    switch ($num) {
                      case 1:
                        $img1="$email.$num.$defaultFormat";
                        break;
                      case 2:
                        $img2="$email.$num.$defaultFormat";
                        break;
                      default:
                        $img3="$email.$num.$defaultFormat";
                        break;
                    }
                    $_POST[$value] = $userfile_name;
                }
            }
        }
        $num++;
      }


      $res = providerSignIn($_POST['nome'], $email, $_POST['categoria'], $pwd, $_POST['città'], $_POST['indirizzo'], $_POST['telefono'], $_POST['descrizione1'], $_POST['descrizione2'], $img1,  $img2, $img3, $mysqli); // la fotoProfilo va ricercata nella tabella immagini con per id l'email, per questo non passo il parametro
      if (!$res) {
        header('Location:registrazione.php?error=1');
        exit;
      }

      $messaggio = "Fornitore inserito";
      invia_notifica($email, "admin", $messaggio, $mysqli);

      ?>
      <form id="myForm" action="./../../access/check.php" method="post">
      <?php
        echo '<input type="hidden" name="'.htmlentities('email').'" value="'.htmlentities($email).'">';
        echo '<input type="hidden" name="'.htmlentities('pwd').'" value="'.htmlentities($pwd).'">';
      ?>
      </form>
      <script type="text/javascript">
        document.getElementById('myForm').submit();
      </script>
      <?php
    } else {
      header('Location:registrazione.php?error=-2');
    }
?>
