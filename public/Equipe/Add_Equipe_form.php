<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Equipes – Apex Manager</title>
    <link rel="stylesheet" href="../assets/style.css">
    <script src="../public/assets/Coach.js" defer></script>
</head>

<body>
    <?php session_start(); require_once '../assets/secondHeader.php' ?>

    <main class="container">

        <section class="card">
            <h2>Créer une nouvelle équipe</h2>
            <form action="insert_team.php" method="POST">
                <label>Nom de l'équipe :</label>
                <input type="text" name="nom" required>

                <label>Budget :</label>
                <input type="number" step="0.01" name="budget" required>

                <label>Manager :</label>
                <input type="text" name="manager" required>

                <button type="submit">Créer l'équipe</button>
            </form>
        </section>



    </main>



</body>

</html>