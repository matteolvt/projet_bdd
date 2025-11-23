<?php
$servername = "127.0.0.1";
$username = "root";
$password = "root";
$dbname = "projet_final_bdd";
$port = 8889;

// Connexion
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Gestion des accents (UTF-8)
$conn->set_charset("utf8mb4");

// Vérification
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>