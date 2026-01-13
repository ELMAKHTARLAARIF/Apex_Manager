<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../autoload.php';
session_start();
$pdo = Database::getInstance()->getConnection();

$players = JoueursRepo::all($pdo);
$coachs = CoachRepo::all($pdo);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Liste des membres – Apex Manager</title>
    <link rel="stylesheet" href="../public/assets//style.css">
    <script src="../public/assets/members.js"></script>
</head>

<body>
    <?php require_once '../public/assets/header.php' ?>

    <main class="container">

        <input type="text" id="searchInput" placeholder="Rechercher un membre..." style="margin-bottom:15px;padding:8px;width:100%;border-radius:5px;border:1px solid #ccc;">

        <table id="membersTable">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Nationalité</th>
                    <th>Type</th>
                    <th>Détails financiers / Expérience</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($players as $player): ?>
                    <tr>
                        <td><?= htmlspecialchars($player['name']) ?></td>
                        <td><?= htmlspecialchars($player['email']) ?></td>
                        <td><?= htmlspecialchars($player['nationality']) ?></td>
                        <td>Joueur</td>
                        <td>Amount: <?= number_format($player['market_value'], 0, ',', ' ') ?> €</td>
                        <td>
                            <a href="../public/joueur/deleteJou.php?id=<?= $player['person_id'] ?>" ><button>delete</button></a>
                            <a href="../public/joueur/update_form.php?id=<?= $player['person_id'] ?>" ><button>update</button></a>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <?php foreach ($coachs as $coach): ?>
                    <tr>
                        <td><?= htmlspecialchars($coach->name) ?></td>
                        <td><?= htmlspecialchars($coach->email) ?></td>
                        <td><?= htmlspecialchars($coach->nationality) ?></td>
                        <td>Coach</td>
                        <td>Style de coaching: <?= htmlspecialchars($coach->coaching_style) ?><br>Années d'expérience: <?= (int) $coach->years_of_experience ?></td>
                        <td>
                            <a href="../public/Coach/deleteCoach.php?person_id=<?= $coach->person_id ?>" ><button>delete</button></a>
                            <a href="../public/Coach/update_coach_form.php?person_id=<?= $coach->person_id?>" ><button>update</button></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <button class="add_button JouCoa"><a class="add_button" href="../public/joueur/Add_Joueur_Coach_form.php">Ajouter un Joueur ou un Coach</a></button>

            </tbody>
        </table>

        <div id="pagination" style="margin-top:15px;text-align:center;"></div>
    </main>



</body>

</html>