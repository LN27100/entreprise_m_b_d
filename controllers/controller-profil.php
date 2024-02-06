<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../config.php';
require_once '../models/Enterprise.php';

if (!isset($_SESSION['enterprise'])) {
    header("Location: ../controllers/controller-signin.php");
    exit();
}

// Récupère le pseudo de l'entreprise
$nom = isset($_SESSION['enterprise']['enterprise_name']) ? ($_SESSION['enterprise']['enterprise_name']) : "Nom non défini";
$siret = isset($_SESSION['enterprise']['enterprise_siret']) ? ($_SESSION['enterprise']['enterprise_siret']) : "Siret non défini";
$email = isset($_SESSION['enterprise']['enterprise_email']) ? ($_SESSION['enterprise']['enterprise_email']) : "Email non défini";
$adresse = isset($_SESSION['enterprise']['enterprise_adress']) ? ($_SESSION['enterprise']['enterprise_adress']) : "Adresse non définie";
$code_postal = isset($_SESSION['enterprise']['enterprise_zipcode']) ? ($_SESSION['enterprise']['enterprise_zipcode']) : "Code postal non défini";
$ville = isset($_SESSION['enterprise']['enterprise_city']) ? ($_SESSION['enterprise']['enterprise_city']) : "Ville non définie";

// Vérifie si une photo d'utilisateur est définie dans la session
if (isset($_SESSION['enterprise']['enterprise_photo']) && !empty($_SESSION['enterprise']['enterprise_photo'])) {
    $img = $_SESSION['enterprise']['enterprise_photo'];
} else {
    $img = "../assets/img/avatarDefault.jpg";
}

// Gestion du formulaire
$errors = array(); // Tableau pour stocker les erreurs

$enterprise_id = isset($_SESSION['enterprise']['enterprise_id']) ? $_SESSION['enterprise']['enterprise_id'] : null;

// Gestion de la mise à jour de l'image de profil
if (isset($_FILES['profile_image'])) {
    try {
        // Dossier de sauvegarde des images
        $uploadDir = '../assets/uploads/';


        // Vérification du dossier de sauvegarde des images
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }


        $file_extension = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        // Construire un nom de fichier unique en combinant "profile_", l'ID de l'utilisateur et l'extension du fichier
        $new_file_name = "profile_" . $_SESSION['enterprise']['enterprise_id'] . "." . $file_extension;


        // // Construire le chemin complet du fichier en concaténant le dossier de sauvegarde avec le nouveau nom de fichier

        $uploadFile = $uploadDir . $new_file_name;


        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $uploadFile)) {
            $_SESSION['enterprise']['enterprise_photo'] = $uploadFile;
            Enterprise::updateProfileImage($_SESSION['enterprise']['enterprise_id'], $uploadFile);
            header("Location: ../controllers/controller-profil.php");
        } else {
            $uploadDir = '../assets/img/avatarDefault.jpg';

            echo "Erreur lors du téléchargement du fichier : " . $_FILES['profile_image']['error'];
        }
    } catch (Exception $e) {
        echo "Erreur lors de la mise à jour de l'image de profil : " . $e->getMessage();
    }
}



// Gestion du formulaire
if (isset($_POST['save_modification'])) {
    $enterprise_id = isset($_SESSION['enterprise']['enterprise_id']) ? $_SESSION['enterprise']['enterprise_id'] : 0;
    $new_name = isset($_POST['enterprise_name']) ? ($_POST['enterprise_name']) : "";
    $new_email = isset($_POST['enterprise_email']) ? ($_POST['enterprise_email']) : "";
    $new_adress = isset($_POST['enterprise_adress']) ? ($_POST['enterprise_adress']) : "";
    $new_zipcode = isset($_POST['enterprise_zipcode']) ? ($_POST['enterprise_zipcode']) : "";
    $new_city = isset($_POST['enterprise_city']) ? ($_POST['enterprise_city']) : "";


    // Contrôle du nom
    if (empty($_POST["enterprise_name"])) {
        $errors["enterprise_name"] = "Champ obligatoire";
    } elseif (!preg_match("/^[a-zA-ZÀ-ÿ -]*$/", $_POST["enterprise_name"])) {
        $errors["enterprise_name"] = "Seules les lettres, les espaces et les tirets sont autorisés dans le champ Nom";
    }


    // Contrôle de l'email 
    if (empty($_POST["enterprise_email"])) {
        $errors["enterprise_email"] = "Champ obligatoire";
    } elseif (!filter_var($_POST["enterprise_email"], FILTER_VALIDATE_EMAIL)) {
        $errors["enterprise_email"] = "Le format de l'adresse email n'est pas valide";
    } elseif (Enterprise::checkMailExists($_POST["enterprise_email"]) && $_POST["enterprise_email"] != $_SESSION["enterprise"]["enterprise_email"]) {
        $errors["enterprise_email"] = 'Mail déjà utilisé';
    }

    // Contrôle de l'adresse
    if (empty($_POST["enterprise_adress"])) {
        $errors["enterprise_adress"] = "Champ obligatoire";
    }

    // Contrôle du code postal
    if (empty($_POST["enterprise_zipcode"])) {
        $errors["enterprise_zipcode"] = "Champ obligatoire";
    }

    // Contrôle de la ville
    if (empty($_POST["enterprise_city"])) {
        $errors["enterprise_city"] = "Champ obligatoire";
    }

    // Si des erreurs sont détectées, redirigez l'utilisateur vers le formulaire avec les erreurs
    if (empty($errors)) {
        try {
            Enterprise::updateProfil($enterprise_id, $new_name, $new_email, $new_adress, $new_zipcode, $new_city);
            $_SESSION['enterprise']['enterprise_name'] = $new_name;
            $_SESSION['enterprise']['enterprise_email'] = $new_email;
            $_SESSION['enterprise']['enterprise_adress'] = $new_adress;
            $_SESSION['enterprise']['enterprise_zipcode'] = $new_zipcode;
            $_SESSION['enterprise']['enterprise_city'] = $new_city;
        } catch (Exception $e) {
            echo "Erreur lors de la mise à jour du profil : " . $e->getMessage();
        }
        // Redirigez l'utilisateur vers la page du profil après la mise à jour
        header("Location: ../controllers/controller-profil.php");
        exit();
    }
}

// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_profile'])) {
//     // Appelle la méthode pour supprimer le profil
//     $delete_result = Enterprise::deleteEnterprise($enterprise_id);

//     if ($delete_result === true) {
//         // Suppression réussie, redirigez vers la page d'accueil avec un message de succès
//         header("Location: ../index.php?message=Redirection+reussie");
//         exit();
//     } else {
//         echo "Erreur lors de la suppression du profil : " . $delete_result;
//         exit();
//     }
// }



include_once '../views/view-profil.php';
