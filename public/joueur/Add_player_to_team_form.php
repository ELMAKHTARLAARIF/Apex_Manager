<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../../autoload.php';
$pdo = Database::getInstance()->getConnection();
$freeJoueur = JoueursRepo::getPlayersWithoutTeam($pdo);
$teams =  EquipeRepo::all($pdo);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>
    <?php session_start();
    require_once '../assets/secondHeader.php' ?>
    <section class="card add-player-to-team">
        <h2>Ajouter un joueur à une équipe</h2>
        <form action="assign_player_to_team.php" method="post">

            <!-- Team selection -->
            <label>Équipe</label>
            <div class="input-group">
                <select name="team_id" required>
                    <option value="">-- Choisir l'équipe --</option>
                    <?php foreach ($teams as $team): ?>
                        <option value="<?= $team["id"] ?>"><?= htmlspecialchars($team["name"]) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Player selection -->
            <label>Joueur</label>
            <div class="input-group">
                <select name="player_id" required>
                    <option value="">-- Choisir le joueur --</option>
                    <?php foreach ($freeJoueur as $joueur): ?>
                        <option value="<?= $joueur["person_id"]?>">
                            <?= htmlspecialchars($joueur["name"]) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Salaire -->
            <label>Salaire (€)</label>
            <div class="input-group">
                <input type="number" step="0.01" name="salaire" placeholder="Salaire (optionnel)">
            </div>

            <!-- Clause -->
            <label>Clause (€)</label>
            <div class="input-group">
                <input type="number" step="0.01" name="clause" placeholder="Clause (optionnel)">
            </div>

            <button type="submit">Ajouter le joueur</button>
        </form>
    </section>

</body>

</html>