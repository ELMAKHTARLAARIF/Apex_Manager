<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../autoload.php';
require_once __DIR__ . '/../auth/auth.php';
if (!isAdmin()) {
    header('Location: user_home.php');
    exit;
}


$pdo = Database::getInstance()->getConnection();

$teams = EquipeRepo::all($pdo);
$members = JoueursRepo::all($pdo);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Equipes – Apex Manager</title>
    <link rel="stylesheet" href="../public/assets/style.css">
    <script src="../public/assets/Coach.js" defer></script>
</head>

<body>
    <?php require_once '../public/assets/header.php' ?>

    <main class="container">

        <section class="card">
            <h2>Liste des équipes</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Budget</th>
                        <th>Manager</th>
                        <th>Membres</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($teams as $team): ?>
                        <tr>
                            <td><?= htmlspecialchars($team->nom) ?></td>
                            <td><?= number_format($team->budget, 2, ',', ' ') ?> €</td>
                            <td><?= htmlspecialchars($team->manager) ?></td>
                            <td>
                                <?php

                                foreach ($members as $m) {
                                    echo htmlspecialchars($m->pseudo ?? $m['nom']) . " (" . ($m->type ?? 'coach') . ")<br>";
                                }
                                ?>
                            </td>
                            <td>
                                <a class="delete deleteEquipe" href="../public/Equipe/delete_Equipe.php?id=<?=$team->id?>">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button class="add_button JouCoa"><a href="../public/joueur/Add_Joueur_Coach_form.php">Ajouter un Joueur ou un Coach</a></button>
            <button class="add_button AddEquipe"><a href="../public/Equipe/Add_Equipe_form.php">Ajouter un Equipe</a></button>
            <button class="add_button AddEquipe"><a href="../public/Equipe/Add_Equipe_form.php">Ajouter un Joueur dans L'Equipe</a></button>

        </section>
        <!-- Delete Confirmation Modal -->
        <div class="modal" id="deleteModal">
            <div class="modal-box">
                <h3>Delete Coach</h3>
                <p class="message">Are you sure you want to delete this coach?</p>

                <div class="modal-actions">
                    <button class="btn cancel" onclick="closeModal()">Cancel</button>
                    <button class="btn delete" id="confirmDeleteBtn">Delete</button>

                </div>
            </div>
        </div>



    </main>



</body>

</html>