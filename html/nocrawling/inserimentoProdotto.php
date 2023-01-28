<?php
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
if (checkConn) {
    $products = conn->getProducts();
    $conn->closeConnection();

        if (count($products) != 0) {
            $result = '<label for=\"productSelector\">Seleziona un prodotto:</label>
                <select name=\"productSelector\" id=\"productSelector\">';
            foreach ($products as $product) {
                $result .= '<option value=\"'.$product->getId().'\>'.$product->getTitolo().'</option>';
            }
            $result .= '</select>';
        } else {
            $result = '<p>Non ci sono prodotti</p>';
        }
} else {
    $result = '<p>Errore di connessione al database</p>';
}
echo str_replace('<listOfProducts/>', $result, $paginaHTML);





if(isset($_POST['submit'])){
    // prende il nome del prodotto
    $product_name = pulisciInput($_POST['product-name']);
    // prende la descrizione del prodotto
    $product_description = pulisciInput($_POST['product-description']);
    // prende il nome del file immagine
    $target_dir = "uploads/";
    // $target_file => Contiene il percorso completo del file caricato (es. uploads/immagine.jpg)
    $target_file = $target_dir . basename($_FILES["product-image"]["name"]);
    //alt immagine
    $product_image_alt = pulisciInput($_POST['product-image-alt']);

    $prodotto = new Prodotto($product_name, $product_description, $target_file, $product_image_alt);
    //chmod('upload',777);
    if (is_writable('uploads/')) {
        $messaggioForm .= '<p>La cartella ha i permessi</p>';
    } else {
        $messaggioForm .= '<p>La cartella non ha i permessi</p>';
    }
    
    if (move_uploaded_file($_FILES["product-image"]["tmp_name"], $target_file)){
        $messaggioForm .= '<p>Immagine caricata correttamente</p>';
    }else{
        $messaggioForm .= '<p>Immagine non caricata correttamente</p>';
    }

    $messaggioForm = ($prodotto->__toString()=="") ? $prodotto->save() : '<p>I dati non sono inseriti correttamente:'.$prodotto.'</p>';

}
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
}
*/

echo str_replace("<messaggioForm />", $messaggioForm, $paginaHTML);
    
?>










