<?php
// Empêche l'accès à la page home si l'utilisateur n'est pas connecté et vérifie si la session n'est pas déjà active
if (session_status() === PHP_SESSION_NONE) {
    // Si non, démarrer la session
    session_start();
}

require_once '../config.php';
require_once '../models/Enterprise.php';

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['enterprise'])) {
    // Redirigez vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: ../controllers/controller-signin.php");
    exit();
}

// Récupère le pseudo de l'utilisateur
$nom = isset($_SESSION['enterprise']['enterprise_name']) ? ($_SESSION['enterprise']['enterprise_name']) : "Nom d'entreprise non défini";

// Vérifie si une photo d'utilisateur est définie dans la session
if (isset($_SESSION['enterprise']['enterprise_photo']) && !empty($_SESSION['enterprise']['enterprise_photo'])) {
    // Utilise la photo de l'utilisateur s'il en existe une
    $img = $_SESSION['enterprise']['enterprise_photo'];
} else {
    // Utilise une photo par défaut si aucune photo d'utilisateur n'est définie
    $img = "../assets/img/avatarDefault.jpg";
}

// Inclure la vue home uniquement si l'utilisateur est connecté
include_once '../views/view-home.php';
?>