<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">

    <title>Connexion pro</title>
</head>

<body>

    <?php

    ?>
    <h1>Portail entreprise</h1>

    <h2>Veuillez vous connecter</h2>
    <div class="container2">
        <form class="row" method="POST" action="../controllers/controller-signin.php" novalidate>

            <div class="form-group col-md-6">
                <label for="enterprise_email" class="form-label">Email : </label>
                <input type="email" class="form-control <?php if (isset($errors['enterprise_email'])) echo 'is-invalid'; ?>" id="validationServerEmail" name="enterprise_email" placeholder="adresse email" value="<?= isset($_POST['enterprise_email']) ? htmlspecialchars($_POST['enterprise_email']) : '' ?>" required>
                <div class="invalid-feedback" id="emailValidationFeedback">
                    <?php
                    echo isset($errors['enterprise_email']) ? $errors['enterprise_email'] : "Champ obligatoire";
                    ?>
                </div>
            </div>

            <div class="form-group col-md-12">
                <label for="enterprise_password" class="form-label">Mot de passe : </label>
                <div class="input-group d-flex position-relative">
                    <input type="password" class="form-control rounded mt-1 password-input <?php if (isset($errors['enterprise_password'])) echo 'is-invalid'; ?>" name="enterprise_password" placeholder="Votre mot de passe" aria-label="password" aria-describedby="password" id="validationServerPassword">
                    <i class="bi bi-eye password-toggle-icon" onclick="togglePasswordVisibility()"></i>
                    <div class="invalid-feedback" id="passwordValidationFeedback">
                        <?php
                        echo isset($errors['enterprise_password']) ? $errors['enterprise_password'] : "Champ obligatoire";
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