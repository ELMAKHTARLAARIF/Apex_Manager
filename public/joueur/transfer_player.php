<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../autoload.php';
session_start();

$pdo = Database::getInstance()->getConnection();

$transferService = new Transfert($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $personId   = (int) $_POST['person_id'];
    $fromTeamId = (int) $_POST['from_team_id'];
    $toTeamId   = (int) $_POST['to_team_id'];
    $amount     = (float) $_POST['amount'];

    try {
        $transferService->transferPlayer(
            $personId,
            $fromTeamId,
            $toTeamId,
            $amount
        );

        header("Location: transfer_form.php?success=1");
        exit;

    } catch (Exception $e) {
        echo "Erreur : " . htmlspecialchars($e->getMessage());
    }
}
