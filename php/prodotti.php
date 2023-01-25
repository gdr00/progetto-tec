<?php

/*
Build prodotti.html reading from the database
*/
use DB\DBAccess;
require_once("../html/nocrawling/connection.php");
$paginaHTML = file_get_contents("../html/prodotti.html");

$dbAccess = new DBAccess();
$connessioneRiuscita = $dbAccess->openConnection();
$stringaProdotti = "";

if($connessioneRiuscita){
    $prodotti = $dbAccess->getProducts();
    if($prodotti != null){
        $stringaProdotti .= '<ul id="products">';
        foreach($prodotti as $prodotto){
            $stringaProdotti .= '<li>';
            $stringaProdotti .= '<h3>'. $prodotto['titolo'] . '</h3>';
            $stringaProdotti .= '<img src="'. $prodotto['immagine'] . '" alt="'.$prodotto['alt_immagine'].'">'; #TODO da inserire la path dell'immagine
            $stringaProdotti .= '<p>'. $prodotto['descrizione'] . '</p>';
            $stringaProdotti .= '</li>';
        }
        $stringaProdotti .= '</ul>';
    }
    else
        $stringaProdotti .= '<p class="serverStringError">Nessun prodotto presente<p>';
}
else{
    $stringaProdotti = '<p class="serverStringError">Il servizio non è al momento raggiungibile, ci scusiamo per il disagio.<p>';
    mail('luca.brugnera@libero.it', 'Database non raggiungibile', 'Sono stati riscontrati problemi con accesso al database');
    # TODO invio di un'email agli admin per segnalare il malfunzionamento 
}
echo str_replace('<listaProdotti />', $stringaProdotti, $paginaHTML)
?>