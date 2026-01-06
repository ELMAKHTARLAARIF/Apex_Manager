<?php
session_start();
function isAdmin() {
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
}

function isJournalist() {
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'journalist';
}

function isUser() {
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'user';
}

function requireLogin() {
    if (!isset($_SESSION['user'])) {
        header('Location: ../public/login.php');
        exit;
    }
}
