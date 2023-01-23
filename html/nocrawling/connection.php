<?php
namespace DB;
use mysqli;
class DBAccess {
    private const HOST_DB = "localhost";
    private const DATABASE_NAME = "tecweb";
    private const USERNAME = "tecweb";
    private const PASSWORD = "eDD&%5+QrPr4?A-";
    private $connection;

    public function openConnection(){
        $this->connection = mysqli_connect(DBAccess::HOST_DB, DBAccess::USERNAME, DBAccess::PASSWORD, DBAccess::DATABASE_NAME);
        if(mysqli_connect_errno()){
            return false;
        }
        else{
            return true;
        }
    }

    public function closeConnection(){
        if($this->connection != null){
            $this->connection->close();
        }
    }

    public function getProducts(){
        $query = "SELECT * FROM prodotto ORDER BY nome ASC";
        $queryResult=mysqli_query($this->connection, $query) or die("Errore in openDBConnection: ".mysqli_error($this->connection));
        if (mysqli_num_rows($queryResult) == 0){
            return null;
        } else{
            $result = array();
            while($row = mysqli_fetch_assoc($queryResult)){
                array_push($result, $row);
            }
            $queryResult->free();
            return $result;
        }
    }
    
    public function insertProduct ($nome, $descrizione, $immagine){
        $query = "INSERT INTO prodotto (nome, descrizione, immagine) VALUES(\"$nome\", \"$descrizione\", \"$immagine\")";
        $queryResult = mysqli_query($this->connection, $query) or die ("Errore in openDBConnection: ".mysqli_error($this->connection));
        
        if(mysqli_affected_rows($this->connection) > 0){
            return true;
        } else{
            return false;
        }
    }

    public function deletePlayer($nome){
        $query = "DELETE FROM products WHERE ID = $nome";
        $queryResult=mysqli_query($this->connection, $query) or die("Errore in openDBConnection: ".mysqli_error($this->connection));
        if(mysqli_affected_rows($this->connection) > 0) {
            return true;
        } else{
            return false;
        }
    }
}

?>
