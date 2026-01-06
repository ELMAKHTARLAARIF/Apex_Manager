<?php
require_once __DIR__ . '/../autoload.php';

session_start();

$pdo = Database::getInstance()->getConnection();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare(
        "SELECT * FROM users WHERE username = ? OR email = ?"
    );
    $stmt->execute([$username, $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role']
        ];


        if ($user['role'] === 'admin') {
            header("Location: ../roles/index.php");
        } elseif ($user['role'] === 'journalist') {
            header("Location: ../roles/journalist.php");
        } else {
            header("Location: ../roles/user_home.php");
        }
        exit;

    } else {
        $message = "Identifiants incorrects.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion – Apex Manager</title>
    <link rel="stylesheet" href="../public/assets/style.css">
</head>
<body class="login-page">

<div class="login-card">
    <h2>Connexion</h2>

    <?php if (isset($_GET['success'])): ?>
        <p style="color:green;font-weight:bold;">
            Compte créé avec succès !
        </p>
    <?php endif; ?>

    <?php if ($message): ?>
        <p class="error-message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="username" placeholder="Username ou Email" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit">Se connecter</button>
    </form>

    <p style="margin-top:15px;">
        Pas de compte ? <a href="signup.php" class="signup-link">Créer un compte</a>
    </p>
</div>

</body>
</html>
