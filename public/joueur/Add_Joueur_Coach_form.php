
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/style.css">
    <script src="../assets//Equipe.js" defer></script>
</head>

<body>
    <?php session_start();
    require_once '../assets/secondHeader.php' ?>
    <main class="container">

        <sect$ion class="card">
            <h2>Ajouter un Joueur ou un Coach</h2>
            <form action="../insert_person.php" method="post">
                <h3>Informations communes</h3>
                <label>Nom :</label>
                <input type="text" name="name" required>

                <label>Email :</label>
                <input type="email" name="email" required>

                <label>Nationalité :</label>
                <input type="text" name="nationality" required>

                <h3>Type de personne</h3>
                <select name="type" required onchange="toggleFields()" id="type-select">
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

                    <label>Amount :</label>
                    <input type="number" step="0.01" name="amount">

                    <label>market value :</label>
                    <input type="number" step="0.01" name="market_value">
                </div>

                <div id="coach-fields" style="display:none">
                    <h4>Coach</h4>
                    <label>Style de coaching :</label>
                    <input type="text" name="styleDeCoaching">

                    <label>Années d'expérience :</label>
                    <input type="number" name="years_of_experience">

                </div>

                <button type="submit">Ajouter</button>
            </form>
            </section>


    </main>
</body>

</html>