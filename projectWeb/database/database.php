<?php
//Dichiarazione variabili per server
$servername="localhost";
$username ="root";
$password ="";
$database = "db";

if(isset($_POST["name"]) and isset($_POST["categoria"]) and isset($_POST["e_mail"]) and isset($_POST["password"]) and isset($_POST["citta"]) and isset($_POST["indirizzo"])){
  //preparazione query
  $query_sql="INSERT INTO `fornitore` (`name`, `categoria`, `e_mail`, `password`, `citta`, `indirizzo`) VALUES ('".$_POST['name']."', '"
                                                                                                              .$_POST['categoria']."', '"
                                                                                                              .$_POST['e_mail']."', '"
                                                                                                              .$_POST['password']."', '"
                                                                                                              .$_POST['citta']."', '"
                                                                                                              .$_POST['indirizzo']."')";
  //connessione al db
  $conn =new mysqli($servername, $username, $password, $database);
  //Check della connessione
  if ($conn->connect_errno) {
      echo "Failed to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
  }
  //Invio query
  if ($conn->query($query_sql) === TRUE) {
      echo "Un nuovo record è stato creato con successo";
  } else {
      echo "Errore: " . $query_sql . "<br>" . $conn->error;
  }
  //Chiusura connessione con db
  $conn->close();
}


 ?>

 <!DOCTYPE html>
 <html lang="it">
 <head>
 	<title>aggiungi fornitore</title>
 </head>
 <body>
 	<section>
 		<h1>Aggiungi un nuovo Fornitore nel database</h1>

 		<form action="database.php" method="post">
 			<label for="name">Nome
 				<input type="text" id="name" name="name">
 			</label>
      <label for="categoria">Categoria
 				<input type="text" id="categoria" name="categoria">
 			</label>
      <label for="e_mail">E_mail
 				<input type="text" id="e_mail" name="e_mail">
 			</label>
      <label for="password">Password
 				<input type="text" id="password" name="password">
 			</label>
      <label for="citta">Citta
 				<input type="text" id="citta" name="citta">
 			</label>
      <label for="indirizzo">Indirizzo
 				<input type="text" id="indirizzo" name="indirizzo">
 			</label>
      <label for="submit">Submit
        <input type="submit" id="submit">
      </label>
 		</form>
 	</section>

 </body>
 </html>
