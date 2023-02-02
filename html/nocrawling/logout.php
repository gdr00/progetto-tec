<?php
if (session_status() == PHP_SESSION_NONE) {
    // inizializza la sessione
    unset($_SESSION);
    session_destroy();
    header('Location: login.php');
  }

?>