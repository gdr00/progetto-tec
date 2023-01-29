<?php
session_start();
use DB\DBAccess;
require_once("connection.php");

$paginaHTML = file_get_contents("login.html");

$messaggioForm = "";

function pulisciInput($value) {
    $value = trim($value); 
    $value = strip_tags($value); 
    $value = htmlentities($value); 

    return $value;
}


$email = pulisciInput($_POST['email']);
$password = pulisciInput($_POST['password']);

if($messaggioForm == "") {
    $dbAccess = new DBAccess();
    $connessioneRiuscita = $dbAccess->openConnection();
    if ($connessioneRiuscita == true) {
        $queryOK = $dbAccess->login($email, $password);
        $dbAccess->closeConnection();
        if ($queryOK == true) {
            $messaggioForm  .= '<div class="alertSuccess" role="alert">Accesso effettuato</div> ';
            header("inserimentoProdotto.html");
        } else
        {
            $messaggioForm .= '<div class="alertDanger" role="alert">I nostri sistemi sono al momento non funzionanti. Ci scusiamo per il disagio</div> ';
        }
    }else{
        $messaggioForm = '<div id="messaErrors"<ul>' . $messaggioForm . '</ul></div';
    }

    // sostituisco il tag <messaggioForm /> con il messaggio da mostrare all'utente
    $paginaHTML = str_replace("<messaggioForm />", $messaggioForm, $paginaHTML);

    //stampo la pagina HTML
    echo $paginaHTML;
    
    
}

?>