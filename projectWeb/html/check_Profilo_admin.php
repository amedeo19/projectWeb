<?php
  include './../html/utilities/db_connect.php';
  include './../html/utilities/functions.php';

    sec_session_start();
    if (isset($_POST['nome']) && isset($_POST['password']) && isset($_POST['ripetiPassword'])) {
      $mysqli = connectToDatabase();
      $email= $_SESSION["e_mail"];
      $pwd = $_POST['password'];

      if ($mysqli->connect_error) {
        header('Location:Profilo_admin.php?error=-3');
        exit;
      }

      /* controllo che l'email non sia già presente*/
      $res = checkEmail($email,$mysqli);
      if (!$res) {
        header('Location:Profilo_admin.php?error=-1');
        exit;
      }

      $res = adminUpdate($_POST['nome'], $email, $pwd, $mysqli); 
      if (!$res) {
        header('Location:Profilo_admin.php?error=90');
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
      print_r($email);
      header('Location:Profilo_admin.php?error=-2');
    }
?>
