<?php
require_once __DIR__ . '/../../autoload.php';

if (isset($_GET) && $_SERVER["REQUEST_METHOD"] == "GET") {
    $joueurID = $_GET["id"];
    $pdo = Database::getInstance()->getConnection();
    $deleted = JoueursRepo::delete($pdo, $joueurID);
    var_dump($deleted);
    header("Location: /../../Apex_Mercato/roles/index.php");
    exit;
}
