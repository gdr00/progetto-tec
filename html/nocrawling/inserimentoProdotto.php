<?php
//chdir('../..'); //torno alla root directory del progetto dato che sono in html/nocrawling
//echo getcwd(); //debug
ob_start();
session_start();
use DB\DBAccess;
require_once "connection.php";
require_once "prodotto.php";

if ($_SESSION["admin"] == false) {
    header("Location: login.php");
} else {
    $paginaHTML = file_get_contents("inserimentoProdotto.html");

    // Errore da mostrare all'utente
    $messaggioForm = "messaggio ok";

    if (isset($_POST["inserisci"])) {
        $prodotto = new Prodotto(
            $_POST["product-name"],
            $_POST["product-description"],
            $_FILES["product-image"]["name"],
            $_POST["product-image-alt"]
        );

        $messaggioForm .=
            $prodotto->__toString() == ""
                ? $prodotto->save()
                : "<p>I dati non sono inseriti correttamente:" .
                    $prodotto .
                    "</p>";
    }
    if (isset($_POST["modifica"])) {
/*
        $formMod = '
            <label for="mod-product-name">Inserire titolo prodotto:</label>
            <input type="text" id="mod-product-name" name="mod-product-name" required>
            <label for="mod-product-image">Immagine prodotto:</label>
            <input type="file" id="mod-product-image" name="mod-product-image" multiple required>
            <label for="mod-product-image-alt">Descrizione testuale dell\'immagine:</label>
            <textarea type="text" id="mod-product-image-alt" name="mod-product-image-alt" required></textarea>
            <label for="mod-product-description">Descrizione prodotto:</label>
            <textarea id="mod-product-description" name="mod-product-description" required></textarea>';
            $paginaHTML = str_replace("<modForm/>", $formMod, $paginaHTML);

        */
        $modPr = new Prodotto(
            $_POST["product-name"],
            $_POST["product-description"],
            $_POST["product-image"],
            $_POST["product-image-alt"]
        );
        if ($modPr->__toString() != "") {
            $messaggioForm .=
                '<p class="serverStringError">I dati non sono inseriti correttamente:</p>' .
                $modPr;
        } else {
            $messaggioForm = $prodotto->update(
                $modPr->getTitolo(),
                $modPr->getDescrizione(),
                $modPr->getPath(),
                $modPr->getAlt()
            );
        }
    }

    if (isset($_POST["elimina"])) {
        $conn = new DBAccess();
        $checkConn = $conn->openConnection();
        if ($checkConn) {
            $product_name = $_POST["product-selector"];
            $checkDel = $conn->deleteProduct($product_name);
            $conn->closeConnection();
            if ($checkDel) {
                $messaggioForm =
                    '<p class="serverStringSuccess">Prodotto eliminato correttamente</p>';
            } else {
                $messaggioForm =
                    '<p class="serverStringError">Il prodotto non è stato eliminato correttamente</p>';
            }
        } else {
            $messaggioForm =
                '<p class="serverStringError">Il servizio non è al momento raggiungibile, ci scusiamo per il disagio.<p>';
        }
    }

    $conn = new DBAccess();
    $checkConn = $conn->openConnection();
    $result = "";
    if ($checkConn) {
        $products = $conn->getProducts();
        $conn->closeConnection();
        if ($products != null) {
            foreach ($products as $product) {
                $result .=
                    '<option value="' .
                    $product["id"] .
                    '"\>' .
                    $product["titolo"] .
                    "</option>";
            }
        } else {
            $result =
                '<p class="serverStringError">Nessun prodotto presente<p>';
        }
    } else {
        $result =
            '<p class="serverStringError">Il servizio non è al momento raggiungibile, ci scusiamo per il disagio.<p>';
    }
    $paginaHTML = str_replace("<listOfProducts />", $result, $paginaHTML);

    echo str_replace("<messaggioForm/>", $messaggioForm, $paginaHTML);
}
ob_end_flush();
?>
