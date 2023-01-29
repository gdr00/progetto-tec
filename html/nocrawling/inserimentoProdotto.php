<?php
//chdir('../..'); //torno alla root directory del progetto dato che sono in html/nocrawling
//echo getcwd(); //debug
use DB\DBAccess;
require_once("connection.php");
require_once("prodotto.php");

$paginaHTML = file_get_contents("inserimentoProdotto.html");

// Errore da mostrare all'utente
$messaggioForm = "messaggio ok";

// Funzione per pulire i dati in input

function pulisciInput($value) {
    $value = trim($value); 
    $value = strip_tags($value); 
    $value = htmlentities($value); 

    return $value;
}

$conn = new DBAccess();
$checkConn = $conn->openConnection();
$result = '';
if ($checkConn) {
    $products = $conn->getProducts();
    $conn->closeConnection();
        if ($products != null) {
            foreach ($products as $product) {
                $result .= '<option value=\"'.$product['id'].'\>'.$product['titolo'].'</option>';
            }
        } else {
            $result = '<p class="serverStringError">Nessun prodotto presente<p>';
        }
} else {
    $result = '<p class="serverStringError">Il servizio non è al momento raggiungibile, ci scusiamo per il disagio.<p>';
}
$paginaHTML = str_replace('<listOfProducts />', $result, $paginaHTML);



if(isset($_POST['inserisci'])){
    echo "<h1>TEST</h1>";
    chdir('../..');
     // prende il nome del prodotto
    $product_name = pulisciInput($_POST['product-name']);
     // prende la descrizione del prodotto
    $product_description = pulisciInput($_POST['product-description']);
     // prende il nome del file immagine
     //torno alla root directory del progetto dato che sono in html/nocrawling
    $target_dir = realpath('./php/uploads/');
     // $target_file => Contiene il percorso completo del file caricato (es. uploads/immagine.jpg)
    $target_file = $target_dir . '/' . basename($_FILES["product-image"]["name"]);
     //alt immagine
    $product_image_alt = pulisciInput($_POST['product-image-alt']);

        $prodotto = new Prodotto($product_name, $product_description, $target_file, $product_image_alt);
        //chmod('upload',777);
        if (is_writable($target_dir)) {
            $messaggioForm .= '<p>La cartella ha i permessi</p>';
        } else {
            $messaggioForm .= '<p>La cartella non ha i permessi</p>';
        }
        
        if (move_uploaded_file($_FILES["product-image"]["tmp_name"], $target_file)){
            $messaggioForm .= '<p>Immagine caricata correttamente</p>';
        }else{
            $messaggioForm .= '<p>Immagine non caricata correttamente</p>';
        }

        $messaggioForm .= ($prodotto->__toString()=="") ? $prodotto->save() : '<p>I dati non sono inseriti correttamente:'.$prodotto.'</p>';

}
if (isset($_POST['modifica'])) {
    throw new ErrorException("modifica");
    
}
if (isset($_POST['elimina'])) {

    throw new ErrorException("elimina");

    $product_name = pulisciInput($_POST['product-selector']);
    $conn = new DBAccess();
    $checkConn = $conn->openConnection();
    if ($checkConn) {
        $checkDel = $conn->deleteProduct($product_name);
        $conn->closeConnection();
        if ($checkDel) {
            $messaggioForm = '<p class="serverStringSuccess">Prodotto eliminato correttamente</p>';
        } else {
            $messaggioForm = '<p class="serverStringError">Il prodotto non è stato eliminato correttamente</p>';
        }
    } else {
        $messaggioForm = '<p class="serverStringError">Il servizio non è al momento raggiungibile, ci scusiamo per il disagio.<p>';
    }


}
echo str_replace("<messaggioForm />", $messaggioForm, $paginaHTML);




// dopo che ho fatto tutti i controlli
/*
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
    echo $paginaHTML;messaggioForm
}*/

?>