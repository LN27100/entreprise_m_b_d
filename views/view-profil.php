<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">

    <title>Profil entreprise</title>
</head>

<body>
    <?php

    // Bouton de déconnexion
    echo '<a href="../controllers/controller-signout.php" class="buttonHome2"><i class="fa-solid fa-power-off"></i>

    </a>';
    ?>
    <h1 class="titreAccueil">Portail entreprise</h1>

    <h2 class="tittleProfil">Profil entreprise</h2>

    <div class="container3">
        <div class="profile-image-container">
         
                <img src="<?= $img ?>" alt="photo de profil" class="profile-image">

            <form method="post" action="../controllers/controller-profil.php" enctype="multipart/form-data" class="file-input-container">
                <input type="file" name="profile_image" id="profile_image" accept="image/png, image/gif, image/jpeg, image/jpg" required>
                <input type="submit" value="Télécharger">
            </form>
        </div>

        <div class="profile-info">
            <p><span class="styleProfil"> Nom:</span> <?= $nom ?></p>
            <p><span class="styleProfil">Siret: </span> <?= $siret ?></p>
            <p><span class="styleProfil">Email: </span> <?= $email ?></p>
            <p><span class="styleProfil">Adresse: </span> <?= $adresse ?></p>
            <p><span class="styleProfil">Code postal: </span> <?= $code_postal ?></p>
            <p><span class="styleProfil">Ville: </span> <?= $ville ?></p>

        </div>


        <div class="contnair">
            <button id="editDescriptionBtn">Modifier le profil</button>

            <form action="../controllers/controller-profil.php" method="post" class="deleteProfil">
                <input type="hidden" name="delete_profile" value="<?= $user_id ?>">
                <button class="delete_profile" type="submit" name="delete_profile" onclick="return confirm('Voulez-vous vraiment supprimer ce profil ?')">Supprimer le profil</button>
            </form>
        </div>
    </div>

    </div>
    <div class="container6">
        <a href="../controllers/controller-home.php" class="buttonNav"><i class="bi bi-house"></i>
            Accueil</a>
        <a href="../controllers/controller-profil.php" class="buttonNav"><i class="bi bi-person"></i>
            Profil</a>
        <a href="../controllers/controller-history.php" class="buttonNav"><i class="bi bi-clock-history"></i>
            Historique</a>
    </div>

    <!-- Formulaire de modification du profil (masqué par défaut) -->
    <form method="post" action="../controllers/controller-profil.php" class="transparent-form" enctype="multipart/form-data" id="editDescriptionForm" style="display: none;">

    

        <div class="profile-info">
            <p><span class="styleProfil"> Nom:</span></p>
            <input type="text" name="user_name" placeholder="Nouveau nom" value="<?= $nom ?>">

            <!-- Affichage des erreurs pour le nom -->
            <?php if (isset($errors['user_name'])) { ?>
                <span class="error-message"><?= $errors['user_name']; ?></span>
            <?php } ?>


            <p><span class="styleProfil">Email:</span></p>
            <input type="text" name="enterprise_email" placeholder="Nouveau email" value="<?= $email ?>">

            <!-- Affichage des erreurs pour l'email -->
            <?php if (isset($errors['enterprise_email'])) { ?>
                <span class="error-message"><?= $errors['enterprise_email']; ?></span>
            <?php } ?>

            <p><span class="styleProfil"> Adresse:</span></p>
            <input type="text" name="enterprise_adress" placeholder="Nouveau nom" value="<?= $adresse ?>">

            <!-- Affichage des erreurs pour l'adresse -->
            <?php if (isset($errors['enterprise_adress'])) { ?>
                <span class="error-message"><?= $errors['enterprise_adress']; ?></span>
            <?php } ?>

            <p><span class="styleProfil"> Code postal:</span></p>
            <input type="text" name="enterprise_zipcode" placeholder="Nouveau nom" value="<?= $code_postal ?>">

            <!-- Affichage des erreurs pour le code postal -->
            <?php if (isset($errors['enterprise_zipcode'])) { ?>
                <span class="error-message"><?= $errors['enterprise_zipcode']; ?></span>
            <?php } ?>

            <p><span class="styleProfil"> Ville:</span></p>
            <input type="text" name="enterprise_city" placeholder="Nouveau nom" value="<?= $ville ?>">

            <!-- Affichage des erreurs pour le code postal -->
            <?php if (isset($errors['enterprise_city'])) { ?>
                <span class="error-message"><?= $errors['enterprise_city']; ?></span>
            <?php } ?>



           

        


            <div class="profile-info">
                <input type="submit" name="save_modification" value="Enregistrer" class="file-input-button">
                <button type="button" id="cancelEditBtn" class="file-input-button">Annuler</button>
            </div>
    </form>



    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const navbarToggle = document.getElementById("navbar-toggle");
            const navbarNav = document.getElementById("navbar-nav");

            if (navbarToggle && navbarNav) {
                navbarToggle.addEventListener("click", function() {
                    navbarNav.classList.toggle("active");
                });
            }

            document.getElementById('editDescriptionBtn').addEventListener('click', function() {
                // Masquer la div avec la classe profile-info
                document.querySelector('.profile-info').style.display = 'none';
                // Afficher le formulaire de modification
                document.getElementById('editDescriptionForm').style.display = 'block';
            });

            // Afficher le formulaire de modification si des erreurs sont présentes
            if (<?= !empty($errors) ? 'true' : 'false' ?>) {
                document.getElementById('editDescriptionForm').style.display = 'block';
                document.querySelector('.profile-info').style.display = 'none';
            }

            document.getElementById('cancelEditBtn').addEventListener('click', function() {
                // Afficher à nouveau la div avec la classe profile-info
                document.querySelector('.profile-info').style.display = 'block';
                // Masquer le formulaire de modification
                document.getElementById('editDescriptionForm').style.display = 'none';
            });
        });
    </script>


</body>

</html>