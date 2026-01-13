<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . "/../../autoload.php";
if (isset($_GET) && $_SERVER["REQUEST_METHOD"] == "GET") {
    $pdo = Database::getInstance()->getConnection();
    $joueurID = $_GET["id"];
    $joueur = JoueursRepo::getJoueur($pdo, $joueurID);
}

?>
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

        <section class="card">
            <h2>Update Player </h2>
            <form action="updateJou.php" method="post">
                <input type="hidden" name="person_id" required value="<?= $joueur["person_id"] ?>">
                <label>Nom :</label>
                <input type="text" name="name" required value="<?= $joueur["name"] ?>">

                <label>Email :</label>
                <input type="email" name="email" value="<?= $joueur["email"] ?>" required>

                <label>Nationalité :</label>
                <input type="text" name="nationality" value="<?= $joueur["nationality"] ?>" required>

                <div id="joueur-fields">
                    <label>Pseudo :</label>
                    <input type="text" name="pseudo" value="<?= $joueur["pseudo"] ?>">

                    <label>Rôle :</label>
                    <input type="text" name="role" value="<?= $joueur["role"] ?>">

                    <label>market value :</label>
                    <input type="number" name="market_value" value="<?= $joueur["market_value"] ?>">

                </div>

                <button type="submit"> Save Update</button>
            </form>
            </section>


    </main>
</body>

</html>