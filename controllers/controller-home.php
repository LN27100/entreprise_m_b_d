<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../config.php';
require_once '../models/Enterprisejson.php';

if (!isset($_SESSION['enterprise'])) {
    // Redirigez vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: ../controllers/controller-signin.php");
    exit();
}

// Récupère le nom de l'entreprise
$nom = isset($_SESSION['enterprise']['enterprise_name']) ? $_SESSION['enterprise']['enterprise_name'] : "Nom d'entreprise non défini";

// Récupère l'image de profil de l'entreprise
$img = isset($_SESSION['enterprise']['enterprise_photo']) && !empty($_SESSION['enterprise']['enterprise_photo']) ? $_SESSION['enterprise']['enterprise_photo'] : "../assets/img/avatarDefault.jpg";

// Récupère les informations de l'entreprise
$siret = isset($_SESSION['enterprise']['enterprise_siret']) ? $_SESSION['enterprise']['enterprise_siret'] : "Siret non défini";
$email = isset($_SESSION['enterprise']['enterprise_email']) ? $_SESSION['enterprise']['enterprise_email'] : "Email non défini";
$adresse = isset($_SESSION['enterprise']['enterprise_adress']) ? $_SESSION['enterprise']['enterprise_adress'] : "Adresse non définie";
$code_postal = isset($_SESSION['enterprise']['enterprise_zipcode']) ? $_SESSION['enterprise']['enterprise_zipcode'] : "Code postal non défini";
$ville = isset($_SESSION['enterprise']['enterprise_city']) ? $_SESSION['enterprise']['enterprise_city'] : "Ville non définie";

// Gestion du formulaire de mise à jour de l'image de profil
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES['profile_image'])) {
    try {
        // Dossier de sauvegarde des images
        $uploadDir = '../assets/uploads/';

        // Vérification du dossier de sauvegarde des images
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $file_extension = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        // Construire un nom de fichier unique en combinant "profile_", l'ID de l'entreprise et l'extension du fichier
        $new_file_name = "profile_" . $_SESSION['enterprise']['enterprise_id'] . "." . $file_extension;

        // Construire le chemin complet du fichier en concaténant le dossier de sauvegarde avec le nouveau nom de fichier
        $uploadFile = $uploadDir . $new_file_name;

        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $uploadFile)) {
            $_SESSION['enterprise']['enterprise_photo'] = $uploadFile;
            Enterprise::updateProfileImage($_SESSION['enterprise']['enterprise_id'], $uploadFile);

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
    $enterprise_id = isset($_SESSION['enterprise']['enterprise_id']) ? $_SESSION['enterprise']['enterprise_id'] : 0;
    $new_name = isset($_POST['enterprise_name']) ? $_POST['enterprise_name'] : "";
    $new_email = isset($_POST['enterprise_email']) ? $_POST['enterprise_email'] : "";
    $new_adress = isset($_POST['enterprise_adress']) ? $_POST['enterprise_adress'] : "";
    $new_zipcode = isset($_POST['enterprise_zipcode']) ? $_POST['enterprise_zipcode'] : "";
    $new_city = isset($_POST['enterprise_city']) ? $_POST['enterprise_city'] : "";

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
            $_SESSION['enterprise']['enterprise_name'] = $new_name;
            $_SESSION['enterprise']['enterprise_email'] = $new_email;
            $_SESSION['enterprise']['enterprise_adress'] = $new_adress;
            $_SESSION['enterprise']['enterprise_zipcode'] = $new_zipcode;
            $_SESSION['enterprise']['enterprise_city'] = $new_city;
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour du profil : " . $e->getMessage();
        }
        header("Location: ../controllers/controller-home.php");
        exit();
    }
}

// Supprimer le profil de l'entreprise
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_profile'])) {
    // Appelle la méthode pour supprimer le profil
    $delete_result = Enterprise::deleteEnterprise($_SESSION['enterprise']['enterprise_id']);

    if ($delete_result) {
        // Supprime la session et redirige vers la page de connexion
        session_unset();
        session_destroy();
        header("Location: ../controllers/controller-signin.php");
        exit();
    } else {
        echo "Erreur lors de la suppression du profil.";
    }
}

$allUtilisateursJson = Enterprise::getAllUtilisateurs($_SESSION['enterprise']['enterprise_id']);
$allUtilisateurs = json_decode($allUtilisateursJson, true);

$lastfivejourneysJson = Enterprise::getlastfivejourneys($_SESSION['enterprise']['enterprise_id']);
$lastfivejourneys = json_decode($lastfivejourneysJson, true);

$actifUtilisateursJson = Enterprise::getActifUtilisateurs($_SESSION['enterprise']['enterprise_id']);
$actifUtilisateurs = json_decode($actifUtilisateursJson, true);

$allTrajetsJson = Enterprise::getAllTrajets($_SESSION['enterprise']['enterprise_id']);
$allTrajets = json_decode($allTrajetsJson, true);

$lastfiveusersJson = Enterprise::getlastfiveusers($_SESSION['enterprise']['enterprise_id']);
$lastfiveusers = json_decode($lastfiveusersJson, true);

$statstransportsJson = Enterprise::getTransportStats($_SESSION['enterprise']['enterprise_id']);
$statstransports = json_decode($statstransportsJson, true);

$currentYear = date('Y');
$rideDataForYearJson = Enterprise::getRideDataForYear($_SESSION['enterprise']['enterprise_id'], $currentYear);
$rideDataForYear = json_decode($rideDataForYearJson, true);

// Inclure la vue pour afficher la page d'accueil
include_once '../views/view-home.php';
?>
