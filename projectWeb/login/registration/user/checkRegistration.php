<?php
  include './../../../html/utilities/db_connect.php';
  include './../../../html/utilities/functions.php';

    sec_session_start();
    if (isset($_POST['nome']) && isset($_POST['cognome']) && isset($_POST['email'])
      && isset($_POST['password']) && isset($_POST['ripetiPassword'])
      && isset($_POST['città']) && isset($_POST['telefono'])) {
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
      $defaultFoto="profile.jpg";
      $defaultFormat="jpg";
      if (!isset($_FILES['fotoProfilo']) || !is_uploaded_file($_FILES['fotoProfilo']['tmp_name'])) {
        $fotoProfilo=$defaultFoto;
      } else {

        //verifica che sia un immagine
        $is_img = getimagesize($_FILES['fotoProfilo']['tmp_name']);
        if (!$is_img) {
            header('Location:registrazione.php?error=-4');
            exit;
        } else {

            $userfile_tmp = $_FILES['fotoProfilo']['tmp_name'];

            $userfile_name = $_FILES['fotoProfilo']['name'];

            $target_file = $imgDir . $userfile_tmp;

            if (!file_exists($target_file)) {
                //copio il file dalla sua posizione temporanea alla mia cartella upload
                if (move_uploaded_file($userfile_tmp, "$imgDir/$email.$defaultFormat")) {
                    //Se l'operazione è andata a buon fine...
                    $fotoProfilo="$email.$defaultFormat";
                    $_POST['fotoProfilo'] = $userfile_name;
                }
            }
        }
      }

      $res = clientSignIn($_POST['nome'], $_POST['cognome'], $email, $pwd, $_POST['città'], $_POST['telefono'], $fotoProfilo, $mysqli); // la fotoProfilo va ricercata nella tabella immagini con per id l'email, per questo non passo il parametro
      if (!$res) {
        header('Location:registrazione.php?error=1');
        exit;
      }

      $messaggio = "Cliente inserito";
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
