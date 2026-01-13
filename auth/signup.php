<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../autoload.php';
session_start();

$pdo = Database::getInstance()->getConnection();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];
    $name = trim($_POST['name']);

    if (strlen($password) < 6) {
        $message = "Mot de passe minimum 6 caractères.";
    } else {

        $stmt = $pdo->prepare(
            "SELECT id FROM users WHERE email = ?"
        );
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $message = "Utilisateur ou email déjà existant.";
        } else {

            $hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare(
                "INSERT INTO users (name, email, password, role)
            VALUES (?, ?, ?, ?)"
            );
            $stmt->execute([$name, $email, $hash, $role]);

            header("Location: login.php?success=1");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Inscription – Apex Manager</title>
    <link rel="stylesheet" href="../public/assets/style.css">
</head>

<body class="login-page">

    <div class="login-card">
        <h2>Créer un compte</h2>

        <?php if ($message): ?>
            <p class="error-message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="post">
            <input type="text" name="name" placeholder="Nom" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>

            <select name="role" required>
                <option value="user">Utilisateur</option>
                <option value="journalist">Journaliste</option>
                <option value="admin">Admin</option>
            </select>

            <button type="submit">S'inscrire</button>
        </form>

        <p style="margin-top:15px;">
            Déjà inscrit ? <a href="login.php">Se connecter</a>
        </p>
    </div>

</body>

</html>