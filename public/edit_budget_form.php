<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../autoload.php';
$pdo = Database::getInstance()->getConnection();
$teams = EquipeRepo::all($pdo);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Modifier Budget</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
<?php
session_start();
require_once '../public/assets/secondHeader.php';
?>

    <main class="container">
        <form action="update_budget.php" method="post">
            <label>Équipe</label>
            <select name="team_id" required>
                <option value="">-- Choisir --</option>
                <?php foreach ($teams as $t):
                ?>
                    <option value="<?= $t->id ?>"><?= htmlspecialchars($t->name) ?> (<?= number_format($t->budget, 2, ',', ' ') ?> €)</option>
                <?php endforeach; ?>
            </select>
            <label>Nouveau budget</label>
            <input type="number" step="0.01" name="budget" required>
            <button type="submit">Mettre à jour</button>
        </form>
    </main>
</body>
</html>