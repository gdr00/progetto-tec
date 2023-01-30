<?php
session_start();
use DB\DBAccess;
require_once("connection.php");

if (!isset($_SESSION["username"])){
    header("Location: login.html");
    exit;
}

?>