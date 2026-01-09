<?php

require_once __DIR__ . '/../../autoload.php';
$pdo = Database::getInstance()->getConnection();

$joueurs = JoueursRepo::all($pdo);
$teams = EquipeRepo::all($pdo);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Transfert Joueur</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>
    <?php session_start(); require_once '../assets/secondHeader.php' ?>

    <main class="container">
        <form action="transfer_player.php" method="post">
            <label>Joueur :</label>
            <select name="player_id" required>
                <option value="">-- Choisir un joueur --</option>
                <?php foreach ($joueurs as $j): ?>
                    <option value="<?= $j->id ?>">
                        <?= htmlspecialchars($j->pseudo) ?> 
                        (<?= $j->team ? htmlspecialchars($j->team->nom) : 'Libre' ?>)
                    </option>
                <?php endforeach; ?>
            </select>


            <label>Équipe destination :</label>
            <select name="to_team_id" required>
                <option value="">-- Choisir équipe destination --</option>
                <?php foreach ($teams as $t): ?>
                    <option value="<?= $t->id ?>"><?= htmlspecialchars($t->nom) ?></option>
                <?php endforeach; ?>
            </select>

            <label>Montant du transfert :</label>
            <input type="number" step="0.01" name="amount" required>

            <button type="submit">Effectuer le transfert</button>
        </form>
    </main>
</body>
</html>
