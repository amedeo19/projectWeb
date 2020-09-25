<?php
include './utilities/db_connect.php';
include './utilities/functions.php';

  sec_session_start();
  $mysqli = connectToDatabase();
  $e_mail = $_SESSION["e_mail"];
  $result = check_notification($e_mail,$mysqli);
  echo $result;
?>
