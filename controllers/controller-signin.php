<?php
require_once '../config.php';
require_once '../models/Enterprise.php';


        // empêche l'accès à la page home si l'utilisateur n'est pas connecté et vérifie si la session n'est pas déjà active
        if (session_status() === PHP_SESSION_NONE) {
            // Si non, démarrer la session
            session_start();
        }


// Vérifiez si un formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Tableau d'erreurs (stockage des erreurs)
    $errors = [];

    // Vérifiez si l'email est vide
    if (empty($_POST["enterprise_email"])) {
        $errors["enterprise_email"] = "Champ obligatoire";
    } else {
        // Récupérez la valeur de l'email depuis le formulaire
        $email = $_POST["enterprise_email"];
    }

    // Vérifiez si le mot de passe est vide
    if (empty($_POST["enterprise_password"])) {
        $errors["enterprise_password"] = "Champ obligatoire";
    }

    if (isset($_POST["g-recaptcha-response"])) {
        // print_r($_POST);
        $secret='6LfsZnApAAAAAParnG-WEx0_sgVatsrBshd2mm7B';
        $reponse = $_POST['g-recaptcha-response'];
        $remoteip= $_SERVER ['REMOTE_ADDR'];

        $url= "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$reponse&remoteip=$remoteip ";
        
        $reponseData = file_get_contents($url);
        $dataRow = json_decode($reponseData, true);

        // print_r($dataRow);

            if($dataRow['success']==true) {
                $msg = 'Recaptcha vérifié avec succès';
                    } else {
                 $msg = 'Recaptcha non valide';
                        }
            }

    // Si aucune erreur, procédez à la vérification de l'utilisateur
    if (empty($errors)) {
        // Vérifiez si l'email existe dans la base de données
        if (!Enterprise::checkMailExists($email)) {
            $errors['enterprise_email'] = 'Utilisateur Inconnu';
        } else {
            // Récupérez les informations de l'utilisateur
            $entrepriseInfos = Enterprise::getInfos($email);

            // Comparaison du mot de passe
            if (password_verify($_POST["enterprise_password"], $entrepriseInfos['enterprise_password'])) {
                // Mot de passe correct

                // Stockez les infos dans la variable de session
                $_SESSION['enterprise'] = $entrepriseInfos;

                // Redirigez vers la page d'accueil
                header("Location: ../controllers/controller-home.php");
                exit();
            } else {
                $errors['enterprise_password'] = 'Mauvais mot de passe';
            }
        }
    }
}


// Inclure la vue du formulaire de connexion
include_once '../views/view-signin.php';


// LEXIQUE

// "session_start()" démarre une nouvelle session ou reprend une session existante. Elle doit être appelée avant tout accès aux variables de session ou avant tout contenu HTML dans le script. Permet de maintenir une session active pour un utilisateur sur plusieurs pages

// la vérification en haut $_SESSION assure que les utilisateurs déjà connectés sont redirigés vers la page d'accueil (header location) plutôt que de voir à nouveau la page de connexion.