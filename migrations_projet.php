<?php
// INFO : Identifiants Railway
$servername = "shuttle.proxy.rlwy.net";
$username = "root";
$password = "REQILbyvwnmknGejvfFbFtooKVwxlFbd";
$dbname = "railway";
$port = 57953;

// Connexion
$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

echo "--- DÉBUT DE LA MIGRATION SUR RAILWAY ---<br>";

// ---------------------------------------------------------
// 1. GRAND NETTOYAGE (RESET)
// ---------------------------------------------------------
// On désactive la vérification des clés étrangères pour pouvoir supprimer sans ordre précis
$conn->query('SET FOREIGN_KEY_CHECKS = 0');

// On supprime toutes les tables si elles existent déjà
$tables = ['defi_proposition', 'citation', 'don', 'defi', 'commentaire', 'user'];

foreach ($tables as $table) {
    $sql = "DROP TABLE IF EXISTS $table";
    if ($conn->query($sql) === TRUE) {
        echo "Table ancienne '$table' supprimée (si elle existait)<br>";
    } else {
        echo "Erreur suppression $table : " . $conn->error . "<br>";
    }
}

// On réactive la sécurité des clés étrangères pour la suite
$conn->query('SET FOREIGN_KEY_CHECKS = 1');

echo "-------------------------------------------<br>";


// ---------------------------------------------------------
// 2. CRÉATION DES TABLES (STRUCTURE NEUVE)
// ---------------------------------------------------------

// Table User
$sql = "CREATE TABLE user (
user_id INT auto_increment PRIMARY KEY not null,
role ENUM('admin', 'client') not null,
name VARCHAR(100) not null,
surname VARCHAR(100) not null,
email VARCHAR(255) not null unique,
password VARCHAR(255) not null,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "✅ Table user created successfully<br>";
} else {
    echo "❌ Error creating table user: " . $conn->error . "<br>";
}

// Table Commentaire
$sql = "CREATE TABLE commentaire (
commentaire_id INT auto_increment PRIMARY KEY not null,
title VARCHAR(100) not null,
text TEXT not null,
date datetime not null,
statut ENUM('en_attente', 'en_verification', 'poste') not null,
type_commentaire ENUM('experience', 'aide') not null,
date_moderation datetime,
user_id INT not null,
defi_id INT,
FOREIGN KEY (user_id) REFERENCES user(user_id)
)";

if ($conn->query($sql) === TRUE) {
    echo "✅ Table commentaire created successfully<br>";
} else {
    echo "❌ Error creating table commentaire: " . $conn->error . "<br>";
}

// Table Defi
$sql = "CREATE TABLE defi (
defi_id INT auto_increment PRIMARY KEY not null,
title VARCHAR(100) not null,
description TEXT not null,
statut ENUM('realisable', 'realise') not null,
date_moderation datetime,
user_id INT not null,
commentaire_id INT not null,
FOREIGN KEY (user_id) REFERENCES user(user_id),
FOREIGN KEY (commentaire_id) REFERENCES commentaire(commentaire_id)
)";

if ($conn->query($sql) === TRUE) {
    echo "✅ Table defi created successfully<br>";
} else {
    echo "❌ Error creating table defi: " . $conn->error . "<br>";
}

// Ajout Foreign Key pour la table Commentaire
$sql = "ALTER TABLE commentaire 
        ADD CONSTRAINT fk_commentaire_defi 
        FOREIGN KEY (defi_id) REFERENCES defi(defi_id)";

if ($conn->query($sql) === TRUE) {
    echo "✅ Foreign Key added to commentaire successfully<br>";
} else {
    echo "❌ Error adding FK: " . $conn->error . "<br>";
}

// Table Defi_Proposition
$sql = "CREATE TABLE defi_proposition (
defi_proposition_id INT auto_increment PRIMARY KEY not null,
defi_id INT not null,
user_id INT not null,
FOREIGN KEY (defi_id) REFERENCES defi(defi_id),
FOREIGN KEY (user_id) REFERENCES user(user_id)
)";

if ($conn->query($sql) === TRUE) {
    echo "✅ Table defi_proposition created successfully<br>";
} else {
    echo "❌ Error creating table: " . $conn->error . "<br>";
}


// Table Don
$sql = "CREATE TABLE don (
don_id INT auto_increment PRIMARY KEY not null,
montant FLOAT not null,
anonyme BOOLEAN not null,
user_id INT not null,
FOREIGN KEY (user_id) REFERENCES user(user_id)
)";

if ($conn->query($sql) === TRUE) {
    echo "✅ Table don created successfully<br>";
} else {
    echo "❌ Error creating table: " . $conn->error . "<br>";
}

// Table Citation
$sql = "CREATE TABLE citation (
citation_id INT auto_increment PRIMARY KEY not null,
title VARCHAR(100) not null,
text TEXT not null,
author VARCHAR(100) not null,
date_ajout datetime not null,
user_id INT not null,
FOREIGN KEY (user_id) REFERENCES user(user_id)
)";

if ($conn->query($sql) === TRUE) {
    echo "✅ Table citation created successfully<br>";
} else {
    echo "❌ Error creating table: " . $conn->error . "<br>";
}

echo "<br>--- MIGRATION TERMINÉE ---";
?>