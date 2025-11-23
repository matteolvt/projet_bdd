<?php
// On inclut le fichier de connexion qu'on vient de créer
require_once 'db.php';

echo "--- Début de l'insertion des données ---\n";

// CRÉATION DES UTILISATEURS
$mdp_admin = password_hash("admin123", PASSWORD_DEFAULT);
$mdp_client = password_hash("client123", PASSWORD_DEFAULT);

// Admin
$sql = "INSERT INTO user (role, name, surname, email, password) 
        VALUES ('admin', 'Dupont', 'Jean', 'admin@test.com', '$mdp_admin')";
$conn->query($sql);
$admin_id = $conn->insert_id; // On récupère l'ID (ex: 1)
echo "Admin créé avec succès.\n";

// Client
$sql = "INSERT INTO user (role, name, surname, email, password) 
        VALUES ('client', 'Martin', 'Sophie', 'sophie@test.com', '$mdp_client')";
$conn->query($sql);
$client_id = $conn->insert_id; // On récupère l'ID (ex: 2)
echo "Client créé avec succès.\n";


// CRÉATION D'UN COMMENTAIRE ET D'UN DÉFI LIÉ
$sql = "INSERT INTO commentaire (title, text, date, statut, type_commentaire, user_id, defi_id) 
        VALUES ('Trop de plastique', 'Il faut réduire le plastique à la cantine.', NOW(), 'poste', 'experience', $client_id, NULL)";
$conn->query($sql);
$com_id = $conn->insert_id;
echo "Commentaire créé.\n";

// On crée le défi en le liant au commentaire
$sql = "INSERT INTO defi (title, description, statut, user_id, commentaire_id) 
        VALUES ('Zéro Plastique', 'Remplacer les gobelets par du verre.', 'realisable', $admin_id, $com_id)";
$conn->query($sql);
$defi_id = $conn->insert_id;
echo "Défi créé.\n";

// On met à jour le commentaire pour dire quel défi il a généré
$sql = "UPDATE commentaire SET defi_id = $defi_id WHERE commentaire_id = $com_id";
$conn->query($sql);
echo "Lien Commentaire <-> Défi mis à jour.\n";


// Don
$sql = "INSERT INTO don (montant, anonyme, user_id) VALUES (50.0, 0, $client_id)";
$conn->query($sql);
echo "Don ajouté.\n";

// Citation
$sql = "INSERT INTO citation (title, text, author, date_ajout, user_id) 
        VALUES ('Nature', 'La nature ne fait rien en vain.', 'Aristote', NOW(), $admin_id)";
$conn->query($sql);
echo "Citation ajoutée.\n";

echo "--- TOUT EST FINI ! ---\n";
?>