<?php
require 'connection.php';

// Prende i dati dalla form
$product_name = $_POST['product-name'];
$product_description = $_POST['product-description'];

// Carica l'immagine nella cartella del server
$target_dir = "uploads/";

// $target_file => Contiene il percorso completo del file caricato (es. uploads/immagine.jpg)
// basename() => Restituisce il nome del file (es. immagine.jpg) senza il percorso
// $_FILES["product-image"]["name"] => per recuperare il nome del file immagine caricato.
// ["name"] => è un indice dell'array associativo $_FILES in PHP. $_FILES è una variabile globale che contiene informazioni sui file caricati tramite un modulo HTML
$target_file = $target_dir . basename($_FILES["product-image"]["name"]);
// move_uploaded_file => l'immagine caricata dalla cartella temporanea del server alla cartella "uploads" creata prima. La funzione prende come parametri la variabile $_FILES["product-image"]["tmp_name"] 
//  che rappresenta il percorso del file temporaneo sul server e la variabile $target_file che rappresenta il percorso della cartella uploads.
move_uploaded_file($_FILES["product-image"]["tmp_name"], $target_file);

// Insert the data into the database
$sql = "INSERT INTO products (name, description, image) VALUES ('$product_name', '$product_description', '$target_file')";

if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
