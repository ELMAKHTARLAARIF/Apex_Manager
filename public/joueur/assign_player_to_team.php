<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/../../autoload.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $teamId   = (int) $_POST["team_id"];
    $playerId = (int) $_POST["player_id"];
    $salary   = (float) $_POST["salaire"];

    $pdo = Database::getInstance()->getConnection();

    $row = JoueursRepo::getJoueur($pdo, $playerId);

    if (!$row) {
        echo json_encode(["success" => false, "message" => "Player not found."]);
        exit;
    }

    $player = new Joueur(
        $row['name'],  
        $row['email'],       
        $row['nationality'], 
        $row['pseudo'],     
        $row['role'],  
        (float)$row['market_value'],
        0  
    );
    $player->personId = $row['person_id'];
    JoueursRepo::addToTeam($pdo, $player, $teamId, $salary);

    echo json_encode(["success" => true, "message" => "Player assigned to team."]);
}
