<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">

    <title>Connexion</title>
</head>

<body>

    <?php

    ?>
    <h1>Eco'Mouv !!</h1>

    <h2>Veuillez vous connecter</h2>
    <div class="container2">
        <form class="row" method="POST" action="../controllers/controller-signin.php" novalidate>

            <div class="form-group col-md-6">
                <label for="email" class="form-label">Email : </label>
                <input type="email" class="form-control <?php if (isset($errors['email'])) echo 'is-invalid'; ?>" id="validationServerEmail" name="email" placeholder="adresse email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" required>
                <div class="invalid-feedback" id="emailValidationFeedback">
                    <?php
                    echo isset($errors['email']) ? $errors['email'] : "Champ obligatoire";
                    ?>
                </div>
            </div>

            <div class="form-group col-md-12">
                <label for="password-input" class="form-label">Mot de passe : </label>
                <div class="input-group d-flex position-relative">
                    <input type="password" class="form-control rounded mt-1 password-input <?php if (isset($errors['mot_de_passe'])) echo 'is-invalid'; ?>" name="mot_de_passe" placeholder="Votre mot de passe" aria-label="password" aria-describedby="password" id="validationServerPassword">
                    <i class="bi bi-eye password-toggle-icon" onclick="togglePasswordVisibility()"></i>
                    <div class="invalid-feedback" id="passwordValidationFeedback">
                        <?php
                        echo isset($errors['mot_de_passe']) ? $errors['mot_de_passe'] : "Champ obligatoire";
                        ?>
                    </div>
                </div>
            </div>


            <div class="text-center">
                <button class="button" type="submit" id="submitButton">Se connecter</button>
            </div>

            <div class="text-center">
                <p>Pas encore membre?</p>
                <a href="../controllers/controller-signup.php">Inscrivez-vous!</a>
            </div>

            <div class="text-center">
                <p>------------------------</p>
                <a href="../controllers/controller-adminsignin.php">Compte administrateur</a>
            </div>

        </form>
    </div>


    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById('validationServerPassword');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        }
    </script>
</body>

</html>