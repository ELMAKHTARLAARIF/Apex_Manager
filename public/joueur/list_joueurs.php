<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../../autoload.php';

session_start();

if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], ['admin', 'journalist'])) {
    header("Location: login.php");
    exit;
}

$pdo = Database::getInstance()->getConnection();
$joueurs = Joueur::all($pdo);
$stmt = $pdo->query("SELECT SUM((salaire * 12) + IFNULL (bonus,0)) FROM joueurs");// ILA CANT BONUS NULL KHLIHA KATSAWI 0 BECAUSE OPERATOR WITH NULL VALUE = NULL
$cout_annuel = (float) $stmt->fetchColumn();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Équipes – Apex Manager</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>
    <header>
        <h1>Équipes – Apex Manager</h1>
        <nav>
            <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                <a href="/../Apex_Mercato/roles/admin.php">Dashboard Admin</a>
            <?php endif; ?>
            <a href="logout.php">Déconnexion</a>
        </nav>
    </header>
    <main class="container">
<pre><?=  var_dump($cout_annuel) ?></pre>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Nationalité</th>
                    <th>Salaire</th>
                    <th>role</th>
                    <th> Annual Cost</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($joueurs as $j): ?>
                    <tr>
                        <td><?= htmlspecialchars($j->nom) ?></td>
                        <td><?= htmlspecialchars($j->nationalite) ?></td>
                        <td><?= number_format($j->salaire, 0, ',', ' ') ?> €</td>
                        <td><?= htmlspecialchars($j->role) ?></td>
                        <td><?= number_format(($j->salaire * 12) + $j->bonus, 0, ',', ' ') ?> €</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

            <tfoot>
                <tr>
                    <th colspan="4" style="text-align:right;">Coût annuel total :</th>
                    <th><?= number_format($cout_annuel, 0, ',', ' ') ?> €</th>
                </tr>
            </tfoot>

        </table>

    </main>

</body>

</html>