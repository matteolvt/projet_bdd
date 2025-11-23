<?php
// 1. On démarre la session (Toujours en premier !)
session_start();
require_once 'db.php';

$message = "";

// 2. Si le formulaire a été soumis (méthode POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 3. On prépare la requête SQL (Sécurité anti-injection)
    $stmt = $conn->prepare("SELECT user_id, name, surname, password, role FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // 4. On regarde si l'email existe
    if ($row = $result->fetch_assoc()) {
        // 5. On vérifie le mot de passe hashé
        if (password_verify($password, $row['password'])) {
            // ✅ SUCCÈS : On remplit la session
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['role'] = $row['role'];

            // On redirige vers le tableau de bord
            header("Location: admin.php");
            exit();
        } else {
            $message = "❌ Mot de passe incorrect.";
        }
    } else {
        $message = "❌ Aucun compte trouvé avec cet email.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - EcoProject</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #ecf0f1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-card {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 350px;
            text-align: center;
        }

        h2 {
            color: #2c3e50;
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #27ae60;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background-color: #219150;
        }

        .error-msg {
            background-color: #fadbd8;
            color: #c0392b;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 0.9em;
        }

        .back-link {
            display: block;
            margin-top: 20px;
            color: #7f8c8d;
            text-decoration: none;
            font-size: 0.9em;
        }

        .back-link:hover {
            color: #27ae60;
        }
    </style>
</head>

<body>

    <div class="login-card">
        <h2>🔐 Connexion</h2>

        <?php if (!empty($message)): ?>
            <div class="error-msg"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="email" name="email" placeholder="Votre Email" required>
            <input type="password" name="password" placeholder="Votre Mot de passe" required>
            <button type="submit">Se connecter</button>
        </form>

        <a href="index.php" class="back-link">← Retourner à l'accueil</a>
    </div>

</body>

</html>