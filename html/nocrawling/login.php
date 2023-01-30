<?php
ob_start();
session_start();
use DB\DBAccess;
require_once("connection.php");

if (isset($_SESSION["username"])) {
    header("Location: inserimentoProdotto.html");
    exit;
}

$paginaHTML = file_get_contents("login.html");

$messaggioForm = "";

function pulisciInput($value) {
    $value = trim($value); 
    $value = strip_tags($value); 
    $value = htmlentities($value); 

    return $value;
}


if (isset($_POST['username']) && isset($_POST['password'])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $dbAccess = new DBAccess();
    $connessioneRiuscita = $dbAccess->openConnection();

    if ($connessioneRiuscita == true) {
        $queryOK = $dbAccess->login($username, $password);
        $dbAccess->closeConnection();

        if ($queryOK == true) {
            $messaggioForm .= '<div class="alertSuccess" role="alert">Accesso effettuato</div> ';
            $_SESSION["username"] = $username;
        }
        else
            $messaggioForm = '<div class="alertDanger" role="alert">Utente non riconosciuto, si prega di inserire nuovamente nome utente e password </div> ';
        
    }
    else {
        $messaggioForm = '<div class="alertDanger" role="alert">Problemi database</div> ';
    }
}

    // sostituisco il tag <messaggioForm /> con il messaggio da mostrare all'utente
    $paginaHTML = str_replace("<messaggioForm />", $messaggioForm, $paginaHTML);

    //stampo la pagina HTML
    echo $paginaHTML;
    header("Location: inserimentoProdotto.html");
    ob_end_flush();
    
    
?>