<?php
ob_start();
if (session_status() == PHP_SESSION_NONE) {
    // inizializza la sessione
    session_start();
  }

use DB\DBAccess;
require_once("connection.php");

if (isset($_SESSION["username"]) && $_SESSION["admin"] == true) {
    header("Location: inserimentoProdotto.php");
} else{
    $paginaHTML = file_get_contents("login.html");

$messaggioForm = "";

function pulisciInput($value) {
    $value = trim($value); 
    $value = strip_tags($value); 
    $value = htmlentities($value); 

    return $value;
}


if (isset($_POST['username']) && isset($_POST['password'])) {

    $username = pulisciInput($_POST["username"]);
    $password = pulisciInput($_POST["password"]);

    $dbAccess = new DBAccess();
    $connessioneRiuscita = $dbAccess->openConnection();

    if ($connessioneRiuscita == true) {
        $queryOK = $dbAccess->login($username, $password);
        $dbAccess->closeConnection();

        if ($queryOK == true) {
            $messaggioForm .= '<p class="serverStringError">Accesso effettuato </p> '; 
            $_SESSION["username"] = $username;
            header("Location: inserimentoProdotto.php");
        }
        else
            $messaggioForm = '<p class="serverStringError">Utente non riconosciuto, si prega di inserire nuovamente nome utente e password </p> ';
        
    }
    else {
        $messaggioForm = '<p class="serverStringError">Il servizio non è al momento raggiungibile, ci scusiamo per il disagio.</p> ';
    }
}
    $paginaHTML = str_replace("<messaggioForm />", $messaggioForm, $paginaHTML);
    echo $paginaHTML;
    ob_end_flush();
}
?>