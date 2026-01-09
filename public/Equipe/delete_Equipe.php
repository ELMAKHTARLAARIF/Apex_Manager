<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../../autoload.php';
session_start();
var_dump($_GET); 
if(!($_SESSION['user'] && $_SESSION['user']['role']=='admin')){
    header('location : ../auth/login.php');
    exit;
}
if($_SERVER['REQUEST_METHOD'] = "GET"){
    $EquipeId = $_GET['id'];

    $pdo =  Database::getInstance()->getConnection();
    $deletedEquipe = EquipeRepo::deleteEquipe($pdo,$EquipeId);
    if($deletedEquipe)
    {
        header("location: /../Apex_Mercato/roles/index.php");// errorherefix it tomorrow
        exit;
    }
    else{
        echo "hello world";
    }
}
?>