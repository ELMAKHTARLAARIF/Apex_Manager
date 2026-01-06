<?php
require_once __DIR__ . '/../autoload.php';
$pdo = Database::getInstance()->getConnection();
$teams = Equipe::all($pdo);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Modifier Budget</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <header>
        <h1>Modifier Budget Équipe</h1>
        <nav><a href="../roles/index.php">Dashboard Admin</a></nav>
    </header>

    <main class="container">
        <form action="update_budget.php" method="post">
            <label>Équipe</label>
            <select name="team_id" required>
                <option value="">-- Choisir --</option>
                <?php foreach ($teams as $t):
                ?>
                    <option value="<?= $t->id ?>"><?= htmlspecialchars($t->nom) ?> (<?= number_format($t->budget, 2, ',', ' ') ?> €)</option>
                <?php endforeach; ?>
            </select>
            <label>Nouveau budget</label>
            <input type="number" step="0.01" name="budget" required>
            <button type="submit">Mettre à jour</button>
        </form>
        <?= $team_id ?>
    </main>
</body>
</html>