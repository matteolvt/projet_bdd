<?php
session_start();
require_once 'db.php';

// SÉCURITÉ : Si pas connecté, on renvoie au login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// 1. Récupérer les USERS
$users = $conn->query("SELECT * FROM user");

// 2. Récupérer les DÉFIS
$defis = $conn->query("SELECT * FROM defi");

// 3. Récupérer les COMMENTAIRES
$commentaires = $conn->query("SELECT * FROM commentaire");

// 4. Récupérer les DONS
$dons = $conn->query("SELECT * FROM don");

// 5. Récupérer les CITATIONS
$citations = $conn->query("SELECT * FROM citation");
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Super Dashboard Admin</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f9;
            padding: 20px;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* En-tête */
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

        .header h1 {
            margin: 0;
            font-size: 1.5em;
        }

        .user-role {
            background: #f39c12;
            color: white;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.6em;
            vertical-align: middle;
        }

        .btn {
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 4px;
            color: white;
            font-weight: bold;
            margin-left: 10px;
            transition: opacity 0.3s;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .btn-home {
            background: #3498db;
        }

        .btn-logout {
            background: #e74c3c;
        }

        /* Sections (Tables) */
        .section {
            background: white;
            padding: 25px;
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        h2 {
            color: #2c3e50;
            border-bottom: 2px solid #ecf0f1;
            padding-bottom: 15px;
            margin-top: 0;
            display: flex;
            align-items: center;
        }

        .count {
            background: #ecf0f1;
            color: #7f8c8d;
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 0.6em;
            margin-left: 10px;
        }

        /* Tableaux */
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
            color: #7f8c8d;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8em;
        }

        tr:hover {
            background: #f1f2f6;
        }

        /* Petits badges pour les statuts */
        .badge {
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.85em;
            font-weight: bold;
        }

        .status-ok {
            color: #27ae60;
            background: #e8f8f5;
        }

        .status-wait {
            color: #e67e22;
            background: #fef5e7;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <div>
                <h1>Dashboard de <?php echo htmlspecialchars($_SESSION['name']); ?> <span
                        class="user-role"><?php echo strtoupper($_SESSION['role']); ?></span></h1>
            </div>
            <div>
                <a href="index.php" class="btn btn-home">Voir le site</a>
                <a href="logout.php" class="btn btn-logout">Déconnexion</a>
            </div>
        </div>

        <div class="section">
            <h2>👥 Utilisateurs <span class="count"><?php echo $users->num_rows; ?></span></h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Date Création</th>
                </tr>
                <?php while ($row = $users->fetch_assoc()): ?>
                    <tr>
                        <td>#<?php echo $row['user_id']; ?></td>
                        <td><?php echo htmlspecialchars($row['name'] . ' ' . $row['surname']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><strong><?php echo $row['role']; ?></strong></td>
                        <td><?php echo $row['created_at']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>

        <div class="section">
            <h2>🌱 Défis <span class="count"><?php echo $defis->num_rows; ?></span></h2>
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
                        <td><strong><?php echo htmlspecialchars($row['title']); ?></strong></td>
                        <td><span class="badge status-ok"><?php echo $row['statut']; ?></span></td>
                        <td><?php echo substr(htmlspecialchars($row['description']), 0, 80) . '...'; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>

        <div class="section">
            <h2>💬 Commentaires <span class="count"><?php echo $commentaires->num_rows; ?></span></h2>
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
                        <td><span class="badge status-wait"><?php echo $row['statut']; ?></span></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>

        <div class="section">
            <h2>💰 Dons <span class="count"><?php echo $dons->num_rows; ?></span></h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Montant</th>
                    <th>Anonyme</th>
                    <th>User ID</th>
                </tr>
                <?php while ($row = $dons->fetch_assoc()): ?>
                    <tr>
                        <td>#<?php echo $row['don_id']; ?></td>
                        <td style="color: #27ae60; font-weight: bold;"><?php echo $row['montant']; ?> €</td>
                        <td><?php echo $row['anonyme'] ? 'Oui' : 'Non'; ?></td>
                        <td>User #<?php echo $row['user_id']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>

        <div class="section">
            <h2>📖 Citations <span class="count"><?php echo $citations->num_rows; ?></span></h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Auteur</th>
                    <th>Texte</th>
                </tr>
                <?php while ($row = $citations->fetch_assoc()): ?>
                    <tr>
                        <td>#<?php echo $row['citation_id']; ?></td>
                        <td><strong><?php echo htmlspecialchars($row['author']); ?></strong></td>
                        <td><em>"<?php echo htmlspecialchars($row['text']); ?>"</em></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>

    </div>

</body>

</html>