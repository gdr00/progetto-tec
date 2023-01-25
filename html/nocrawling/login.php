<?php
session_start();
use DB\DBAccess;
require_once("connection.php");

$dbAccess = new DBAccess();
$connessioneRiuscita = $dbAccess->openConnection();

// da mofiicare perchè non abbiamo una funzione per eseguire la query 

if ($connessioneRiuscita == true) {
    $queryOK = $dbAccess->insertProduct($this->titolo, $this->descrizione, $this->path_immagini, $this->alt_immagine);
    $dbAccess->closeConnection();
}

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

$query = "SELECT * FROM utenti WHERE username='$username' AND password='$password'";

$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if (mysqli_num_rows($result) > 0 && ) {
    $_SESSION['admin'] = true;
    header('Location: inserimentoProdotto.php');
} else {
    // l'utente non esiste
}

$_SESSION['user_id'] = $user['id'];
$_SESSION['username'] = $user['username'];

header("Location: inserimentoProdotti.html");
?>