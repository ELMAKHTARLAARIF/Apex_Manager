<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../../autoload.php';
session_start();
$pdo = Database::getInstance()->getConnection();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $equipe = new Equipe($_POST['nom'], (float)$_POST['budget'], $_POST['manager']);
    $equipeRepo = new EquipeRepo();
    $equipeRepo->createEquipe($pdo,$equipe);
    header("location: display_teams.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter Équipe – Apex Manager</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="login-page">

<div class="login-card">
    <h2>Ajouter une équipe</h2>

    <?php if ($message): ?>
        <p class="error-message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="nom" placeholder="Nom de l'équipe" required>
        <input type="number" step="0.01" name="budget" placeholder="Budget (€)" required>
        <input type="text" name="manager" placeholder="Manager" required>
        <button type="submit">Créer l'équipe</button>
    </form>

    <p style="margin-top:15px;">
        <a href="admin.php">Retour au Dashboard</a>
    </p>
</div>

</body>
</html>
