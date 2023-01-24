<?php
use DB\DBAccess;
require_once("connection.php");

define("MAX_TITLE_LENGTH", 70);
define("MAX_DESCRIPTION_LENGTH", 250);

class Prodotto{
    private $titolo = "";
    private $descrizione = "";
    private $path_immagini = "";
    private $errore = "";

    function __construct($titolo, $descrizione, $path_immagini){
        $this->errore = $this->setTitle($titolo);
        $this->errore .= $this->setDescription($descrizione);
        $this->errore .= $this->setPath($path_immagini);

        $this->errore = $this->errore ? "<ul>$this->errore</ul>" : "";
    }

    private function setTitle($titolo){
        $err = "";
        (strlen($titolo) < MAX_TITLE_LENGTH) ? $this->titolo = $titolo : $err = "<li>Il titolo è troppo lungo</li>";
        return $err;
    }

    private function setDescription($desc){
        $err = "";
        (strlen($desc) < MAX_DESCRIPTION_LENGTH) ? $this->descrizione = $desc : $err = "<li>La descrizione è troppo lunga</li>";
        return $err;
    } 

    private function setPath($path){
        $err = "";
        (file_exists($path)) ? $this->path_immagini = $path : $err = "<li>Path della cartella indicata non esiste</li>";
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

    function save(){
        //connessione al DB
        $resultString = "";
        $dbAccess = new DBAccess();
        $connessioneRiuscita = $dbAccess->openConnection();
        if ($connessioneRiuscita == true) {
            $queryOK = $dbAccess->insertProduct($this->titolo, $this->descrizione, $this->path_immagini);
            $dbAccess->closeConnection();
            if ($queryOK == true) {
                $resultString  .= '<div class="alertSuccess" role="alert">Prodotto inserito correttamente</div> ';
            }
            else {
                $resultString .= '<div class="alertDanger" role="alert">I nostri sistemi sono al momento non funzionanti. Ci scusiamo per il disagio</div> ';
            }
        }
    }
}
?>