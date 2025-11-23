<?php
$servername = "shuttle.proxy.rlwy.net";
$username = "root";
$password = "REQILbyvwnmknGejvfFbFtooKVwxlFbd";
$dbname = "railway";
$port = 57953;

// Connexion
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Gestion des accents (UTF-8)
$conn->set_charset("utf8mb4");

// Vérification
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>