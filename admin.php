<?php
session_start();
require_once 'db.php';

// --- SÉCURITÉ ---
// Si l'utilisateur n'a pas d'ID en session, il n'est pas connecté.
// On le renvoie direct sur la page de login.
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// On récupère la liste des utilisateurs pour montrer qu'on a accès à la BDD
$sql = "SELECT user_id, name, surname, email, role, created_at FROM user";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        /* En-tête */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
        }

        .user-info h1 {
            margin: 0;
            font-size: 1.5em;
            color: #2c3e50;
        }

        .user-info small {
            color: #7f8c8d;
        }

        /* Boutons */
        .btn {
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 5px;
            font-weight: 500;
            font-size: 0.9em;
            margin-left: 10px;
        }

        .btn-home {
            background-color: #3498db;
            color: white;
        }

        .btn-logout {
            background-color: #e74c3c;
            color: white;
        }

        /* Tableau */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #f1f2f6;
            color: #57606f;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85em;
        }

        tr:hover {
            background-color: #f8f9fa;
        }

        .role-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8em;
            font-weight: bold;
        }

        .role-admin {
            background-color: #e1b12c;
            color: #fff;
        }

        .role-client {
            background-color: #a4b0be;
            color: #fff;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <div class="user-info">
                <h1>Bonjour, <?php echo htmlspecialchars($_SESSION['name']); ?> 👋</h1>
                <small>Connecté en tant que : <strong><?php echo strtoupper($_SESSION['role']); ?></strong></small>
            </div>
            <div>
                <a href="index.php" class="btn btn-home">Voir le site</a>
                <a href="logout.php" class="btn btn-logout">Déconnexion</a>
            </div>
        </div>

        <h3>👥 Gestion des Utilisateurs (Accès BDD)</h3>
        <p>Voici la liste de tous les inscrits sur la plateforme :</p>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom & Prénom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Date d'inscription</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>#<?php echo $row['user_id']; ?></td>
                        <td>
                            <strong><?php echo htmlspecialchars($row['name']); ?></strong>
                            <?php echo htmlspecialchars($row['surname']); ?>
                        </td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td>
                            <span
                                class="role-badge <?php echo ($row['role'] == 'admin') ? 'role-admin' : 'role-client'; ?>">
                                <?php echo $row['role']; ?>
                            </span>
                        </td>
                        <td><?php echo date("d/m/Y", strtotime($row['created_at'])); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</body>

</html>