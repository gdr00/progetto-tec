<?php
//chdir('../..'); //torno alla root directory del progetto dato che sono in html/nocrawling
//echo getcwd(); //debug
use DB\DBAccess;
require_once("connection.php");
require_once("prodotto.php");

$paginaHTML = file_get_contents("inserimentoProdotto.html");

// Errore da mostrare all'utente
$messaggioForm = "messaggio ok";

$conn = new DBAccess();
$checkConn = $conn->openConnection();
$result = '';
if ($checkConn) {
    $products = $conn->getProducts();
    $conn->closeConnection();
        if ($products != null) {
            foreach ($products as $product) {
                $result .= '<option value="'.$product['id'].'"\>'.$product['titolo'].'</option>';
            }
        } else {
            $result = '<p class="serverStringError">Nessun prodotto presente<p>';
        }
} else {
    $result = '<p class="serverStringError">Il servizio non è al momento raggiungibile, ci scusiamo per il disagio.<p>';
}
$paginaHTML = str_replace('<listOfProducts />', $result, $paginaHTML);



if(isset($_POST['inserisci'])){
    $prodotto = new Prodotto($_POST['product-name'], $_POST['product-description'], $_POST['product-image'], $_POST['product-image-alt']);
    $messaggioForm .= ($prodotto->__toString()=="") ? $prodotto->save() : '<p>I dati non sono inseriti correttamente:'.$prodotto.'</p>';

}
if (isset($_POST['modifica'])) {
    $modPr = new Prodotto($_POST['product-name'], $_POST['product-description'], $_POST['product-image'], $_POST['product-image-alt']);
    if($modPr->__toString() != "")
        $messaggioForm .= '<p class="serverStringError">I dati non sono inseriti correttamente:</p>'.$modPr;
    else
        $messaggioForm = $prodotto->update($modPr->getTitolo(), $modPr->getDescrizione(), $modPr->getPath(),  $modPr->getAlt());
}

if (isset($_POST['elimina'])) {

    $conn = new DBAccess();
    $checkConn = $conn->openConnection();
    if ($checkConn) {
        $product_name = $_POST['product-selector'];
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
echo str_replace("<messaggioForm/>", $messaggioForm, $paginaHTML);
?>