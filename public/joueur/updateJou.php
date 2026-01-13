<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . "/../../autoload.php";
if (isset($_POST["person_id"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $joueurID = $_POST["person_id"];
    $nom = $_POST["name"];
    $email = $_POST["email"];
    $nationality = $_POST["nationality"];
    $pdo = Database::getInstance()->getConnection();
    $joueur = new Joueur(
        $nom,
        $email,
        $nationality,
        trim($_POST['pseudo']),
        trim($_POST['role']),
        floatval($_POST['market_value']),
    );
    $joueur->personId = $joueurID;
    $updated = JoueursRepo::update($pdo, $joueur);
    if ($updated) {
        header("Location: /../../Apex_Mercato/roles/index.php");
        exit;
    }
}
