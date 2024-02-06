<?php
// Empêche l'accès à la page home si l'utilisateur n'est pas connecté et vérifie si la session n'est pas déjà active
if (session_status() === PHP_SESSION_NONE) {
    // Si non, démarrer la session
    session_start();
}

require_once '../config.php';
require_once __DIR__ . '/../models/Userprofil.php';

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    // Redirigez vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: ../controllers/controller-signin.php");
    exit();
}

// Récupère le pseudo de l'utilisateur
$pseudo = isset($_SESSION['user']['user_pseudo']) ? ($_SESSION['user']['user_pseudo']) : "Pseudo non défini";

// Vérifie si une photo d'utilisateur est définie dans la session
if (isset($_SESSION['user']['user_photo']) && !empty($_SESSION['user']['user_photo'])) {
    // Utilise la photo de l'utilisateur s'il en existe une
    $img = $_SESSION['user']['user_photo'];
} else {
    // Utilise une photo par défaut si aucune photo d'utilisateur n'est définie
    $img = "../assets/img/avatarDefault.jpg";
}

// Inclure la vue home uniquement si l'utilisateur est connecté
include_once '../views/view-home.php';
?>