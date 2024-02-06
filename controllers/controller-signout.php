<?php
require_once '../config.php';
require_once __DIR__ . '/../models/Enterprise.php';

session_start();

// Détruire toutes les variables de session
$_SESSION = array();

// Détruire la session
session_destroy();

// Rediriger vers la page de connexion
header("Location: controller-signin.php");
exit();
?>