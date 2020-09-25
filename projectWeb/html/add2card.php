<?php
include "utilities/functions.php";
include "utilities/db_connect.php";
sec_session_start();
$conn = connectToDatabase();
$login=login_check($conn);
$_SESSION["lastPage"] = 'menu.php';
$cliente = 1;
$_SESSION["num"] = $cliente;

if ($login) {
  $myArray = array();
  $myArray2 = array();

$conn = connectToDatabase();

$e_mail_c = $_SESSION["e_mail"];
$e_mail_f = $_POST['e_mail'];
$quantita = $_POST['quantita'];
$nomeP = $_POST['nomeP'];

addOrdine($e_mail_c, $e_mail_f, $quantita, $nomeP);


}else{
$login_failed=99;
header('Location: ./../login/access/login.php?error='.$login_failed);
}

function addOrdine($e_mail_c, $e_mail_f, $quantita, $nomeP){
  $conn = connectToDatabase();
  $e_mail_cliente = $e_mail_c;
  $quantita = $quantita;
  $e_mail_f = $e_mail_f;
  $nomeP = $nomeP;

  $query_sql = "INSERT INTO ordine (e_mail_cliente, e_mail_fornitore, quantita, nomeProdotto, stato)
                VALUES ('$e_mail_cliente', '$e_mail_f', '$quantita', '$nomeP', 0)";
  $result = $conn->query($query_sql);
}
?>
