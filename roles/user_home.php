<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../autoload.php';
require_once __DIR__ . '/../auth/auth.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!isUser()) {
    header('Location: ../auth/login.php');
    exit;
}
$pdo = Database::getInstance()->getConnection();

$joueurs = new MergeClasses($pdo);
$JoueurDetails=$joueurs->getJoueurDetailes();

$transfer = new TransferHelper($pdo);
$transferDetails=$transfer->getTransferDetails();
var_dump($transferDetails);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Marché Apex Manager</title>
    <link rel="stylesheet" href="../public/assets/style.css">
</head>
<body>
<header>
    <h1>Bienvenue sur le Marché</h1>
</header>
<main class="container">
    <section class="card">
        <h2>Liste des joueurs</h2>
        <table>
            <thead>
                <tr>
                    <th>Pseudo</th>
                    <th>Rôle</th>
                    <th>Équipe</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($JoueurDetails as $j): ?>
                <tr>
                    <td><?= htmlspecialchars($j['pseudo']) ?></td>
                    <td><?= htmlspecialchars($j['role']) ?></td>
                    <td><?= htmlspecialchars($j['equipe'] ?? 'Libre') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <section class="card">
        <h2>Transferts terminés</h2>
        <table>
            <thead>
                <tr>
                    <th>Joueur</th>
                    <th>Équipe départ</th>
                    <th>Équipe arrivée</th>
                    <th>Montant</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transferDetails as $t): ?>
                <tr>
                    <td><?= htmlspecialchars($t['pseudo']) ?></td>
                    <td><?= htmlspecialchars($t['depart']) ?></td>
                    <td><?= htmlspecialchars($t['arrivee']) ?></td>
                    <td><?= number_format($t['montant'],2,',',' ') ?> €</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</main>
</body>
</html>
