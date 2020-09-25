<?php
include "utilities/functions.php";
include "utilities/db_connect.php";
sec_session_start();
$conn = connectToDatabase();
$login=login_check($conn);
$_SESSION["lastPage"] = 'ordini.php';
$cliente = 1;
$_SESSION["num"] = $cliente;

if ($login) {
  $myArray = array();
  $myArray2 = array();

$conn = connectToDatabase();

$e_mail_c = $_SESSION["e_mail"];
$e_mail_f = $_POST['e_mail_f'];
$nomeP = $_POST['nomeP'];

$messaggio = "Prodotto ordinato";
invia_notifica($e_mail_c, $e_mail_f, $messaggio, $conn);
changeStato($e_mail_c, $e_mail_f, $nomeP, $_POST);


}else{
$login_failed=99;
header('Location: ./../login/access/login.php?error='.$login_failed);
}

function changeStato($e_mail_c, $e_mail_f, $nomeP, $data){
  class Ordine {
    public $e_mail_cliente;
    public $e_mail_fornitore;
    public $quantita;
    public $nomeProdotto;
    public $stato;
    public $data;
    public $ora;
    public $luogo;

    function __construct($e_mail_cliente,$e_mail_fornitore, $quantita, $nomeProdotto, $stato, $data, $ora, $luogo) {
      $this->e_mail_cliente = $e_mail_cliente;
      $this->e_mail_fornitore = $e_mail_fornitore;
      $this->quantita = $quantita;
      $this->nomeProdotto = $nomeProdotto;
      $this->stato = $stato;
      $this->data = $data;
      $this->ora = $ora;
      $this->luogo = $luogo;
    }
  }

      $conn = connectToDatabase();

      $e_mail_cliente = $e_mail_c;
      $e_mail_fornitore = $e_mail_f;
      $nomeProdotto = $nomeP;
      $luogo = $data["luogo"];
      $date = $data["data"];
      $ora = $data["ora"];
      $myArray = array();


      $query_sql="SELECT * FROM ordine WHERE ordine.e_mail_cliente = '" . $e_mail_c . "' AND ordine.stato = 0";
      $result = $conn->query($query_sql);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $myOrdine = new Ordine($row["e_mail_cliente"],$row["e_mail_fornitore"],$row["quantita"],$row["nomeProdotto"],$row["stato"],$row["data"],$row["ora"],$row["luogo"]);
          $myArray[]=$myOrdine;
        }
      }

      foreach ($myArray as $key => $value) {
        $query_sql ="UPDATE ordine SET ordine.stato = 1, ordine.data = '" . $date . "', ordine.ora = '" . $ora . "', ordine.luogo = '" . $luogo . "'
        WHERE ordine.e_mail_cliente = '" . $value->e_mail_cliente . "' AND ordine.e_mail_fornitore = '" . $value->e_mail_fornitore . "' AND ordine.nomeProdotto= '" . $value->nomeProdotto . "'";
        $result = $conn->query($query_sql);
      }

}
?>
