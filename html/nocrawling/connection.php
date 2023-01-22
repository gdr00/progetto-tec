<?php
$servername = "localhost";
$username = "tecweb";
$password = "eDD&%5+QrPr4?A-";
$dbname = "tecweb";

// Crea la connessione
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Controlla la connessione
if (!$conn)
    die("Connessione fallita: " . mysqli_connect_error());
echo "Connessione riuscita";
