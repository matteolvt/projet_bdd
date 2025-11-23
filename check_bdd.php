<?php
require_once 'db.php'; // On utilise ta connexion

echo "\n====== VÉRIFICATION DE LA BDD ======\n";

// 1. On vérifie les UTILISATEURS
echo "\n--- LISTE DES USERS ---\n";
$sql = "SELECT user_id, role, name, email FROM user";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "[ID: " . $row["user_id"] . "] - " . $row["name"] . " (" . $row["role"] . ") - " . $row["email"] . "\n";
    }
} else {
    echo "0 users trouvés (Bizarre !)\n";
}

// 2. On vérifie les COMMENTAIRES
echo "\n--- LISTE DES COMMENTAIRES ---\n";
$sql = "SELECT commentaire_id, title, defi_id FROM commentaire";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "[ID: " . $row["commentaire_id"] . "] Titre: " . $row["title"] . " ---> Lié au Défi ID: " . ($row["defi_id"] ? $row["defi_id"] : "AUCUN") . "\n";
    }
} else {
    echo "0 commentaires trouvés.\n";
}

// 3. On vérifie les DÉFIS
echo "\n--- LISTE DES DÉFIS ---\n";
$sql = "SELECT defi_id, title FROM defi";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "[ID: " . $row["defi_id"] . "] Titre: " . $row["title"] . "\n";
    }
} else {
    echo "0 défis trouvés.\n";
}

echo "\n====================================\n";
?>