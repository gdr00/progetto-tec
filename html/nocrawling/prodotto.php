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
        $this->alt_immagine = $this->setAlt($alt_immagine);

        $this->errore = $this->errore ? "<ul>$this->errore</ul>" : "";
    }

    private function pulisciInput($value) {
        $value = trim($value); 
        $value = strip_tags($value); 
        $value = htmlentities($value); 
        return $value;
    }

    private function saveImageIntoServerDirectory($target_dir, $target_file){
        $result = "";
        chmod('upload',777);
        if (!is_writable($target_dir))
            $result = '<li>La cartella non ha i permessi</li>';
            
        if (move_uploaded_file($_FILES["product-image"]["tmp_name"], $target_file))
            $result .= '<li>Immagine caricata correttamente</li>';
        else
            $result .= '<li>Immagine non caricata correttamente</li>';
        return $result;
    }

    private function setTitle($titolo){
        $err = "";
        (strlen($titolo) < MAX_TITLE_LENGTH) ? $this->titolo = $this->pulisciInput($titolo) : $err = "<li>Il titolo è troppo lungo</li>";
        return $err;
    }

    private function setDescription($desc){
        $err = "";
        (strlen($desc) < MAX_DESCRIPTION_LENGTH) ? $this->descrizione = $this->pulisciInput($desc) : $err = "<li>La descrizione è troppo lunga</li>";
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
        $this->path_immagini = basename($target_dir) . '/' . basename($file_name); //$_FILES["product-image"]["name"]);
        $err = $this->saveImageIntoServerDirectory($target_dir, $target_file);
        return $err;
    }

    private function setAlt($alt){
        $this->alt_immagine = $this->pulisciInput($alt);
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
                $resultString = '<div class="alertSuccess" role="alert">Prodotto inserito correttamente</div> ';
            }
            else {
                $resultString = '<div class="alertDanger" role="alert">I nostri sistemi sono al momento non funzionanti. Ci scusiamo per il disagio</div> ';
            }
        }
        else
            $resultString = '<p>Errore di connessione al database</p>';
        return $resultString;
    }

    //PRE: i parametri passati sono gia stati controllati
    public function update($title, $desc, $imm, $alt_imm){
        $resultString = "";
        $dbAccess = new DBAccess();
        $connessioneRiuscita = $dbAccess->openConnection();
        if ($connessioneRiuscita == true) {
            $queryOK = $dbAccess->updateProduct($this->titolo, $title, $desc, $imm, $alt_imm);
            $dbAccess->closeConnection();
            if ($queryOK == true) {
                $resultString = '<div class="alertSuccess" role="alert">Prodotto modificato correttamente</div> ';
            }
            else {
                $resultString = '<div class="alertDanger" role="alert">I nostri sistemi sono al momento non funzionanti. Ci scusiamo per il disagio</div> ';
            }
        }
        else
            $resultString = '<p>Errore di connessione al database</p>';
        return $resultString;  
    }
}
?>