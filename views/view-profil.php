<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">

    <title>Votre profil</title>
</head>

<body>
    <?php

    // Bouton de déconnexion
    echo '<a href="../controllers/controller-signout.php" class="buttonHome2"><i class="fa-solid fa-power-off"></i>

    </a>';
    ?>
    <h1 class="titreAccueil">Eco'Mouv !!</h1>

    <h2 class="tittleProfil">Votre profil</h2>

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
            <p><span class="styleProfil">Prenom: </span> <?= $prenom ?></p>
            <p><span class="styleProfil">Pseudo:</span> <?= $pseudo ?></p>

            <div class="profile-info">
                <p class="styleProfil">Description:</p>
                <div id="descriptionDisplay">
                    <?php echo isset($_SESSION['user']['user_describ']) ? html_entity_decode($_SESSION['user']['user_describ']) : "Aucune description disponible"; ?>
                </div>
            </div>

            <p><span class="styleProfil">Date de naissance: </span> <?= empty($date_naissance) ? "Non définie" : date('d/m/Y', strtotime($date_naissance)) ?></p>
            <p><span class="styleProfil">Email: </span> <?= $email ?></p>
            <p><span class="styleProfil">Entreprise: </span><?= $entreprise ?></p>
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
            <p class="styleProfil">Modifier votre description:</p>
            <textarea id="user_describ" name="user_describ" rows="5" cols="33"><?= isset($_SESSION['user']['user_describ']) ? ($_SESSION['user']['user_describ']) : "" ?></textarea>
        </div>

        <div class="profile-info">
            <p><span class="styleProfil"> Nom:</span></p>
            <input type="text" name="user_name" placeholder="Nouveau nom" value="<?= $nom ?>">

            <!-- Affichage des erreurs pour le nom -->
            <?php if (isset($errors['user_name'])) { ?>
                <span class="error-message"><?= $errors['user_name']; ?></span>
            <?php } ?>

            <p><span class="styleProfil"> Prénom:</span></p>
            <input type="text" name="user_firstname" placeholder="Nouveau prénom" value="<?= $prenom ?>">

            <!-- Affichage des erreurs pour le prénom -->
            <?php if (isset($errors['user_firstname'])) { ?>
                <span class="error-message"><?= $errors['user_firstname']; ?></span>
            <?php } ?>

            <p><span class="styleProfil">Pseudo:</span></p>
            <input type="text" name="user_pseudo" placeholder="Nouveau pseudo" value="<?= $pseudo ?>">

            <!-- Affichage des erreurs pour le pseudo -->
            <?php if (isset($errors['user_pseudo'])) { ?>
                <span class="error-message"><?= $errors['user_pseudo']; ?></span>
            <?php } ?>

            <p><span class="styleProfil">Email:</span></p>
            <input type="text" name="user_email" placeholder="Nouveau email" value="<?= $email ?>">

            <!-- Affichage des erreurs pour l'email -->
            <?php if (isset($errors['user_email'])) { ?>
                <span class="error-message"><?= $errors['user_email']; ?></span>
            <?php } ?>


            <p><span class="styleProfil"> Date de naissance:</span></p>
            <input type="date" name="user_dateofbirth" placeholder="Nouvelle date de naissance" value="<?= $date_naissance ?>">

            <!-- Affichage des erreurs pour la date de naissance -->
            <?php if (isset($errors['user_dateofbirth'])) { ?>
                <span class="error-message"><?= $errors['user_dateofbirth']; ?></span>
            <?php } ?>

            <p><span class="styleProfil">Entreprise:</span></p>
            <select class="form-select" aria-label="Default select example" name="new_enterprise" id="new_enterprise">
                <option value="" selected disabled>Sélectionnez une entreprise</option>
                <?php foreach ($allEnterprises as $enterprise) { ?>
                    <option value="<?= $enterprise['enterprise_id'] ?>" <?= $enterprise['enterprise_id'] == $_SESSION['user']['enterprise_id'] ? 'selected' : '' ?>><?= $enterprise['enterprise_name'] ?></option>
                <?php } ?>
            </select>


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