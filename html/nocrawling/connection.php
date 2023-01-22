<?php
$servername = "localhost";
$username = "your_username";
$password = "eDD&%5+QrPr4?A-";
$dbname = "tecweb";

// Crea la connessione
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Controlla la connessione
if (!$conn)
    die("Connection failed: " . mysqli_connect_error());
echo "Connected successfully";
