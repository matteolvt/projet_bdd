<?php
// On se connecte à la BDD
require_once 'db.php';

// On récupère les défis pour les afficher
$sql = "SELECT * FROM defi ORDER BY date_moderation DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Projet Écologique 🌱</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #27ae60;
        }

        .card {
            background: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .badge {
            background: #e67e22;
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.8em;
            font-weight: bold;
        }

        .date {
            color: #7f8c8d;
            font-size: 0.9em;
            float: right;
        }
    </style>
</head>

<body>

    <h1>🌱 Liste des Défis Écologiques</h1>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="card">
                <span class="date"><?php echo $row['date_moderation']; ?></span>
                <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                <p><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
                <span class="badge"><?php echo $row['statut']; ?></span>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="text-align: center;">Aucun défi trouvé dans la base de données.</p>
    <?php endif; ?>

</body>

</html>