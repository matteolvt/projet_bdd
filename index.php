<?php
session_start();
require_once 'db.php';

// Si pas connecté, on renvoie au login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// ON RÉCUPÈRE TOUTES LES TABLES
$users = $conn->query("SELECT * FROM user");
$defis = $conn->query("SELECT * FROM defi");
$commentaires = $conn->query("SELECT * FROM commentaire");
$dons = $conn->query("SELECT * FROM don");
$citations = $conn->query("SELECT * FROM citation");
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Super Admin Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f9;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            background: #2c3e50;
            color: white;
            padding: 20px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 4px;
            color: white;
            text-decoration: none;
            font-weight: bold;
            margin-left: 10px;
        }

        .btn-home {
            background: #3498db;
        }

        .btn-logout {
            background: #e74c3c;
        }

        .section {
            background: white;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        h2 {
            color: #2c3e50;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 0.9em;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        th {
            background: #f8f9fa;
            color: #555;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <h1>Dashboard de <?php echo htmlspecialchars($_SESSION['name']); ?></h1>
            <div>
                <a href="index.php" class="btn btn-home">Voir le site</a>
                <a href="logout.php" class="btn btn-logout">Déconnexion</a>
            </div>
        </div>

        <div class="section">
            <h2>👥 Utilisateurs (<?php echo $users->num_rows; ?>)</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                </tr>
                <?php while ($row = $users->fetch_assoc()): ?>
                    <tr>
                        <td>#<?php echo $row['user_id']; ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><strong><?php echo $row['role']; ?></strong></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>

        <div class="section">
            <h2>🌱 Défis (<?php echo $defis->num_rows; ?>)</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Statut</th>
                    <th>Description</th>
                </tr>
                <?php while ($row = $defis->fetch_assoc()): ?>
                    <tr>
                        <td>#<?php echo $row['defi_id']; ?></td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo $row['statut']; ?></td>
                        <td><?php echo substr(htmlspecialchars($row['description']), 0, 50); ?>...</td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>

        <div class="section">
            <h2>💬 Commentaires (<?php echo $commentaires->num_rows; ?>)</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Type</th>
                    <th>Statut</th>
                </tr>
                <?php while ($row = $commentaires->fetch_assoc()): ?>
                    <tr>
                        <td>#<?php echo $row['commentaire_id']; ?></td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo $row['type_commentaire']; ?></td>
                        <td><?php echo $row['statut']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>

        <div class="section">
            <h2>💰 Dons (<?php echo $dons->num_rows; ?>)</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Montant</th>
                    <th>Anonyme</th>
                </tr>
                <?php while ($row = $dons->fetch_assoc()): ?>
                    <tr>
                        <td>#<?php echo $row['don_id']; ?></td>
                        <td style="color:green; font-weight:bold;"><?php echo $row['montant']; ?> €</td>
                        <td><?php echo $row['anonyme'] ? 'Oui' : 'Non'; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>

        <div class="section">
            <h2>📖 Citations (<?php echo $citations->num_rows; ?>)</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Auteur</th>
                    <th>Texte</th>
                </tr>
                <?php while ($row = $citations->fetch_assoc()): ?>
                    <tr>
                        <td>#<?php echo $row['citation_id']; ?></td>
                        <td><?php echo htmlspecialchars($row['author']); ?></td>
                        <td>"<?php echo htmlspecialchars($row['text']); ?>"</td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>

    </div>

</body>

</html>