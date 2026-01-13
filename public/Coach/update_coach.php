<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . "/../../autoload.php";
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['person_id'])) {
    $pdo = Database::getInstance()->getConnection();
    $coachID = $_POST["person_id"];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $nationality = $_POST['nationality'];
    $coach = new Coach(
        $name,
        $email,
        $nationality,
        trim($_POST['coaching_style']),
        floatval($_POST['years_of_experience'])
    );
    $coach->person_id=$coachID;
    $coach = CoachRepo::update($pdo, $coach);
    if ($coach) {
        header("Location: /../../Apex_Mercato/roles/index.php");
        exit;
    }
}
