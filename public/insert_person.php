<?php
require_once __DIR__ . '/../autoload.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$pdo = Database::getInstance()->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $nationalite = trim($_POST['nationalite']);
    $type = $_POST['type'];

    try {
        if ($type === 'joueur') {
   
            $joueur = new Joueur(
                $nom,
                $email,
                $nationalite,
                trim($_POST['pseudo']),
                trim($_POST['role']),
                floatval($_POST['salaire']),
                floatval($_POST['primeSignature'])
            );


            $joueur->save($pdo);

        } elseif ($type === 'coach') {
            $coach = new Coach(
                $nom,
                $email,
                $nationalite,
                trim($_POST['styleDeCoaching']),
                intval($_POST['anneesExperience']),
                floatval($_POST['coachSalaire']),
                floatval($_POST['fraisDeplacement'])
            );


            $coach->save($pdo);
        }

        $_SESSION['success'] = ucfirst($type) . " ajouté(e) avec succès !";
        header("Location: ../roles/index.php");
        exit;

    } catch (Exception $e) {
        $_SESSION['error'] = "Erreur lors de l'ajout : " . $e->getMessage();
        header("Location: add_person.php");
        exit;
    }
}
