<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../autoload.php';
require_once '../src/Entity/Transfert.php';
session_start();

$pdo = Database::getInstance()->getConnection();
$transferService = new transfert($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $playerId = (int)$_POST['player_id'];
    $fromTeamId = (int)$_POST['from_team_id'];
    $toTeamId = (int)$_POST['to_team_id'];
    $amount = (float)$_POST['amount'];

    try {
        $transferService->transferPlayer($playerId, $fromTeamId, $toTeamId, $amount);
        header("Location: transfer_form.php");
        exit;
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
