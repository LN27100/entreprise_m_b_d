<?php
session_start();

require_once '../config.php';
require_once '../models/Enterprisejson.php';

// Vérification de la session d'entreprise
if (!isset($_SESSION['enterprise'])) {
    header("Location: ../controllers/controller-signin.php");
    exit();
}

// Récupération des données de l'entreprise depuis la session
$enterprise = $_SESSION['enterprise'];

// Définition des valeurs par défaut si les données ne sont pas définies
$nom = $enterprise['enterprise_name'] ?? "Nom d'entreprise non défini";
$img = $enterprise['enterprise_photo'] ?? "../assets/img/avatarDefault.jpg";
$siret = $enterprise['enterprise_siret'] ?? "Siret non défini";
$email = $enterprise['enterprise_email'] ?? "Email non défini";
$adresse = $enterprise['enterprise_adress'] ?? "Adresse non définie";
$code_postal = $enterprise['enterprise_zipcode'] ?? "Code postal non défini";
$ville = $enterprise['enterprise_city'] ?? "Ville non définie";

// Gestion du formulaire de mise à jour de l'image de profil
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES['profile_image'])) {
    try {
        $uploadDir = '../assets/uploads/';

        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $file_extension = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        $new_file_name = "profile_" . $enterprise['enterprise_id'] . "." . $file_extension;
        $uploadFile = $uploadDir . $new_file_name;

        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $uploadFile)) {
            $enterprise['enterprise_photo'] = $uploadFile;
            Enterprise::updateProfileImage($enterprise['enterprise_id'], $uploadFile);
            header("Location: ../controllers/controller-home.php");
            exit();
        } else {
            echo "Erreur lors du téléchargement du fichier.";
        }
    } catch (Exception $e) {
        echo "Erreur lors de la mise à jour de l'image de profil : " . $e->getMessage();
    }
}

// Gestion du formulaire de mise à jour des informations de l'entreprise
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['save_modification'])) {
    $enterprise_id = $enterprise['enterprise_id'];
    $new_name = $_POST['enterprise_name'] ?? "";
    $new_email = $_POST['enterprise_email'] ?? "";
    $new_adress = $_POST['enterprise_adress'] ?? "";
    $new_zipcode = $_POST['enterprise_zipcode'] ?? "";
    $new_city = $_POST['enterprise_city'] ?? "";

    // Validation des données du formulaire
    $errors = array();

    if (empty($new_name)) {
        $errors["enterprise_name"] = "Le nom de l'entreprise est requis.";
    }

    if (empty($new_email)) {
        $errors["enterprise_email"] = "L'adresse email de l'entreprise est requise.";
    } elseif (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        $errors["enterprise_email"] = "L'adresse email n'est pas valide.";
    }

    if (empty($new_adress)) {
        $errors["enterprise_adress"] = "L'adresse de l'entreprise est requise.";
    }

    if (empty($new_zipcode)) {
        $errors["enterprise_zipcode"] = "Le code postal de l'entreprise est requis.";
    }

    if (empty($new_city)) {
        $errors["enterprise_city"] = "La ville de l'entreprise est requise.";
    }

    // Si aucune erreur n'est détectée, procéder à la mise à jour des informations de l'entreprise
    if (empty($errors)) {
        try {
            Enterprise::updateProfil($enterprise_id, $new_name, $new_email, $new_adress, $new_zipcode, $new_city);
            $enterprise['enterprise_name'] = $new_name;
            $enterprise['enterprise_email'] = $new_email;
            $enterprise['enterprise_adress'] = $new_adress;
            $enterprise['enterprise_zipcode'] = $new_zipcode;
            $enterprise['enterprise_city'] = $new_city;
            $_SESSION['enterprise'] = $enterprise;
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour du profil : " . $e->getMessage();
        }
        header("Location: ../controllers/controller-home.php");
        exit();
    }
}

// Supprimer le profil entreprise
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_profile'])) {
    $delete_result = Enterprise::deleteEnterprise($enterprise_id);
    if ($delete_result === true) {
        header("Location: ../index.php?message=Redirection+reussie");
        exit();
    } else {
        echo "Erreur lors de la suppression du profil : " . $delete_result;
        exit();
    }
}

// Récupérer l'ID de l'entreprise à partir de la session
$enterprise_id = $enterprise['enterprise_id'];

$allUser = json_decode(Enterprise::getAllUtilisateurs($enterprise_id), true);
$lastfivejourneys = json_decode(Enterprise::getlastfivejourneys($enterprise_id), true);
$actifUsers = json_decode(Enterprise::getActifUtilisateurs($enterprise_id), true);
$allRide = json_decode(Enterprise::getAllTrajets($enterprise_id), true);
$lastfiveusers = json_decode(Enterprise::getlastfiveusers($enterprise_id), true);

$statstransports = Enterprise::getTransportStats($enterprise_id);
$currentYear = date('Y');
$rideDataForYear = Enterprise::getRideDataForYear($enterprise_id, $currentYear);

// Récupérer le nombre total d'utilisateurs
$allUsers = $allUser['total_utilisateurs'] ?? 0;

// Récupérer le nombre d'utilisateurs actifs
$allActifsUsers = $actifUsers['data']['total_active_users'] ?? 0;

// Récupérer le nombre total de trajets
$allRides = $allRide['data']['total_trajets'] ?? 0;


// Inclure la vue pour afficher la page d'accueil
include_once '../views/view-home.php';
?>
