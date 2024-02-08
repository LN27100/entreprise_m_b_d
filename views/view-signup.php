<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">

    <title>Inscription pro</title>
</head>

<body>
    <div class="container">
        <h1 class="center-align">Formulaire d'inscription pro</h1>
        <form class="row" method="POST" action="../controllers/controller-signup.php" novalidate>

            <div class="input-field col s12 m4">
                <input id="enterprise_name" type="text" class="validate <?php if (isset($errors['enterprise_name'])) echo 'invalid'; ?>" name="enterprise_name" placeholder="Nom de l'entreprise" value="<?= isset($_POST['enterprise_name']) ? htmlspecialchars($_POST['enterprise_name']) : '' ?>" required>
                <label for="enterprise_name">Nom d'entreprise:</label>
                <span class="helper-text" data-error="<?php echo isset($errors['enterprise_name']) ? $errors['enterprise_name'] : ''; ?>"></span>
            </div>

            <div class="input-field col s12 m4">
                <input id="enterprise_siret" type="text" class="validate <?php if (isset($errors['enterprise_siret'])) echo 'invalid'; ?>" name="enterprise_siret" placeholder="Numéro de Siret" value="<?= isset($_POST['enterprise_siret']) ? htmlspecialchars($_POST['enterprise_siret']) : '' ?>" required>
                <label for="enterprise_siret">Numéro de Siret:</label>
                <span class="helper-text" data-error="<?php echo isset($errors['enterprise_siret']) ? $errors['enterprise_siret'] : ''; ?>"></span>
            </div>

            <div class="input-field col s12 m4">
                <input id="enterprise_adress" type="text" class="validate <?php if (isset($errors['enterprise_adress'])) echo 'invalid'; ?>" name="enterprise_adress" placeholder="Adresse de l'entreprise" value="<?= isset($_POST['enterprise_adress']) ? htmlspecialchars($_POST['enterprise_adress']) : '' ?>" required>
                <label for="enterprise_adress">Adresse de l'entreprise:</label>
                <span class="helper-text" data-error="<?php echo isset($errors['enterprise_adress']) ? $errors['enterprise_adress'] : ''; ?>"></span>
            </div>

            <div class="input-field col s12 m4">
                <input id="enterprise_zipcode" type="text" class="validate <?php if (isset($errors['enterprise_zipcode'])) echo 'invalid'; ?>" name="enterprise_zipcode" placeholder="Code postal" value="<?= isset($_POST['enterprise_zipcode']) ? htmlspecialchars($_POST['enterprise_zipcode']) : '' ?>" required>
                <label for="enterprise_zipcode">Code postal:</label>
                <span class="helper-text" data-error="<?php echo isset($errors['enterprise_zipcode']) ? $errors['enterprise_zipcode'] : ''; ?>"></span>
            </div>

            <div class="input-field col s12 m4">
                <input id="enterprise_city" type="text" class="validate <?php if (isset($errors['enterprise_city'])) echo 'invalid'; ?>" name="enterprise_city" placeholder="Ville" value="<?= isset($_POST['enterprise_city']) ? htmlspecialchars($_POST['enterprise_city']) : '' ?>" required>
                <label for="enterprise_city">Ville:</label>
                <span class="helper-text" data-error="<?php echo isset($errors['enterprise_city']) ? $errors['enterprise_city'] : ''; ?>"></span>
            </div>

            <div class="input-field col s12 m6">
                <input id="email" type="email" class="validate <?php if (isset($errors['enterprise_email'])) echo 'invalid'; ?>" name="enterprise_email" placeholder="Adresse email" value="<?= isset($_POST['enterprise_email']) ? htmlspecialchars($_POST['enterprise_email']) : '' ?>" required>
                <label for="email">Email:</label>
                <span class="helper-text" data-error="<?php echo isset($errors['enterprise_email']) ? $errors['enterprise_email'] : ''; ?>"></span>
            </div>

               <div class="input-field col s12 m6">
                <input id="enterprise_password" type="password" class="validate" name="enterprise_password" required>
                <label for="enterprise_password">Mot de passe:</label>
                <i class="material-icons suffix" style="cursor:pointer" onclick="togglePasswordVisibility()">remove_red_eye</i>
                <ul class="requirements">
                    <li class="leng hide"><span class="bi bi-x"></span> 8 caractères minimum</li>
                    <li class="big-letter hide"><span class="bi bi-x"></span> Au moins une lettre majuscule</li>
                    <li class="num hide"><span class="bi bi-x"></span> Au moins un chiffre</li>
                    <li class="special-char hide"><span class="bi bi-x"></span> Au moins un caractère spécial</li>
                </ul>
                <div id="password-alert" class="alert alert-warning hide">
                    Le mot de passe doit contenir au moins 8 caractères, une lettre majuscule, un chiffre et un caractère spécial.
                </div>
            </div>

            <!-- Champ de confirmation du mot de passe -->
            <div class="input-field col s12 m6">
                <input id="confirm_password" type="password" class="validate" name="confirm_password" required>
                <label for="confirm_password">Confirmer Mot de passe:</label>
            </div>

            <!-- Checkbox pour les CGU -->
            <div class="center-align">
                <label>
                    <input type="checkbox" class="filled-in" required>
                    <span>J'accepte les conditions d'utilisation</span>
                </label>
            </div>

            <!-- Bouton de soumission du formulaire -->
            <div class="center-align">
                <button class="btn waves-effect waves-light" type="submit" id="submitButton">S'enregistrer</button>
            </div>

            <!-- Lien pour se connecter -->
            <div class="center-align">
                <p>Déjà inscrit? <a href="../controllers/controller-signin.php">Connectez-vous!</a></p>
            </div>

        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            console.log("Le DOM est chargé. Le script fonctionne.");

            const password = document.getElementById("enterprise_password");
            const confirmPassword = document.getElementById("confirm_password");
            const passwordAlert = document.getElementById("password-alert");

            const requirements = document.querySelectorAll(".requirements li");
            const leng = document.querySelector(".leng");
            const bigLetter = document.querySelector(".big-letter");
            const num = document.querySelector(".num");
            const specialChar = document.querySelector(".special-char");

            password.addEventListener("input", () => {
                const value = password.value;
                const isLengthValid = value.length >= 8;
                const hasUpperCase = /[A-Z]/.test(value);
                const hasNumber = /\d/.test(value);
                const hasSpecialChar = /[!@#$%^&*()\[\]{}\\|;:'",<.>/?`~]/.test(value);

                leng.classList.toggle("hide", isLengthValid);
                bigLetter.classList.toggle("hide", hasUpperCase);
                num.classList.toggle("hide", hasNumber);
                specialChar.classList.toggle("hide", hasSpecialChar);

                const isPasswordValid = isLengthValid && hasUpperCase && hasNumber && hasSpecialChar;
                const isPasswordMatching = password.value === confirmPassword.value;

                if (confirmPassword.value.length > 0) {
                    confirmPassword.classList.toggle("invalid", !isPasswordMatching);
                    confirmPassword.classList.toggle("valid", isPasswordMatching);
                }

                password.classList.toggle("invalid", !isPasswordValid);
                passwordAlert.classList.toggle("alert-warning", !isPasswordValid);
                passwordAlert.classList.toggle("alert-success", isPasswordValid);
            });

            confirmPassword.addEventListener("input", () => {
                const isPasswordMatching = password.value === confirmPassword.value;
                confirmPassword.classList.toggle("invalid", !isPasswordMatching);
                confirmPassword.classList.toggle("valid", isPasswordMatching);
            });

            function togglePasswordVisibility() {
                var passwordInput = document.getElementById('enterprise_password');
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                } else {
                    passwordInput.type = 'password';
                }
            }
        });
    </script>
</body>

</html>