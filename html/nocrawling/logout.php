<?php
if (session_status() == PHP_SESSION_NONE) {
    // inizializza la sessione
    session_start();
    unset($_SESSION);
    session_destroy();
    header('Location: login.php');
  }

?>