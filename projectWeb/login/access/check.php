<?php

include './../utilities/functions.php';
include './../utilities/db_connect.php';

  sec_session_start(); // usiamo la nostra funzione per avviare una sessione php sicura
  if(isset($_POST['username'], $_POST['pwd'])) {
     $username = $_POST['username'];
     $password = $_POST['pwd']; // Recupero la password criptata.
     $mysqli = connectToDatabase();

     if ($mysqli->connect_error) {
       header('Location: ./login.php?error=4');
       exit;
     }

     $res = login($username, $password, $mysqli);
     if($res === 1) {
          header('Location: ./../amministrazione.php');
     } else {
        // Login fallito
       header('Location: ./login.php?error='.$res);
     }
  } else if (!isset($_POST['pwd'])) {
      header('Location: ./login.php?error=3');
  } else {
      // Le variabili corrette non sono state inviate a questa pagina dal metodo POST.
      echo 'Invalid Request';
  }

?>
