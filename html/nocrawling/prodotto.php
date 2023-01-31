<?php
use DB\DBAccess;
require_once("connection.php");

define("MAX_TITLE_LENGTH", 70);
define("MAX_DESCRIPTION_LENGTH", 250);

class Prodotto{
    private $titolo = "";
    private $descrizione = "";
    private $path_immagini = "";
    private $alt_immagine = "";
    private $errore = "";

    function __construct($titolo, $descrizione, $path_immagini, $alt_immagine){
        $this->errore = $this->setTitle($titolo);
        $this->errore .= $this->setDescription($descrizione);
        $this->errore .= $this->setPath($path_immagini);
        $this->errore = $this->setAlt($alt_immagine);

        $this->errore = $this->errore ? '<ul class="erroreCreazioneProdotto">' . $this->errore . '</ul>' : "";
    }

    private function pulisciInput($value) {
        $value = trim($value); 
        $value = strip_tags($value); 
        $value = htmlentities($value); 
        return $value;
    }

    private function stringCorrectness($pattern, $string, $field_checked){
        if (!preg_match($pattern, $string))
            return "<li>Ci sono alcune caratteri non consentiti nel campo ".$field_checked."</li>";
        return "";
    }


    private function saveImageIntoServerDirectory($target_dir, $target_file){
        $result = "";
        if (!is_writable($target_dir))
            $result = '<li>La cartella non ha i permessi</li>';
            
        if (!move_uploaded_file($_FILES["product-image"]["tmp_name"], $target_file))
            $result .= '<li>Immagine non caricata correttamente</li>';
        return $result;
    }

    private function setTitle($titolo){
        $regex = '/^([a-z0-9]+|(\[[a-z]+\s*=\s*[a-z]+\]))(\s+[a-z0-9]+|\s+\[[a-z]+\s*=\s*[a-z]+\])*$/i';
        /*
        Il titolo può essere composto da:
        - lettere minuscole e maiuscole
        - numeri
        - spazi (non alla fine)
        - parentesi quadre con dentro una parola (es. [lingua=nome])
        */
        $err = $this->stringCorrectness($regex, $titolo, 'titolo prodotto');
        $titolo = $this->pulisciInput($titolo);
        if (strlen($titolo) > MAX_TITLE_LENGTH)
            $err .= "<li>Il titolo è troppo lungo</li>";
        if ($err == "")
            $this->titolo = preg_replace('/\s\s+/', ' ', $titolo);
        return $err;
    }

    private function setDescription($desc){
        $regex = '/^([a-z0-9]+|(\[[a-z]+\s*=\s*[a-z]+\]))((\s+|\s*)[a-z0-9]\.?+|\s+\[[a-z]+\s*=\s*[a-z]+\]\.?)*$/i';
        /*
        Il titolo può essere composto da:
        - lettere minuscole e maiuscole
        - numeri
        - spazi (non alla fine)
        - punti
        - parentesi quadre con dentro una parola (es. [lingua=nome])
        */
        $err = $this->stringCorrectness($regex, $desc, 'descrizione prodotto');
        $desc = $this->pulisciInput($desc);
        if (strlen($desc) > MAX_DESCRIPTION_LENGTH)
            $err .= "<li>La descrizione è troppo lunga</li>";
        if($err == "")
            $this->descrizione = preg_replace('/\s\s+/', ' ', $desc);
        return $err;
    } 

    private function setPath($file_name){
        // prende il nome del file immagine
        // percorso assoluto per la cartella uploads, da modificare se cambia la struttura delle directory
        $target_dir = realpath('../../php/uploads/'); 
        // $target_file => Contiene il percorso completo del file caricato (es. var/www/progetto-tec/php/uploads/immagine.jpg)
        $target_file = $target_dir . '/' . basename($file_name); //$_FILES["product-image"]["name"]);
        // target file e ilo nome del file completo di path assoluta
        // per il db metto solo la parent folder in quanto prodotti php e gia in ./php/
        $file_extension = pathinfo($target_file)['extension'];
        $err = "";
        if($file_extension == 'jpg' | $file_extension == 'png' | $file_extension == 'jpeg' | $file_extension == 'svg'){
            $this->path_immagini = basename($target_dir) . '/' . basename($file_name); //$_FILES["product-image"]["name"]);
            $err = $this->saveImageIntoServerDirectory($target_dir, $target_file);
        }
        else
            $err .= "<li>Il file caricato non è un'immagine (estensioni concesse: jpg, png, jpeg, svg)</li>";
        return $err;
    }

    private function setAlt($alt){
        $regex = '/^[a-z0-9]+(\s+[a-z0-9]+\.?|\.[a-z0-9]+)*$/i';
        /*
        Alt immagine può essere composto da:
        - lettere minuscole e maiuscole
        - numeri
        - spazi (non alla fine)
        - punti
        */
        $err = $this->stringCorrectness($regex, $alt, 'alt immagine');
        $alt = $this->pulisciInput($alt);
        if($err == "")
            $this->alt_immagine = preg_replace('/\s\s+/', ' ', $alt);
        return $err;
    }

    public function __toString(){
        return $this->errore;
    }

    public function getTitolo(){
        return $this->titolo;
    }

    public function getDescrizione(){
        return $this->descrizione;
    }

    public function getPath(){
        return $this->path_immagini;
    }

    public function getAlt(){
        return $this->alt_immagine;
    }

    public function save(){
        $resultString = "";
        $dbAccess = new DBAccess();
        $connessioneRiuscita = $dbAccess->openConnection();
        if ($connessioneRiuscita == true) {
            $queryOK = $dbAccess->insertProduct($this->titolo, $this->descrizione, $this->path_immagini, $this->alt_immagine);
            $dbAccess->closeConnection();
            if ($queryOK == true) {
                $resultString = '<p class="serverStringSuccess" role="alert">Prodotto inserito correttamente</p> ';
            }
            else {
                $resultString = '<p class="serverStringError" role="alert">I nostri sistemi sono al momento non funzionanti. Ci scusiamo per il disagio.</p> ';
            }
        }
        else
            $resultString = '<p class="serverStringError" role="alert">I nostri sistemi sono al momento non funzionanti. Ci scusiamo per il disagio.</p>';
        return $resultString;
    }
}
?>