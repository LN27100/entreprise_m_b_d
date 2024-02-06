<?php

//lier le fichier config
require_once '../config.php';
require_once '../models/Enterprise.php';


// permet d'afficher le formulaire
$showform = true;

// VERIFICATION DE LA SOUMISSION DU FORMULAIRE
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = array();

    // Récupération des données du formulaire en le rendant "safe" (enlever les caractères spéciaux etc)
    $nom = trim($_POST['enterprise_name']);
    $siret = trim($_POST['enterprise_siret']);
    $email = trim($_POST['enterprise_email']);
    $adresse = trim($_POST['enterprise_adress']);
    $code_postal = trim($_POST['enterprise_zipcode']);
    $ville = trim($_POST['enterprise_city']);
    $mot_de_passe = trim($_POST['enterprise_password']);


    // Contrôle du nom
    if (empty($_POST["enterprise_name"])) {
        $errors["enterprise_name"] = "Champ obligatoire";
    } elseif (!preg_match("/^[a-zA-ZÀ-ÿ -]*$/", $_POST["enterprise_name"])) {
        $errors["enterprise_name"] = "Seules les lettres, les espaces et les tirets sont autorisés dans le champ Nom";
    }

    // Contrôle du siret
    if (empty($_POST["enterprise_siret"])) {
        $errors["enterprise_siret"] = "Champ obligatoire";
    } 

    // Contrôle de l'email
    if (empty($_POST["enterprise_email"])) {
        $errors["enterprise_email"] = "Champ obligatoire";
    } elseif (!filter_var($_POST["enterprise_email"], FILTER_VALIDATE_EMAIL)) {
        $errors["enterprise_email"] = "Le format de l'adresse email n'est pas valide";
    } elseif (Enterprise::checkMailExists($_POST["enterprise_email"])) {
        $errors["enterprise_email"] = 'mail déjà utilisé';
    }

    // Contrôle de la date de naissance
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

    // Contrôle du mot de passe
    if (empty($_POST["enterprise_password"])) {
        $errors["enterprise_password"] = "Champ obligatoire";
    } elseif (strlen($_POST["enterprise_password"]) < 8) {
        $errors["enterprise_password"] = "Le mot de passe doit contenir au moins 8 caractères";
    }

    // Contrôle de la confirmation du mot de passe
    if ($_POST["conf_mot_de_passe"] !== $_POST["conf_mot_de_passe"]) {
        $errors["conf_mot_de_passe"] = "Les mots de passe ne correspondent pas";
    }



    // Contrôle des CGU
    if (empty($_POST["cgu"]) || $_POST["cgu"] !== "on") {
        $errors["cgu"] = "Veuillez accepter les conditions générales d'utilisation pour continuer.";
    }

    // On s'assure qu'il n'y a pas d'erreur dans le formuaire
    if (empty($errors)) {

        Enterprise::create($nom, $email, $siret, $mot_de_passe, $adresse, $code_postal, $ville);
        $showform = false;

    }

    // Donne toutes les propriétés du serveur
    // var_dump($_SERVER)
}




// Affichage du formulaire ou des erreurs
include_once __DIR__ . '/../views/view-signup.php';


?>


<!-- LEXIQUE ET EXPLICATIONS UTILES -->

<!-- trim(): Cette fonction en PHP est utilisée pour supprimer les espaces (ou d'autres caractères spécifiés) du début et de la fin d'une chaîne. Cela est utile pour nettoyer les éventuels espaces en trop qui pourraient être saisis accidentellement. -->

<!-- htmlspecialchars(): Cette fonction PHP est utilisée pour convertir certains caractères spéciaux en entités HTML équivalentes. Cela est fait pour éviter les attaques par injection de code. Par exemple, si quelqu'un saisit du code HTML ou JavaScript malveillant dans le champ 'nom', cette fonction va convertir les caractères spéciaux en entités HTML, rendant le code inoffensif lorsqu'il est affiché dans une page web. -->

<!-- PDO, qui signifie PHP Data Objects, est une extension de PHP qui fournit une interface uniforme pour accéder à différentes bases de données.
Permet aux développeurs de travailler avec différentes bases de données sans avoir à modifier significativement leur code. Vous pouvez changer de SGBD simplement en ajustant la chaîne de connexion (DSN) sans toucher au reste du code.
Support multi-bases de données : PDO prend en charge plusieurs types de bases de données, notamment MySQL, PostgreSQL, SQLite, MS SQL Server, Oracle, et d'autres. Cela rend PDO particulièrement utile pour les projets qui pourraient éventuellement être déployés sur différentes plateformes de bases de données. -->

<!-- password_hash(): C'est une fonction de hachage sécurisée intégrée à PHP. Elle prend en entrée le mot de passe que vous souhaitez hacher et génère une version hachée sécurisée à stocker en base de données. -->

<!-- PASSWORD_DEFAULT: C'est une constante utilisée comme coût de hachage pour la fonction password_hash. Cette constante représente l'algorithme de hachage recommandé par défaut au moment de la mise à jour de PHP. Elle garantit que la méthode de hachage utilisée est à jour avec les meilleures pratiques de sécurité. -->