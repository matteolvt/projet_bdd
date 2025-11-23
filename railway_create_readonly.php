<?php
require_once 'db.php';

echo "--- AJOUT DE L'UTILISATEUR PROFESSEUR AU SITE ---\n";

$name = "Frédéric";
$surname = "Le Goat";
$email = "frederic@prof.com";
$raw_password = "ProjetBdd2025!";


$hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);


$sql = "INSERT INTO user (role, name, surname, email, password) 
        VALUES ('admin', '$name', '$surname', '$email', '$hashed_password')";

if ($conn->query($sql) === TRUE) {
    echo "✅ Utilisateur SITE WEB créé avec succès !\n";
    echo "--------------------------------------\n";
    echo "Voici les identifiants à donner au prof pour le LOGIN DU SITE :\n";
    echo "Email : $email\n";
    echo "Mdp   : $raw_password\n";
} else {
    echo "❌ Erreur : " . $conn->error . "\n";
    echo "(Si l'erreur est 'Duplicate entry', c'est qu'il existe déjà, c'est bon !)\n";
}
?>