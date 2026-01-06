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

$teams = Equipe::all($pdo);
$members = Joueur::all($pdo);  
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Equipes – Apex Manager</title>
    <link rel="stylesheet" href="../public/assets/style.css">
</head>
<body>
<?php require_once '../public/assets/header.php' ?>

<main class="container">

    <section class="card">
        <h2>Ajouter un Joueur ou un Coach</h2>
        <form action="../public/insert_person.php" method="post">
            <h3>Informations communes</h3>
            <label>Nom :</label>
            <input type="text" name="nom" required>

            <label>Email :</label>
            <input type="email" name="email" required>

            <label>Nationalité :</label>
            <input type="text" name="nationalite" required>

            <h3>Type de personne</h3>
            <select name="type" required>
                <option value="">-- Choisir --</option>
                <option value="joueur">Joueur</option>
                <option value="coach">Coach</option>
            </select>

            <div id="joueur-fields" style="display:none">
                <h4>Joueur</h4>
                <label>Pseudo :</label>
                <input type="text" name="pseudo">

                <label>Rôle :</label>
                <input type="text" name="role">

                <label>Salaire :</label>
                <input type="number" step="0.01" name="salaire">

                <label>Bonus :</label>
                <input type="number" step="0.01" name="bonus">
            </div>

            <div id="coach-fields" style="display:none">
                <h4>Coach</h4>
                <label>Style de coaching :</label>
                <input type="text" name="styleDeCoaching">

                <label>Années d'expérience :</label>
                <input type="number" name="anneesExperience">

                <label>Salaire :</label>
                <input type="number" step="0.01" name="coachSalaire">
            </div>

            <button type="submit">Ajouter</button>
        </form>
    </section>

    <section class="card">
        <h2>Créer une nouvelle équipe</h2>
        <form action="../public/insert_team.php" method="POST">
            <label>Nom de l'équipe :</label>
            <input type="text" name="nom" required>

            <label>Budget :</label>
            <input type="number" step="0.01" name="budget" required>

            <label>Manager :</label>
            <input type="text" name="manager" required>

            <button type="submit">Créer l'équipe</button>
        </form>
    </section>

    <section class="card">
        <h2>Liste des équipes</h2>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Budget</th>
                    <th>Manager</th>
                    <th>Membres</th>
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
                            echo htmlspecialchars($m->pseudo?? $m['nom']) . " (" . ($m->type ?? 'coach') . ")<br>";
                        }
                        ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

</main>

<script>

    const typeSelect = document.querySelector('select[name="type"]');
    console.log(typeSelect);
    const joueurFields = document.getElementById('joueur-fields');
    const coachFields = document.getElementById('coach-fields');

    function toggleFields() {
        if(typeSelect.value === 'joueur') {
            joueurFields.style.display = 'block';
            coachFields.style.display = 'none';
        } else if(typeSelect.value === 'coach') {
            joueurFields.style.display = 'none';
            coachFields.style.display = 'block';
        } else {
            joueurFields.style.display = 'none';
            coachFields.style.display = 'none';
        }
    }

    typeSelect.addEventListener('change', toggleFields);
    toggleFields();
</script>

</body>
</html>
