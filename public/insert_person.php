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
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $nationality = trim($_POST['nationality']);
    $type = $_POST['type'];
    try {
        if ($type === 'joueur') {

            $joueur = new Joueur(
                $name,
                $email,
                $nationality,
                trim($_POST['pseudo']),
                trim($_POST['role']),
                floatval($_POST['market_value'])
            );

    $repo = new JoueursRepo();
    $repo->save($pdo,$joueur);

        } elseif ($type === 'coach') {
            $coach = new Coach(
                $name,
                $email,
                $nationality,
                trim($_POST['styleDeCoaching']),
                floatval($_POST['years_of_experience'])
            );
            $coach = CoachRepo::create($pdo,$coach);
        }
        header("Location: ../roles/index.php");
        exit;
    } catch (Exception $e) {
        echo $e;
        // $_SESSION['error'] = "Erreur lors de l'ajout : " . $e->getMessage();
        // header("Location: ./joueur/Add_Joueur_Coach_form.php");
        // exit;
    }
}
