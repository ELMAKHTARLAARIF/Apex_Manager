<?php
require_once __DIR__ . '/../autoload.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$pdo = Database::getInstance()->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $team_id = (int) $_POST['team_id'];
    $newBudget = (float) $_POST['budget'];

    $team = Equipe::find($pdo, $team_id);

    if (!$team) {
        die("Équipe introuvable !");
    }

    $team->updateBudget($pdo, $newBudget);
    $id=$team->id;
    header("Location: edit_budget_form.php");
    exit;
}

