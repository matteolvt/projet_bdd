<?php
$servername = "127.0.0.1";
$username = "root";
$password = "root";
$dbname = "projet_final_bdd";
$port = 8889;

// Create connection
$conn = new mysqli($servername, $username, $password, "", $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully or already exists<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
    die();
}

$conn->select_db($dbname);

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
    echo "Table user created successfully";
} else {
    echo "Error creating table: " . $conn->error;
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
    echo "Table commentaire created successfully";
} else {
    echo "Error creating table: " . $conn->error;
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
    echo "Table defi created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

// Ajout Foreign Key pour la table Commentaire
$sql = "ALTER TABLE commentaire 
        ADD CONSTRAINT fk_commentaire_defi 
        FOREIGN KEY (defi_id) REFERENCES defi(defi_id)";

if ($conn->query($sql) === TRUE) {
    echo "Foreign Key added to commentaire successfully<br>";
} else {
    echo "Error adding FK: " . $conn->error . "<br>";
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
    echo "Table defi_proposition created successfully";
} else {
    echo "Error creating table: " . $conn->error;
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
    echo "Table don created successfully";
} else {
    echo "Error creating table: " . $conn->error;
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
    echo "Table citation created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

?>