<?php
require_once __DIR__ . '/../autoload.php';
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], ['admin','journalist'])) {
    header("Location: login.php");
    exit;
}

$pdo = Database::getInstance()->getConnection();

$teams = Equipe::all($pdo);


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Équipes – Apex Manager</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
<header>
    <h1>Équipes – Apex Manager</h1>
    <nav>
        <?php if($_SESSION['user']['role'] === 'admin'): ?>
            <a href="../roles/index.php">Dashboard Admin</a>
        <?php endif; ?>
    </nav>
</header>

<main class="container">

    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Budget</th>
                <th>Manager</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($teams as $team): ?>
                <tr>
                    <td><?= htmlspecialchars($team->nom) ?></td>
                    <td><?= number_format($team->budget, 2, ',', ' ') ?> €</td>
                    <td><?= htmlspecialchars($team->manager) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</main>

</body>
</html>
