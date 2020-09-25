<?php

  /**
   * Effettua la connessione al database; ritorna l'oggetto mysqli con cui interagire.
   **/
  function connectToDatabase() {
    $host = "localhost"; // E' il server a cui ti vuoi connettere.
    $user = "noneunsitopersecchi"; // E' l'utente con cui ti collegherai al DB.
    $pwd = ""; // Password di accesso al DB.
    $database = "my_noneunsitopersecchi"; // Nome del database.
    return new mysqli($host, $user, $pwd, $database);
  }

  /*
   * Credenziali amministratore:
   * user: amedeo.bertuccioli@studio.unibo.it
   * pwd: amedeo
   * user: luca.ghigi2@studio.unibo.it
   * pwd: luca
   * user: thomas.angelini@studio.unibo.it
   * pwd: thomas
   */

   function isAdmin($email, $mysqli) {
     if ($res = $mysqli->prepare("SELECT e_mail_admin FROM admin WHERE e_mail_admin = ? LIMIT 1")) {
       $res->bind_param('s', $email); // esegue il bind del parametro '$email'.
       $res->execute(); // esegue la query appena creata.
       $res->store_result();
       $res->bind_result($id); // got the information
       $res->fetch();
       if(!is_null($id)){
         return true;
       }
     }
     return false;
   }


   function login($email, $pwd, $mysqli) {
     // Usando statement sql 'prepared' non sarà possibile attuare un attacco di tipo SQL injection.
     $People = array( "admin"=> "e_mail_admin",
                      "cliente"=>"e_mail_cliente",
                      "fornitore"=>"e_mail_fornitore");
     foreach ($People as $key => $value) {
       if ($res = $mysqli->prepare("SELECT password, codice FROM $key WHERE $value = ? LIMIT 1")) {
         $res->bind_param('s', $email); // esegue il bind del parametro '$email'.
         $res->execute(); // esegue la query appena creata.
         $res->store_result();
         $res->bind_result($password, $codice); // recupera il risultato della query e lo memorizza nelle relative variabili.
         $res->fetch();

         if($res->num_rows == 1) { // se l'utente esiste
           $pwd = hash('sha512', $pwd.$codice); // codifica la password usando una chiave univoca.
           // verifichiamo che non sia disabilitato in seguito all'esecuzione di troppi tentativi di accesso errati.
           if(checkbrute($email, $mysqli) == true) {
             // Account bloccato, non si può continuare ad accedere
             return -1;
           } else {
             if($pwd == $password) { // Password corretta!
               $user_browser = $_SERVER['HTTP_USER_AGENT']; // Recupero il parametro 'user-agent' relativo all'utente corrente.
               $_SESSION['login_string'] = hash('sha512', $pwd.$user_browser);
               // Login eseguito con successo.
               if ($value=="e_mail_cliente"){
                 return 1;
               }else if($value=="e_mail_fornitore") {
                 return 2;
               }else{
                 return 3;
               }
             } else { // Password incorretta.
               // Registriamo il tentativo fallito nel database.
               $now = time();
               $mysqli->query("INSERT INTO tentativoLogin ($value, time) VALUES ('$email', '$now')");
               if(checkbrute($email, $mysqli) == true) {
                 return -1; //avvisi che si sono fatti troppi errori
               } else {
                 return 70; //Password errata
               }
             }
           }
         }
       }
     }
     return 0; //L'utente inserito non esiste.
   }

   function login_check($mysqli) {
      // Verifica che tutte le variabili di sessione siano impostate correttamente
      if(isset($_SESSION['login_string'])) {
        $user_id = $_SESSION['e_mail'];
        $login_string = $_SESSION['login_string'];
        $user_browser = $_SERVER['HTTP_USER_AGENT']; // reperisce la stringa 'user-agent' dell'utente
        $People = array( "admin"=>"e_mail_admin",
                         "cliente"=>"e_mail_cliente",
                         "fornitore"=>"e_mail_fornitore" );
        foreach ($People as $key => $value) { // check for admin, cliente, fornitore
          if ($res = $mysqli->prepare("SELECT password FROM $key WHERE $value = ?")) {
             $res->bind_param('s', $user_id); // esegue il bind del parametro '$user_id'.
             $res->execute(); // Esegue la query creata.
             $res->store_result();
             if($res->num_rows == 1) { // se l'utente esisteecho "login ok";
                $res->bind_result($password); // recupera le variabili dal risultato ottenuto.
                $res->fetch();
                $login_check = hash('sha512', $password.$user_browser);
                if($login_check == $login_string) {
                   // Login eseguito!!!!
                   return true;
                }
             }
          }
        }
      }
      return false;
   }

   function check_logout() {
     if (isset($_POST['logout'])) {
       unset($_SESSION['login_string']);
       $_SESSION = array();
       session_destroy();
       header('HTTP/1.1 301 Moved Permanently');
       header('Location: ./../login/access/login.php');
       exit();
      }
    }

   function clientSignIn($nome, $cognome, $email, $password, $città, $telefono, $fotoProfilo, $mysqli){

     $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
     // Crea una password usando la chiave appena creata.
     $password = hash('sha512', $password.$random_salt);
     // inserire codice
     if ($insert_stmt = $mysqli->prepare("INSERT INTO cliente (name, surname, e_mail_cliente, password, citta, telefono, fotoProfilo, codice) VALUES (?, ?, ?, ?, ?, ?, ?, ?)")) {
       $insert_stmt->bind_param("ssssssss",$nome, $cognome, $email, $password, $città, $telefono, $fotoProfilo, $random_salt); // email is the id for the profile image
       // Esegui la query ottenuta.
       $insert_stmt->execute();
       return true;
     }
     print_r($mysqli->error_list);
     return false;
   }

   function providerSignIn($nome, $email, $categoria, $password, $città, $ind, $telefono, $desc1, $desc2, $img1, $img2, $img3, $mysqli){

     $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
     // Crea una password usando la chiave appena creata.
     $password = hash('sha512', $password.$random_salt);
     // inserire codice
     if ($insert_stmt = $mysqli->prepare("INSERT INTO fornitore (name, categoria, e_mail_fornitore, password, citta, indirizzo, desc1, desc2, img1, img2, img3, telefono, codice) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
       $insert_stmt->bind_param("sssssssssssss",$nome, $categoria, $email, $password, $città, $ind, $desc1, $desc2, $img1, $img2, $img3, $telefono, $random_salt); // email is the id for the profile image
       // Esegui la query ottenuta.
       $insert_stmt->execute();
       return true;
     }
     print_r($mysqli->error_list);
     return false;
   }

   function checkEmail($email,$mysqli){

     $People = array( "admin"=>"e_mail_admin",
                      "cliente"=>"e_mail_cliente",
                      "fornitore"=>"e_mail_fornitore" );
     foreach ($People as $key => $value) { // check for admin, cliente, fornitore
       if ($res = $mysqli->prepare("SELECT $value FROM $key WHERE $value = ?")) {
           $res->bind_param('s', $email); // bind with '$email'.
           $res->execute();
           $res->store_result();
           $res->bind_result($id); // got the information
           $res->fetch();
           if(!is_null($id)){
             return true;
           }
         }
       }

     return false;
   }

   function checkbrute($email, $mysqli) {
      // Recupero il timestamp
      $now = time();
      // Vengono analizzati tutti i tentativi di login a partire dalle ultime due ore.
      $valid_attempts = $now - (2 * 60 * 60);
      $People = array( "admin"=>"e_mail_admin",
                       "cliente"=>"e_mail_cliente",
                       "fornitore"=>"e_mail_fornitore" );

      foreach ($People as $key => $value) {
        if ($stmt = $mysqli->prepare("SELECT time FROM tentativoLogin WHERE $value = ? AND time > '$valid_attempts'")) {
           $stmt->bind_param('i', $email);
           // Eseguo la query creata.
           $stmt->execute();
           $stmt->store_result();
           // Verifico l'esistenza di più di 5 tentativi di login falliti.
           if($stmt->num_rows > 5) {
              return true;
           }
        }
      }
      return false;
   }

   function setClientData($mysqli, $email) {
     if ($res = $mysqli->prepare("SELECT name, surname, fotoprofilo FROM cliente WHERE e_mail_cliente = ?")) {
         $res->bind_param('s', $email); // esegue il bind del parametro '$email'.
         $res->execute(); // esegue la query appena creata.
         $res->store_result();
         $res->bind_result($nome, $cognome, $foto); // recupera il risultato della query e lo memorizza nelle relative variabili.
         $res->fetch();
         $_SESSION["cliente"] = $nome." ".$cognome;
         $_SESSION["e_mail"] = $email;
         $_SESSION["fotoProfilo"] = $foto;
     }
   }

   function setProviderData($mysqli, $email) {
     if ($res = $mysqli->prepare("SELECT name FROM fornitore WHERE e_mail_fornitore = ?")) {
         $res->bind_param('s', $email); // esegue il bind del parametro '$email'.
         $res->execute(); // esegue la query appena creata.
         $res->store_result();
         $res->bind_result($nome); // recupera il risultato della query e lo memorizza nelle relative variabili.
         $res->fetch();
         $_SESSION["fornitore"] = $nome." ";
         $_SESSION["e_mail"] = $email;
     }
   }

   function setAdminData($mysqli, $email){
     if ($res = $mysqli->prepare("SELECT username FROM admin WHERE e_mail_admin = ?")) {
         $res->bind_param('s', $email); // esegue il bind del parametro '$email'.
         $res->execute(); // esegue la query appena creata.
         $res->store_result();
         $res->bind_result($username); // recupera il risultato della query e lo memorizza nelle relative variabili.
         $res->fetch();
         $_SESSION["admin"] = $username." ";
         $_SESSION["e_mail"] = $email;
     }
   }

   function clientUpdate($nome, $cognome, $email, $password, $città, $telefono, $fotoProfilo, $mysqli){

     $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
     // Crea una password usando la chiave appena creata.
     $password = hash('sha512', $password.$random_salt);

/*     $sql="UPDATE cliente SET `name`='.$nome',
                              `surname`='.$cognome',
                              `password`='.$password',
                              `citta`='.$città',
                              `telefono`='.$telefono',
                              `fotoProfilo`='.$fotoProfilo',
                              `codice`='.$random_salt',
            WHERE e_mail_cliente='.$email'";
*/
                 // Prepare statement
     $query_sql="UPDATE cliente SET cliente.name='" . $nome . "', cliente.surname='" . $cognome ."', cliente.password='" . $password . "', cliente.telefono='" . $telefono . "',
                        cliente.citta='" . $città . "', cliente.codice='" . $random_salt . "', cliente.fotoProfilo='" . $fotoProfilo . "'
                 WHERE cliente.e_mail_cliente='" . $email . "'";
     $result = $mysqli->query($query_sql);

     return true;
   }

   function providerUpdate($nome, $email, $categoria, $password, $città, $ind, $telefono, $desc1, $desc2, $img1, $img2, $img3, $mysqli){

     $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
     // Crea una password usando la chiave appena creata.
     $password = hash('sha512', $password.$random_salt);

     $query_sql="UPDATE fornitore SET fornitore.name='" . $nome . "', fornitore.password='" . $password . "', fornitore.telefono='" . $telefono . "',
                        fornitore.indirizzo='" . $ind . "', fornitore.categoria='" . $categoria . "', fornitore.citta='" . $città . "', fornitore.codice='" . $random_salt . "',
                        fornitore.desc1='" . $desc1 . "', fornitore.desc2='" . $desc2 . "', fornitore.img1='" . $img1 . "', fornitore.img2='" . $img2 . "', fornitore.img3='" . $img3 . "'
                 WHERE fornitore.e_mail_fornitore='" . $email . "'";
     $result = $mysqli->query($query_sql);

     return true;
   }

   function adminUpdate($username, $email, $password, $mysqli){

     $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
     // Crea una password usando la chiave appena creata.
     $password = hash('sha512', $password.$random_salt);

     $query_sql="UPDATE admin SET admin.username='" . $username . "', admin.password='" . $password . "',
                                  admin.codice='" . $random_salt . "'
                 WHERE admin.e_mail_admin='" . $email . "'";
     $result = $mysqli->query($query_sql);

     return true;
   }

   function check_notification($e_mail,$mysqli){
     if (isAdmin($e_mail, $mysqli) || ($e_mail=="admin")){
       $e_mail="admin";
     }
     if ($stmt = $mysqli->prepare("SELECT id FROM notifica WHERE visto = 0 AND destinatario = ? LIMIT 1")) {
        $stmt->bind_param('s', $e_mail);
        // Eseguo la query creata.
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id); // got the information
        $stmt->fetch();
        if(is_null($id)){
          return false;
        }
      }
      $visto = 1;
      $query_sql="UPDATE notifica SET notifica.visto ='" . $visto . "'
                  WHERE notifica.id='" . $id . "'";
      $result = $mysqli->query($query_sql);
      return true;
   }

   function invia_notifica($mtt, $dst, $messaggio, $mysqli){
     if (isAdmin($mtt, $mysqli) || ($mtt=="admin")){
       $mtt="admin";
     }else if (isAdmin($dst,$mysqli) || ($mtt=="admin")){
       $dst="admin";
     }
     $query_sql = "INSERT INTO notifica (destinatario, messaggio, visto, mittente)
                   VALUES ('$dst', '$messaggio', 0, ' $mtt')";
     $result = $mysqli->query($query_sql);

   }
?>
