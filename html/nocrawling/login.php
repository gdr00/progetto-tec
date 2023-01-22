crea login .php
<?php
session_start();
require 'connection.php';

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

$query = "SELECT * FROM utenti WHERE username='$username' AND password='$password'";

$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if (mysqli_num_rows($result) > 0) {
    // l'utente esiste
} else {
    // l'utente non esiste
}

$_SESSION['user_id'] = $user['id'];
$_SESSION['username'] = $user['username'];

header("Location: inserimentoProdotti.html");
?>