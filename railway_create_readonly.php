<?php
require_once 'db.php';

echo "--- CRÉATION DU COMPTE (READ ONLY) ---\n";


$prof_user = "frédéric";
$prof_pass = "ProjetBdd2025!";

$sql = "CREATE USER IF NOT EXISTS '$prof_user'@'%' IDENTIFIED BY '$prof_pass'";

if ($conn->query($sql) === TRUE) {
    echo "✅ Utilisateur '$prof_user' créé avec succès.\n";
} else {

    echo "ℹ️ Info création : " . $conn->error . "\n";
}

$sql = "GRANT SELECT ON railway.* TO '$prof_user'@'%'";

if ($conn->query($sql) === TRUE) {
    echo "✅ Droits LECTURE SEULE (SELECT) accordés.\n";
} else {
    echo "❌ Erreur droits : " . $conn->error . "\n";
}

$conn->query("FLUSH PRIVILEGES");

echo "--- TERMINÉ ! ---\n";
echo "Voici les identifiants pour ton prof :\n";
echo "User : $prof_user\n";
echo "Pass : $prof_pass\n";
?>