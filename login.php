<?php
session_start(); // Toujours en premier !
require_once 'db.php';

$message = "";

// Si le formulaire est envoyé
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 1. On cherche l'utilisateur
    // On utilise prepare() pour éviter les injections SQL (Sécurité !)
    $stmt = $conn->prepare("SELECT user_id, name, surname, password, role FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // 2. On vérifie le hash du mot de passe
        if (password_verify($password, $row['password'])) {
            // BINGO ! On crée la session
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['role'] = $row['role'];

            // Redirection vers la page admin
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
    <title>Connexion</title>
    <style>
        body {
            font-family: sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f0f2f5;
            margin: 0;
        }

        .login-box {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #27ae60;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #219150;
        }

        .error {
            color: red;
            font-size: 0.9em;
            margin-bottom: 10px;
        }

        .home-link {
            display: block;
            margin-top: 15px;
            color: #666;
            text-decoration: none;
            font-size: 0.9em;
        }
    </style>
</head>

<body>

    <div class="login-box">
        <h2>Se connecter</h2>
        <?php if ($message): ?>
            <div class="error"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="email" name="email" placeholder="Votre email" required>
            <input type="password" name="password" placeholder="Votre mot de passe" required>
            <button type="submit">Connexion</button>
        </form>

        <a href="index.php" class="home-link">← Retour à l'accueil</a>
    </div>

</body>

</html>