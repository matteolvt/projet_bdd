<?php
// 1. On démarre la session (OBLIGATOIRE pour vérifier le login)
session_start();

// 2. On inclut la connexion à la base de données
require_once 'db.php';

// 3. On récupère la liste des défis (du plus récent au plus vieux)
$sql = "SELECT * FROM defi ORDER BY date_moderation DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoProject - Accueil</title>
    <style>
        /* --- STYLE GÉNÉRAL --- */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* --- NAVBAR (Barre de navigation) --- */
        .navbar {
            background: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .logo {
            font-size: 1.5em;
            font-weight: bold;
            color: #27ae60;
            text-decoration: none;
        }

        .nav-links a {
            text-decoration: none;
            color: #555;
            margin-left: 20px;
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: #27ae60;
        }

        .btn-login {
            background-color: #27ae60;
            color: white !important;
            padding: 8px 15px;
            border-radius: 5px;
        }

        .btn-logout {
            color: #e74c3c !important;
        }

        /* --- CONTENU (Cartes Défis) --- */
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 20px;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            padding: 25px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-3px);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .card h2 {
            margin-top: 0;
            color: #2c3e50;
        }

        .description {
            line-height: 1.6;
            color: #555;
        }

        .badge {
            background: #f1c40f;
            color: #fff;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8em;
            font-weight: bold;
            text-transform: uppercase;
        }

        .badge.realise {
            background: #27ae60;
        }

        /* Vert si réalisé */
        .badge.realisable {
            background: #3498db;
        }

        /* Bleu si réalisable */

        .date {
            font-size: 0.85em;
            color: #95a5a6;
            margin-top: 10px;
            display: block;
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <a href="index.php" class="logo">🌱 EcoProject</a>
        <div class="nav-links">
            <?php if (isset($_SESSION['user_id'])): ?>
                <span>Bonjour, <strong><?php echo htmlspecialchars($_SESSION['name']); ?></strong></span>
                <a href="admin.php">Mon Dashboard</a>
                <a href="logout.php" class="btn-logout">Se déconnecter</a>
            <?php else: ?>
                <a href="login.php" class="btn-login">Se connecter</a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="container">
        <h1>Les derniers défis de la communauté</h1>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="card">
                    <div class="card-header">
                        <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                        <span class="badge <?php echo $row['statut']; ?>">
                            <?php echo htmlspecialchars($row['statut']); ?>
                        </span>
                    </div>

                    <p class="description">
                        <?php echo nl2br(htmlspecialchars($row['description'])); ?>
                    </p>

                    <span class="date">
                        Modéré le : <?php echo date("d/m/Y H:i", strtotime($row['date_moderation'])); ?>
                    </span>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align: center; color: #777;">Aucun défi n'a encore été posté. Soyez le premier !</p>
        <?php endif; ?>
    </div>

</body>

</html>