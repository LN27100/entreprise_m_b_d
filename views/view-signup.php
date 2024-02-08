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
    <?php if ($showform) : ?>
        <h1 class="center-align">Formulaire d'inscription pro</h1>
    <?php endif; ?>
    <div class="container">
        <?php
        if ($showform) {
        ?>
            <form class="row" method="POST" action="../controllers/controller-signup.php" novalidate>
                <div class="input-field col s12 m4">
                    <input id="enterprise_name" type="text" class="validate <?php if (isset($errors['enterprise_name'])) echo 'invalid'; ?>" name="enterprise_name" placeholder="ex.Afpa" value="<?= isset($_POST['enterprise_name']) ? htmlspecialchars($_POST['enterprise_name']) : '' ?>" required>
                    <label for="enterprise_name">Nom d'entreprise:</label>
                    <span class="helper-text" data-error="<?php echo isset($errors['enterprise_name']) ? $errors['enterprise_name'] : ''; ?>"></span>
                </div>

                <div class="input-field col s12 m4">
                    <input id="enterprise_siret" type="text" class="validate <?php if (isset($errors['enterprise_siret'])) echo 'invalid'; ?>" name="enterprise_siret" placeholder="numéro siret" value="<?= isset($_POST['enterprise_siret']) ? htmlspecialchars($_POST['enterprise_siret']) : '' ?>" required>
                    <label for="enterprise_siret">Numéro de Siret:</label>
                    <span class="helper-text" data-error="<?php echo isset($errors['enterprise_siret']) ? $errors['enterprise_siret'] : ''; ?>"></span>
                </div>

                <div class="input-field col s12 m4">
                    <input id="enterprise_adress" type="text" name="enterprise_adress" value="<?= isset($_POST['enterprise_adress']) ? htmlspecialchars($_POST['enterprise_adress']) : '' ?>" class="validate <?php if (isset($errors['enterprise_adress'])) echo 'invalid'; ?>" required>
                    <label for="enterprise_adress">Adresse entreprise:</label>
                    <span class="helper-text" data-error="<?php echo isset($errors['enterprise_adress']) ? $errors['enterprise_adress'] : ''; ?>"></span>
                </div>

                <div class="input-field col s12 m4">
                    <input id="enterprise_zipcode" type="text" name="enterprise_zipcode" value="<?= isset($_POST['enterprise_zipcode']) ? htmlspecialchars($_POST['enterprise_zipcode']) : '' ?>" class="validate <?php if (isset($errors['enterprise_zipcode'])) echo 'invalid'; ?>" required>
                    <label for="enterprise_zipcode">Code postal:</label>
                    <span class="helper-text" data-error="<?php echo isset($errors['enterprise_zipcode']) ? $errors['enterprise_zipcode'] : ''; ?>"></span>
                </div>

                <div class="input-field col s12 m4">
                    <input id="enterprise_city" type="text" name="enterprise_city" value="<?= isset($_POST['enterprise_city']) ? htmlspecialchars($_POST['enterprise_city']) : '' ?>" class="validate <?php if (isset($errors['enterprise_city'])) echo 'invalid'; ?>" required>
                    <label for="enterprise_city">Ville:</label>
                    <span class="helper-text" data-error="<?php echo isset($errors['enterprise_city']) ? $errors['enterprise_city'] : ''; ?>"></span>
                </div>

                <div class="input-field col s12 m6">
                    <input id="email" type="email" class="validate <?php if (isset($errors['enterprise_email'])) echo 'invalid'; ?>" name="enterprise_email" placeholder="adresse email" value="<?= isset($_POST['enterprise_email']) ? htmlspecialchars($_POST['enterprise_email']) : '' ?>" required>
                    <label for="email">Email:</label>
                    <span class="helper-text" data-error="<?php echo isset($errors['enterprise_email']) ? $errors['enterprise_email'] : ''; ?>"></span>
                </div>

                <div class="input-field col s12 m12">
                    <input id="enterprise_password" type="password" class="validate <?php if (isset($errors['enterprise_password'])) echo 'invalid'; ?>" name="enterprise_password" placeholder="Votre mot de passe" required>
                    <label for="enterprise_password">Mot de passe:</label>
                    <span class="helper-text" data-error="<?php echo isset($errors['enterprise_password']) ? $errors['enterprise_password'] : ''; ?>"></span>
                    <i class="material-icons suffix" style="cursor:pointer" onclick="togglePasswordVisibility()">remove_red_eye</i>
                </div>

                <!-- Code pour la confirmation du mot de passe -->
                <div class="input-field col s12 m12">
                    <input id="confirm_password" type="password" class="validate <?php if (isset($errors['conf_mot_de_passe'])) echo 'invalid'; ?>" name="conf_mot_de_passe" placeholder="Confirmez votre mot de passe" required>
                    <label for="confirm_password">Confirmer Mot de passe:</label>
                    <span class="helper-text" data-error="<?php echo isset($errors['conf_mot_de_passe']) ? $errors['conf_mot_de_passe'] : ''; ?>"></span>
                </div>

                <p class="center-align">J'accepte les conditions d'utilisation</p>
                <div class="center-align">
                    <label>
                        <input type="checkbox" class="filled-in" required>
                        <span></span>
                    </label>
                </div>

                <div class="center-align">
                    <button class="btn waves-effect waves-light" type="submit" id="submitButton">S'enregistrer</button>
                </div>

                <p class="center-align returnConnexion">------------------------</p>

                <div class="center-align">
                    <label for="submitButton" class="retoutCo">Déjà inscrit?</label>
                </div>

                <div class="center-align">
                    <a href="../controllers/controller-signin.php" class="btn buttonRetourCo">Connexion</a>
                </div>
            </form>
        <?php } else { ?>
            <h2 class="center-align">Inscription réussie</h2>
            <p class="center-align"><strong><em>Vous pouvez maintenant vous connecter.</em></strong></p>
            <div class="center-align">
                <a href="../controllers/controller-signin.php" class="btn button">Connexion</a>
            </div>
        <?php } ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <script>
document.addEventListener("DOMContentLoaded", function() {
    console.log("Le DOM est chargé. Le script fonctionne.");
    const password = document.getElementById("password-input");
    const confirmPassword = document.getElementById("confirm-password-input");
    const passwordAlert = document.getElementById("password-alert");

    const requirements = document.querySelectorAll(".requirements");
    const leng = document.querySelector(".leng");
    const bigLetter = document.querySelector(".big-letter");
    const num = document.querySelector(".num");
    const specialChar = document.querySelector(".special-char");
    requirements.forEach((element) => element.classList.add("wrong"));
    password.addEventListener("focus", () => {
        passwordAlert.classList.remove("d-none");
        if (!password.classList.contains("is-valid")) {
            password.classList.add("is-invalid");
        }
    });
    password.addEventListener("input", () => {
        const value = password.value;
        const isLengthValid = value.length >= 8;
        const hasUpperCase = /[A-Z]/.test(value);
        const hasNumber = /\d/.test(value);
        const hasSpecialChar = /[!@#$%^&*()\[\]{}\\|;:'",<.>/?`~]/.test(value);
        leng.querySelector(".bi-x").classList.toggle("d-none", isLengthValid);
        leng.querySelector(".bi-check").classList.toggle("d-none", !isLengthValid);
        bigLetter.querySelector(".bi-x").classList.toggle("d-none", hasUpperCase);
        bigLetter.querySelector(".bi-check").classList.toggle("d-none", !hasUpperCase);
        num.querySelector(".bi-x").classList.toggle("d-none", hasNumber);
        num.querySelector(".bi-check").classList.toggle("d-none", !hasNumber);
        specialChar.querySelector(".bi-x").classList.toggle("d-none", hasSpecialChar);
        specialChar.querySelector(".bi-check").classList.toggle("d-none", !hasSpecialChar);
        const isPasswordValid = isLengthValid && hasUpperCase && hasNumber && hasSpecialChar;
        const isPasswordMatching = password.value === confirmPassword.value;
        if (confirmPassword.value.length > 0) {
            if (isPasswordMatching) {
                confirmPassword.classList.remove("is-invalid");
                confirmPassword.classList.add("is-valid");
                confirmPassword.nextElementSibling.classList.remove("invalid-feedback");
                confirmPassword.nextElementSibling.classList.add("valid-feedback");
            } else {
                confirmPassword.classList.remove("is-valid");
                confirmPassword.classList.add("is-invalid");
                confirmPassword.nextElementSibling.classList.remove("valid-feedback");
                confirmPassword.nextElementSibling.classList.add("invalid-feedback");
            }
        }
        if (isPasswordValid) {
            password.classList.remove("is-invalid");
            password.classList.add("is-valid");
            requirements.forEach((element) => {
                element.classList.add("good");
            });
            passwordAlert.classList.remove("alert-warning");
            passwordAlert.classList.add("alert-success");
        } else {
            password.classList.remove("is-valid");
            password.classList.add("is-invalid");
            passwordAlert.classList.add("alert-warning");
            passwordAlert.classList.remove("alert-success");
        }
    });
    confirmPassword.addEventListener("input", () => {
        const isPasswordMatching = password.value === confirmPassword.value;
        if (confirmPassword.value.length > 0) {
            if (isPasswordMatching) {
                confirmPassword.classList.remove("is-invalid");
                confirmPassword.classList.add("is-valid");
                confirmPassword.nextElementSibling.innerText = "Les mots de passe sont identiques";
                confirmPassword.nextElementSibling.classList.remove("invalid-feedback");
                confirmPassword.nextElementSibling.classList.add("valid-feedback");
            } else {
                confirmPassword.classList.remove("is-valid");
                confirmPassword.classList.add("is-invalid");
                confirmPassword.nextElementSibling.innerText = "Les mots de passe ne sont pas identiques";
                confirmPassword.nextElementSibling.classList.remove("valid-feedback");
                confirmPassword.nextElementSibling.classList.add("invalid-feedback");
            }
        }
    });
    password.addEventListener("blur", () => {
        passwordAlert.classList.add("d-none");
    });
    const nomInput = document.getElementById("validationServer01");
    const prenomInput = document.getElementById("validationServer02");
    const pseudoInput = document.getElementById("validationServer03");
    const emailInput = document.getElementById("email");
    const dateInput = document.getElementById("start");
    const nomFeedback = document.getElementById("nomValidationFeedback");
    const prenomFeedback = document.getElementById("prenomValidationFeedback");
    const pseudoFeedback = document.getElementById("pseudoValidationFeedback");
    const emailFeedback = document.getElementById("emailValidationFeedback");
    const dateFeedback = document.getElementById("dateValidationFeedback");
    const entrepriseSelect = document.getElementById("entreprise");
    const entrepriseFeedback = document.getElementById("entrepriseValidationFeedback");
    entrepriseSelect.addEventListener("input", function() {
        toggleValidity(entrepriseSelect, entrepriseFeedback);
    });
    nomInput.addEventListener("input", function() {
        toggleValidity(nomInput, nomFeedback, /^[a-zA-ZÀ-ÿ -]*$/, "Seules les lettres, les espaces et les tirets sont autorisés dans le champ Nom");
    });
    prenomInput.addEventListener("input", function() {
        toggleValidity(prenomInput, prenomFeedback, /^[a-zA-ZÀ-ÿ -]*$/, "Seules les lettres, les espaces et les tirets sont autorisés dans le champ Prénom");
    });
    dateInput.addEventListener("input", function() {
        toggleValidity(dateInput, dateFeedback);
    });
    function toggleValidity(input, feedback, regex, errorMessage) {
        if (input.id === "entreprise" && input.value !== "") {
            input.classList.remove("is-invalid");
            input.classList.add("is-valid");
            feedback.style.display = "none";
        } else if (input.validity.valid && input.value.match(regex)) {
            input.classList.remove("is-invalid");
            input.classList.add("is-valid");
            feedback.style.display = "none";
        } else {
            input.classList.remove("is-valid");
            input.classList.add("is-invalid");
            feedback.style.display = "block";
            feedback.innerText = errorMessage || "Champ obligatoire";
        }
    }
    pseudoInput.addEventListener("input", function() {
        toggleValidity(pseudoInput, pseudoFeedback, /^[a-zA-ZÀ-ÿ\d]+$/, "Seules les lettres et les chiffres sont autorisés dans le champ Pseudo");
        if (pseudoInput.value.length < 6) {
            formIsValid = false;
            toggleValidity(pseudoInput, pseudoFeedback, null, "Le pseudo doit contenir au moins 6 caractères");
        }
    });
    emailInput.addEventListener("input", function() {
        var emailValue = emailInput.value;
        // vérifier la validité de l'email
        if (filter_var(emailValue, FILTER_VALIDATE_EMAIL)) {
            emailInput.classList.remove("is-invalid");
            emailInput.classList.add("is-valid");
            emailFeedback.style.display = "none";
        } else {
            emailInput.classList.remove("is-valid");
            emailInput.classList.add("is-invalid");
            emailFeedback.innerText = "Email non valide";
            emailFeedback.style.display = "block";
        }
    });
    const submitButton = document.getElementById("submitButton");
    submitButton.addEventListener("click", function(event) {
        let formIsValid = true;
        // Vérification du champ Nom
        if (!nomInput.value) {
            formIsValid = false;
            toggleValidity(nomInput, nomFeedback);
        }
        // Vérification du champ Prénom
        if (!prenomInput.value) {
            formIsValid = false;
            toggleValidity(prenomInput, prenomFeedback);
        }
        // Vérification du champ Pseudo
        if (!pseudoInput.value) {
            formIsValid = false;
            toggleValidity(pseudoInput, pseudoFeedback);
        }
        // Vérification du champ Email
        if (!emailInput.value) {
            formIsValid = false;
            toggleValidity(emailInput, emailFeedback);
        }
        // Vérification du champ Date de naissance
        if (!dateInput.value) {
            formIsValid = false;
            toggleValidity(dateInput, dateFeedback);
        }
        // Vérification du champ Mot de passe
        if (!password.value || password.classList.contains("is-invalid")) {
            formIsValid = false;
        }
        // Vérification du champ Confirmation de mot de passe
        if (!confirmPassword.value || confirmPassword.classList.contains("is-invalid")) {
            formIsValid = false;
        }
        // Vérification du champ sélection d'entreprise
        if (!entrepriseSelect.value) {
            formIsValid = false;
            toggleValidity(entrepriseFeedback);
        }
        // Validation des CGU
        const cguCheckbox = document.getElementById("cgu");
        const cguValidationFeedback = document.getElementById("cguValidationFeedback");
        if (cguCheckbox && submitButton) {
            if (!cguCheckbox.checked) {
                event.preventDefault(); // Empêche l'envoi du formulaire
                cguValidationFeedback.style.display = "block"; // Affiche l'alerte des CGU
                formIsValid = false; // Met à jour le statut de validation du formulaire
            } else {
                cguValidationFeedback.style.display = "none"; // Cache l'alerte si les CGU sont acceptées
            }
        }
        // Si le formulaire est valide on l'envoi
        if (formIsValid) {}
    });
});
</script>

</body>

</html>
