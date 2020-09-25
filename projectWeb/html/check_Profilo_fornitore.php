<?php
  include './../html/utilities/db_connect.php';
  include './../html/utilities/functions.php';

    sec_session_start();
    if (isset($_POST['nome']) && isset($_POST['categoria'])
      && isset($_POST['password']) && isset($_POST['ripetiPassword']) && isset($_POST['citta']) && isset($_POST['indirizzo'])
      && isset($_POST['telefono']) && isset($_POST['desc1']) && isset($_POST['desc2'])) {

      $email = $_SESSION['e_mail'];
      $pwd = $_POST['password'];
      $mysqli = connectToDatabase();

      if ($mysqli->connect_error) {
        header('Location:Profilo_fornitore.php?error=-3');
        exit;
      }

      /* controllo che l'email non sia già presente*/
      $res = checkEmail($email,$mysqli);
      if (!$res) {
        header('Location:Profilo_fornitore.php?error=-1');
        exit;
      }

      $imgDir="./../images";
      $num=1;
      $defaultFormat="jpg";

      if(!isset($_FILES['immagine1']) || !is_uploaded_file($_FILES['immagine1']['tmp_name'])){
        $num=1;
        $img1 = $email.$num.$defaultFormat;
      } else{
        $is_img = getimagesize($_FILES['immagine1']['tmp_name']);
        if (!$is_img) {
            header('Location:Profilo_fornitore.php');
            exit;
        } else {

            $userfile_tmp = $_FILES['immagine1']['tmp_name'];

            $userfile_name = $_FILES['immagine1']['name'];

            $target_file = $imgDir . $userfile_tmp;

            if (!file_exists($target_file)) {
                //copio il file dalla sua posizione temporanea alla mia cartella upload
                if (move_uploaded_file($userfile_tmp, "$imgDir/$email.$num.$defaultFormat")) {
                    //Se l'operazione è andata a buon fine...
                    $img1="$email.$num.$defaultFormat";
                    $_POST['immagine1'] = $userfile_name;
                }
            }
        }
      }

      if(!isset($_FILES['immagine2']) || !is_uploaded_file($_FILES['immagine2']['tmp_name'])){
        $num=2;
        $img2 = $email.$num.$defaultFormat;
      } else{
        $is_img = getimagesize($_FILES['immagine2']['tmp_name']);
        if (!$is_img) {
            header('Location:Profilo_fornitore.php');
            exit;
        } else {

            $userfile_tmp = $_FILES['immagine2']['tmp_name'];

            $userfile_name = $_FILES['immagine2']['name'];

            $target_file = $imgDir . $userfile_tmp;

            if (!file_exists($target_file)) {
                //copio il file dalla sua posizione temporanea alla mia cartella upload
                if (move_uploaded_file($userfile_tmp, "$imgDir/$email.$num.$defaultFormat")) {
                    //Se l'operazione è andata a buon fine...
                    $img2="$email.$num.$defaultFormat";
                    $_POST['immagine2'] = $userfile_name;
                }
            }
        }
      }

      if(!isset($_FILES['immagine3']) || !is_uploaded_file($_FILES['immagine3']['tmp_name'])){
        $num=3;
        $img3 = $email.$num.$defaultFormat;
      } else{
        $is_img = getimagesize($_FILES['immagine3']['tmp_name']);
        if (!$is_img) {
            header('Location:Profilo_fornitore.php');
            exit;
        } else {
            $num=3;

            $userfile_tmp = $_FILES['immagine3']['tmp_name'];

            $userfile_name = $_FILES['immagine3']['name'];

            $target_file = $imgDir . $userfile_tmp;

            if (!file_exists($target_file)) {
                //copio il file dalla sua posizione temporanea alla mia cartella upload
                if (move_uploaded_file($userfile_tmp, "$imgDir/$email.$num.$defaultFormat")) {
                    //Se l'operazione è andata a buon fine...
                    $img3="$email.$num.$defaultFormat";
                    $_POST['immagine3'] = $userfile_name;
                }
            }
        }
      }

      $res = providerUpdate($_POST['nome'], $email, $_POST['categoria'], $pwd, $_POST['citta'], $_POST['indirizzo'], $_POST['telefono'], $_POST['desc1'], $_POST['desc2'], $img1,  $img2, $img3, $mysqli); // la fotoProfilo va ricercata nella tabella immagini con per id l'email, per questo non passo il parametro
      if (!$res) {
        header('Location:Profilo_fornitore.php?error=1');
        exit;
      }

      ?>
      <form id="myForm" action="./../login/access/check.php" method="post">
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
      header('Location:Profilo_fornitore.php?error=-2');
    }
?>
