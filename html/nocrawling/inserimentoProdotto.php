<?php
use DB\DBAccess;
require_once("connection.php");

$paginaHTML = file_get_contents("inserimentoProdotto.html");

// Errore da mostrare all'utente
$messaggioForm = "";

// Funzione per pulire i dati in input

function pulisciInput($value) {
    $value = trim($value); 
    $value = strip_tags($value); 
    $value = htmlentities($value); 

    return $value;
}

if(isset($_POST['submit'])){
    // prende il nome del prodotto
    $product_name = pulisciInput($_POST['product-name']);
    // prende la descrizione del prodotto
    $product_description = pulisciInput($_POST['product-description']);
    // prende il nome del file immagine
    $target_dir = "uploads/";
    // $target_file => Contiene il percorso completo del file caricato (es. uploads/immagine.jpg)
    $target_file = $target_dir . basename($_FILES["product-image"]["name"]);

    /* Utilizzo del classe prodotto per controllare i dati in input  e per salvare poi nel dv*/

}
// dopo che ho fatto tutti i controlli
if ($messaggioForm == ""){
    // inserisco il prodotto nel database
    $dbAccess = new DBAccess();
    $connessioneRiuscita = $dbAccess->openConnection();
    if ($connessioneRiuscita == true) {
        $queryOK = $dbAccess->insertProduct($product_name, $product_description, $target_file);
        $dbAccess->closeConnection();
        if ($queryOK == true) {
            $messaggioForm  .= '<div class="alertSuccess" role="alert">Prodotto inserito correttamente</div> ';
        }
        else {
            $messaggioForm .= '<div class="alertDanger" role="alert">I nostri sistemi sono al momento non funzionanti. Ci scusiamo per il disagio</div> ';
        }
    }
    else {
        $messaggioForm = '<div id="messaErrors"<ul>' . $messaggioForm . '</ul></div';
    }

    // sostituisco il tag <messaggioForm /> con il messaggio da mostrare all'utente
    $paginaHTML = str_replace("<messaggioForm />", $messaggioForm, $paginaHTML);
    //stampo la pagina HTML
    echo $paginaHTML;
}
?>










