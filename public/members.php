<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../autoload.php';
session_start();
$pdo = Database::getInstance()->getConnection();

$players = JoueursRepo::all($pdo);
$coachs = Coach::all($pdo);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Liste des membres – Apex Manager</title>
    <link rel="stylesheet" href="assets/style.css">
    <script src="../public/assets/members.js"></script>
</head>

<body>
    <?php require_once './assets/secondHeader.php' ?>

    <main class="container">

        <input type="text" id="searchInput" placeholder="Rechercher un membre..." style="margin-bottom:15px;padding:8px;width:100%;border-radius:5px;border:1px solid #ccc;">

        <table id="membersTable">
            <thead>
                <tr>
                    <th>Nom / Pseudo</th>
                    <th>Email</th>
                    <th>Nationalité</th>
                    <th>Type</th>
                    <th>Détails financiers / Expérience</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($players as $player): ?>
                    <tr>
                        <td><?= htmlspecialchars($player['pseudo']) ?></td>
                        <td><?= htmlspecialchars($player['email']) ?></td>
                        <td><?= htmlspecialchars($player['nationalite']) ?></td>
                        <td>Joueur</td>
                        <td>Amount: <?= number_format($player['salaire'], 0, ',', ' ') ?> €<br>Bonus: <?= $player['bonus'], 0, ',', ' ' ?> €</td>
                    </tr>
                <?php endforeach; ?>

                <?php foreach ($coachs as $coach): ?>
                    <tr>
                        <td><?= htmlspecialchars($coach->nom) ?></td>
                        <td><?= htmlspecialchars($coach->email) ?></td>
                        <td><?= htmlspecialchars($coach->nationalite) ?></td>
                        <td>Coach</td>
                        <td>Style de coaching: <?= htmlspecialchars($coach->styleDeCoaching) ?><br>Années d'expérience: <?= (int) $coach->anneesExperience ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div id="pagination" style="margin-top:15px;text-align:center;"></div>
    </main>



</body>

</html>