
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Apex Manager – Journalist</title>
    <link rel="stylesheet" href="../public/assets/style.css">
</head>
<body>

<header class="header">
    <h1>Journalist Dashboard</h1>
    <nav>
        <a href="index.php">Marché</a>
        <a class="active" href="journalist.php">Journaliste</a>
        <a href="index.php">Admin</a>
    </nav>
</header>

<main class="container">

    <section class="card">
        <h2>Historique des transferts (privé)</h2>
        <table>
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>De</th>
                    <th>Vers</th>
                    <th>Montant (€)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transferts as $t): ?>
                <tr>
                    <td><?= $t->getReference() ?></td>
                    <td><?= $t->getFrom()->getNom() ?></td>
                    <td><?= $t->getTo()->getNom() ?></td>
                    <td><?= number_format($t->getMontant(), 2) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <section class="card">
        <h2>Comparaison des coûts annuels</h2>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Type</th>
                    <th>Coût annuel (€)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (array_merge($joueurs, $coachs) as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p->getPublicProfile()['nom']) ?></td>
                    <td><?= $p instanceof Joueur ? 'Joueur' : 'Coach' ?></td>
                    <td><?= number_format($p->getAnnualCost(), 2) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

</main>

<footer class="footer">
    Internal Journalist Access
</footer>

</body>
</html>
