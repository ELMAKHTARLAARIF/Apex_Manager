<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . "/../../autoload.php";
if (isset($_GET) && $_SERVER["REQUEST_METHOD"] == "GET") {
    $pdo = Database::getInstance()->getConnection();
    $coachID = $_GET["person_id"];
    $editCoach = CoachRepo::getCoach($pdo, $coachID);
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

        <sect$ion class="card">
            <h2>Update Coach </h2>
            <form action="update_coach.php" method="post">
                <input type="hidden" name="person_id" required value="<?= $editCoach["person_id"] ?>">
                <label>Nom :</label>
                <input type="text" name="name" required value="<?= $editCoach["name"] ?>">

                <label>Email :</label>
                <input type="email" name="email" value="<?= $editCoach["email"] ?>" required>

                <label>Nationalité :</label>
                <input type="text" name="nationality" value="<?= $editCoach["nationality"] ?>" required>

                <div id="coach-fields">
                    <h4>Coach</h4>
                    <label>Style de coaching :</label>
                    <input type="text" name="coaching_style" value="<?= $editCoach["coaching_style"] ?>">

                    <label>frais deplacement :</label>
                    <input type="number" step="0.01" name="years_of_experience" value="<?= $editCoach["years_of_experience"] ?>">
                </div>

                <a href="update_coach.php"><button type="submit"> Save Update</button></a>
            </form>
            </section>


    </main>
</body>

</html>