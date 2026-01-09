<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Modifier Budget – Apex Manager</title>
    <link rel="stylesheet" href="../public/assets/style.css">
</head>

<body>
    <?php session_start();
    require_once '../assets/secondHeader.php'; ?>
    <main class="container">
        <div class="card">
            <h2>Choisir une équipe et mettre à jour son budget</h2>

            <?php if ($message): ?>
                <p style="color:green;font-weight:bold;"><?= htmlspecialchars($message) ?></p>
            <?php endif; ?>

            <form method="post" action="insert_person.php">
                <label>Équipe :</label>
                <select name="team_id" required>
                    <option value="">-- Choisir une équipe --</option>
                    <?php foreach ($teams as $team): ?>
                        <option value="<?= $team['id'] ?>">
                            <?= htmlspecialchars($team['nom']) ?> (Budget actuel: <?= number_format($team['budget'], 2, ',', ' ') ?> €)
                        </option>
                    <?php endforeach; ?>
                </select>

                <label>Nouveau budget :</label>
                <input type="number" step="0.01" name="budget" placeholder="Nouveau budget" required>

                <button type="submit">Mettre à jour</button>
            </form>
        </div>
    </main>
</body>

</html>