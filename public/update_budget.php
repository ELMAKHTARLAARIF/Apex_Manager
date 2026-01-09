<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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

    $team = EquipeRepo::find($pdo, $team_id);

    if (!$team) {
        die("Équipe introuvable !");
    }

    EquipeRepo::updateBudget($pdo,$team_id, $newBudget);
    $id=$team->id;
    header("Location: edit_budget_form.php");
    exit;
}

