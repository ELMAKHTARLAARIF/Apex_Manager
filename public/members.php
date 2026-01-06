<?php
require_once __DIR__ . '/../autoload.php';
session_start();
$pdo = Database::getInstance()->getConnection();

$players = Joueur::all($pdo);
$coachs = Coach::all($pdo);
$members = array_merge(
    array_map(fn($j)=>array_merge(get_object_vars($j), ['type'=>'Joueur']), $players),
    array_map(fn($c)=>array_merge(get_object_vars($c), ['type'=>'Coach']), $coachs)
);

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
    <header>
        <h1>Liste des membres</h1>
        <nav><a href="../roles/index.php">Dashboard Admin</a></nav>
    </header>

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
                <?php foreach ($members as $m): ?>
                    <tr>
                        <td><?= htmlspecialchars($m['type'] === 'Joueur' ? $m['pseudo'] : $m['nom']) ?></td>
                        <td><?= htmlspecialchars($m['email']) ?></td>
                        <td><?= htmlspecialchars($m['nationalite']) ?></td>
                        <td><?= htmlspecialchars($m['type']) ?></td>
                        <td>
                            <?php if ($m['type'] === 'Joueur'): ?>
                                Rôle: <?= htmlspecialchars($m['role']) ?><br>
                                Salaire: <?= number_format($m['salaire'], 2, ',', ' ') ?> €<br>
                                Prime: <?= number_format($m['bonus'], 2, ',', ' ') ?> €
                            <?php else: ?>
                                Style: <?= htmlspecialchars($m['styleDeCoaching']) ?><br>
                                Années exp: <?= htmlspecialchars($m['anneesExperience']) ?><br>
                                Salaire: <?= number_format($m['salaire'], 2, ',', ' ') ?> €<br>
                                Frais déplacement: <?= number_format($m['fraisDeplacement'], 2, ',', ' ') ?> €
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div id="pagination" style="margin-top:15px;text-align:center;"></div>
    </main>



</body>

</html>