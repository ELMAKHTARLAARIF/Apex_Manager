<?php

require_once __DIR__ . '/../../autoload.php';
$pdo = Database::getInstance()->getConnection();

$joueurs = JoueursRepo::getPlayersWithoutTeam($pdo);
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
    <?php session_start();
    require_once '../assets/secondHeader.php' ?>

    <main class="container">
        <form action="transfer_player.php" method="post">
            <label>Équipe actuelle :</label>
            <select name="from_team_id" required>
                <option value="">-- Choisir équipe --</option>
                <?php foreach ($teams as $t): ?>
                    <option value="<?= $t["id"] ?>"><?= htmlspecialchars($t["name"]) ?></option>
                <?php endforeach; ?>
            </select>
            <label>Joueur :</label>
            <select name="person_id" required>
                <option value="">-- Choisir un joueur --</option>
                <?php foreach ($joueurs as $j): ?>

                    <option value="<?= $j["id"] ?>">
                        <?= htmlspecialchars($j["pseudo"]) ?>
                    </option>
                <?php endforeach; ?>
            </select>


            <label>Équipe destination :</label>
            <select name="to_team_id" required>
                <option value="">-- Choisir équipe destination --</option>
                <?php foreach ($teams as $t): ?>
                    <option value="<?= $t["id"] ?>"><?= htmlspecialchars($t["name"]) ?></option>
                <?php endforeach; ?>
            </select>

            <label>Montant du transfert :</label>
            <input type="number" step="0.01" name="amount" required>

            <a href="Add_player_to_team.php"><button type="submit">Effectuer le transfert</button></a>
        </form>
    </main>
</body>

</html>