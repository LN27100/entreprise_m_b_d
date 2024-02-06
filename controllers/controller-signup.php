<?php

//lier le fichier config
require_once '../config.php';
require_once '../models/Userprofil.php';
require_once '../models/Enterprise.php';


// permet d'afficher le formulaire
$showform = true;

// VERIFICATION DE LA SOUMISSION DU FORMULAIRE
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = array();

    // Récupération des données du formulaire en le rendant "safe" (enlever les caractères spéciaux etc)
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $pseudo = trim($_POST['pseudo']);
    $date_naissance = trim($_POST['date_naissance']);
    $email = trim($_POST['email']);
    $mot_de_passe = trim($_POST['mot_de_passe']);
    $enterprise_id = trim($_POST['entreprise']);


    // Contrôle du nom
    if (empty($_POST["nom"])) {
        $errors["nom"] = "Champ obligatoire";
    } elseif (!preg_match("/^[a-zA-ZÀ-ÿ -]*$/", $_POST["nom"])) {
        $errors["nom"] = "Seules les lettres, les espaces et les tirets sont autorisés dans le champ Nom";
    }

    // Contrôle du prénom
    if (empty($_POST["prenom"])) {
        $errors["prenom"] = "Champ obligatoire";
    } elseif (!preg_match("/^[a-zA-ZÀ-ÿ -]*$/", $_POST["prenom"])) {
        $errors["prenom"] = "Seules les lettres, les espaces et les tirets sont autorisés dans le champ Prénom";
    }

    // Contrôle du pseudo
    if (empty($_POST["pseudo"])) {
        $errors["pseudo"] = "Champ obligatoire";
    } elseif (!preg_match("/^[a-zA-ZÀ-ÿ\d]+$/", $_POST["pseudo"])) {
        $errors["pseudo"] = "Seules les lettres et les chiffres sont autorisés dans le champ Pseudo";
    } elseif (strlen($_POST["pseudo"]) < 6) {
        $errors["pseudo"] = "Le pseudo doit contenir au moins 6 caractères";
    } elseif (Userprofil::checkPseudoExists($_POST["pseudo"])) {
        $errors["pseudo"] = 'Pseudo déjà utilisé';
    }

    // Contrôle de l'email
    if (empty($_POST["email"])) {
        $errors["email"] = "Champ obligatoire";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Le format de l'adresse email n'est pas valide";
    } elseif (Userprofil::checkMailExists($_POST["email"])) {
        $errors["email"] = 'mail déjà utilisé';
    }

    // Contrôle de la date de naissance
    if (empty($_POST["date_naissance"])) {
        $errors["date_naissance"] = "Champ obligatoire";
    }

    // Contrôle du mot de passe
    if (empty($_POST["mot_de_passe"])) {
        $errors["mot_de_passe"] = "Champ obligatoire";
    } elseif (strlen($_POST["mot_de_passe"]) < 8) {
        $errors["mot_de_passe"] = "Le mot de passe doit contenir au moins 8 caractères";
    }

    // Contrôle de la confirmation du mot de passe
    if ($_POST["mot_de_passe"] !== $_POST["conf_mot_de_passe"]) {
        $errors["conf_mot_de_passe"] = "Les mots de passe ne correspondent pas";
    }



    // Contrôle des CGU
    if (empty($_POST["cgu"]) || $_POST["cgu"] !== "on") {
        $errors["cgu"] = "Veuillez accepter les conditions générales d'utilisation pour continuer.";
    }

    // On s'assure qu'il n'y a pas d'erreur dans le formuaire
    if (empty($errors)) {

        Userprofil::create($nom, $prenom, $pseudo, $date_naissance, $email, $mot_de_passe, $enterprise_id, 1);
        $showform = false;

    }

    // Donne toutes les propriétés du serveur
    // var_dump($_SERVER)
}
$allEnterprises = Enterprise::getAllEnterprises();




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