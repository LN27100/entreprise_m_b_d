<!DOCTYPE html>
<html lang="fr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="description" content="">
    <title>Dashboard - Entreprise</title>
    <!-- Materialize CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <!-- api charts js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js"></script>

</head>

<body class="has-fixed-sidenav #01579b light-blue darken-4">
    <header>
        <nav class="cyan lighten-5">
            <div class="nav-wrapper">
                <a href="../controllers/controller-signout.php" class="right buttonHome2 hoverable">Déconnexion</a>
                <a href="../controllers/controller-home.php" class="logo-container indigo-text"><?= $nom ?></a>
                <a href="../controllers/controller-home.php" class="right buttonallUser hoverable">Retour</a>

            </div>
        </nav>
        <ul id="sidenav-left" class="sidenav sidenav-fixed #e0f7fa cyan lighten-5">
            <li><a href="../controllers/controller-home.php" class="logo-container"><?= $nom ?></a></li>
            <div class="container3 #607d8b blue-grey">
                <div class="profile-image-container">
                    <img src="<?= $img ?>" alt="photo de profil" class="profile-image">
                    <form method="post" action="../controllers/controller-home.php" enctype="multipart/form-data" class="file-input-container">
                        <input type="file" name="profile_image" id="profile_image" accept="image/png, image/gif, image/jpeg, image/jpg" required>
                        <input type="submit" value="Télécharger">
                    </form>
                </div>
                <div class="profile-info">
                    <p class="cyan-text text-lighten-5"><span class="styleProfil indigo-text text-darken-4"> Nom:</span> <?= $nom ?></p>
                    <p class="cyan-text text-lighten-5"><span class="styleProfil indigo-text text-darken-4">Siret: </span> <?= $siret ?></p>
                    <p class="cyan-text text-lighten-5"><span class="styleProfil indigo-text text-darken-4">Email: </span> <?= $email ?></p>
                    <p class="cyan-text text-lighten-5"><span class="styleProfil indigo-text text-darken-4">Adresse: </span> <?= $adresse ?></p>
                    <p class="cyan-text text-lighten-5"><span class="styleProfil indigo-text text-darken-4">Code postal: </span> <?= $code_postal ?></p>
                    <p class="cyan-text text-lighten-5"><span class="styleProfil indigo-text text-darken-4">Ville: </span> <?= $ville ?></p>
                </div>
                <div class="contnair">
                    <button class="hoverable" id="editDescriptionBtn">Modifier le profil</button>
                    <form action="../controllers/controller-home.php" method="post" class="deleteProfil">
                        <input type="hidden" name="delete_profile" value="<?= $enterprise_id ?>">
                        <button class="delete_profile hoverable" type="submit" name="delete_profile" onclick="return confirm('Voulez-vous vraiment supprimer ce profil ?')">Supprimer le profil
                        </button>
                    </form>
                </div>
            </div>
            <!-- Formulaire de modification du profil (masqué par défaut) -->
            <form method="post" action="/controllers/controller-home.php" class="transparent-form" enctype="multipart/form-data" id="editDescriptionForm" style="display: none;">
                <div class="profile-info">
                    <p><span class="styleProfil"> Nom:</span></p>
                    <input type="text" name="enterprise_name" placeholder="Nouveau nom" value="<?= $nom ?>">
                    <!-- Affichage des erreurs pour le nom -->
                    <?php if (isset($errors['enterprise_name'])) { ?>
                        <span class="error-message"><?= $errors['enterprise_name']; ?></span>
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
                        <button type="button" id="cancelEditBtn" class="file-input-button">Annuler<br></button>
                    </div>
                </div>
            </form>
        </ul>
    </header>

    <main>
        <div class="container">
            <div class="row">
                <div class="col s12 m8">
                    <div class="masonry row">
                        <div class="col s12">
                            <h2 class="blue-grey-text darken-3">Dashboard <?= $nom ?></h2>
                        </div>


                        <div class="col s12">
                            <div class="card #78909c blue-grey lighten-1">
                                <div class="card-content cyan-text text-lighten-5">
                                    <span class="Allusers card-title center-align">Tous les utilisateurs</span>
                                    <div class="card-metric  ">
                                        <?php if (!empty($allPersonns['status']) && $allPersonns['status'] === 'success') : ?>
                                            <?php foreach ($allPersonns['all_users'] as $user) : ?>
                                                <div class="user-profile">
                                                    <?php if (!empty($user['user_photo'])) : ?>
                                                        <img src="http://metro_boulot_dodo.test/assets/uploads/<?= $user['user_photo'] ?>" class="profile-image" alt="User Photo">
                                                    <?php else : ?>
                                                        <img src="../assets/img/avatarDefault.jpg" class="profile-image" alt="Default Avatar">
                                                    <?php endif; ?>
                                                    <p><?= isset($user['user_pseudo']) ? $user['user_pseudo'] : 'Utilisateur sans nom' ?> /
                                                        <?= isset($user['user_email']) ? $user['user_email'] : 'Utilisateur sans mail' ?></p>

                                                    <!-- Switch -->
                                                    <div class="switch">
                                                        <label class="switches">
                                                            Suspendu
                                                            <input type="checkbox" name="user_validation" data-user-id="<?= $user['user_id'] ?>" 
                                                            <?= $user['user_validate'] == 1 ? 'checked' : '' ?>>
                                                            <span class="lever"></span>
                                                            Validé
                                                        </label>
                                                    </div>



                                                </div>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <p>Aucun utilisateur trouvé.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
    </main>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>

        document.addEventListener('click', e => {
            // e.target.type permet de cibler la checkbox
            if(e.target.type== 'checkbox'){
                // true false s'affiche dans la console au click de la checkbox
                // console.log(e.target.checked);
                // récupération de l'id utilisateur (user-id...le dataSet récupère avec la majuscule userId)
                // console.log(e.target.dataset.userId);
                if(e.target.checked==false) {
                    fetch(`controller-ajax.php?invalidate=${e.target.dataset.userId}`);
                } else {
                    fetch(`controller-ajax.php?validate=${e.target.dataset.userId}`);

                }
            }
        })




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