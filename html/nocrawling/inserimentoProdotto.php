<?php
ob_start();
if (session_status() == PHP_SESSION_NONE) {
    // inizializza la sessione
    session_start();
  }

use DB\DBAccess;
require_once "connection.php";
require_once "prodotto.php";

if ($_SESSION["admin"] == false) {
    header("Location: login.php");
} else {
    $paginaHTML = file_get_contents("inserimentoProdotto.html");

    $messaggioForm = "";

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
                : '<p class="serverStringError" role="alert">I dati non sono stati inseriti correttamente:' .
                    $prodotto .
                    '</p>';
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
                    '<p class="serverStringSuccess" role="alert">Prodotto eliminato correttamente</p>';
            } else {
                $messaggioForm =
                    '<p class="serverStringError" role="alert">Il prodotto non è stato eliminato correttamente</p>';
            }
        } else {
            $messaggioForm =
                '<p class="serverStringError" role="alert">Il servizio non è al momento raggiungibile, ci scusiamo per il disagio.<p>';
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
                
                /*
                $result .= '<option value="' . $product["id"] . '"\>';
                $pos = strpos("=", $product["titolo"]);
                if ($pos) {
                    $nuovoTitolo = $product["titolo"];
                    $start = strpos("[", $nuovoTitolo); // trova la posizione del carattere di apertura
                    $end = strpos("=",$nuovoTitolo); // trova la posizione del carattere di chiusura
                    substr_replace($nuovoTitolo, '', $start, $end);
                    str_replace("]", " ", $product["titolo"]); // rimuove il carattere di chiusura e metto uno spazio
                } else {
                    $result .= $product["titolo"] . "</option>";
                }*/
            }
        } else {
            $result =
                '<p class="serverStringError" role="alert">Nessun prodotto presente<p>';
        }
    } else {
        $result =
            '<p class="serverStringError" role="alert">Il servizio non è al momento raggiungibile, ci scusiamo per il disagio.<p>';
    }
    $paginaHTML = str_replace("<listOfProducts />", $result, $paginaHTML);

    echo str_replace("<messaggioForm />", $messaggioForm, $paginaHTML);
}
ob_end_flush();
?>
