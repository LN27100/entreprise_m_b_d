<!DOCTYPE html>

<html lang="fr">




<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <link rel="stylesheet" href="../assets//css//style.css">




    <title>Inscription pro</title>

</head>




<body class="#e0f7fa cyan lighten-5">




    <?php if ($showform) : ?>

        <h1 class="center-align indigo-text">Formulaire d'inscription pro</h1>

    <?php endif; ?>

    <div class="container">

        <?php

        if ($showform) {

        ?>

            <form class="row #455a64 blue-grey darken-2" method="POST" action="../controllers/controller-signup.php" novalidate>

                <!-- Champs entreprise -->

                <div class="col-md-4">

                    <label for="validationServer01" class="active cyan-text text-lighten-5">Nom d'entreprise :</label>

                    <input type="text" placeholder="saisissez le nom de votre entreprise" class="form-control <?php if (isset($errors['enterprise_name'])) echo 'is-invalid'; ?>" id="validationServer01" name="enterprise_name" value="<?= isset($_POST['enterprise_name']) ? htmlspecialchars($_POST['enterprise_name']) : '' ?>" required>

                    <div class="invalid-feedback" id="enterpriseNameValidationFeedback">

                        <?php if (isset($errors['enterprise_name'])) echo $errors['enterprise_name']; ?>

                    </div>

                </div>

                <!-- Numéro de Siret -->

                <div class="col-md-4">

                    <label for="validationServer03" class="cyan-text text-lighten-5">Numéro de Siret :</label>

                    <input type="text" class="form-control <?php if (isset($errors['enterprise_siret'])) echo 'is-invalid'; ?>" id="validationServer03" name="enterprise_siret" placeholder="saisissez le siret de votre entreprise" value="<?= isset($_POST['enterprise_siret']) ? htmlspecialchars($_POST['enterprise_siret']) : '' ?>" required>

                    <div class="invalid-feedback" id="enterpriseSiretValidationFeedback">

                        <?php if (isset($errors['enterprise_siret'])) echo $errors['enterprise_siret']; ?>

                    </div>

                </div>


                <!-- Adresse entreprise -->

                <div class="col-md-4">

                    <label for="enterprise_adress" class="cyan-text text-lighten-5">Adresse entreprise:</label>

                    <input type="text" placeholder="saisissez votre adresse" name="enterprise_adress" value="<?= isset($_POST['enterprise_adress']) ? htmlspecialchars($_POST['enterprise_adress']) : '' ?>" class="form-control <?php if (isset($errors['enterprise_adress'])) echo 'is-invalid'; ?>" required>

                    <div class="invalid-feedback" id="enterpriseAdressValidationFeedback">

                        <?php if (isset($errors['enterprise_adress'])) echo $errors['enterprise_adress']; ?>

                    </div>

                </div>


                <div class="col-md-4">

                    <label for="enterprise_zipcode" class="cyan-text text-lighten-5">Code postal:</label>

                    <input type="text" placeholder="saisissez votre code postal" name="enterprise_zipcode" value="<?= isset($_POST['enterprise_zipcode']) ? htmlspecialchars($_POST['enterprise_zipcode']) : '' ?>" class="form-control <?php if (isset($errors['enterprise_zipcode'])) echo 'is-invalid'; ?>" required>

                    <div class="invalid-feedback" id="dateValidationFeedback">

                        <?php
                        if (isset($errors['enterprise_zipcode'])) {
                            echo $errors['enterprise_zipcode'];
                        }
                        ?>

                    </div>

                </div>


                <!-- Ville -->

                <div class="col-md-4">

                    <label for="enterprise_city" class="cyan-text text-lighten-5">Ville:</label>

                    <input type="text" placeholder="saisissez votre ville" name="enterprise_city" value="<?= isset($_POST['enterprise_city']) ? htmlspecialchars($_POST['enterprise_city']) : '' ?>" class="form-control <?php if (isset($errors['enterprise_city'])) echo 'is-invalid'; ?>" required>

                    <div class="invalid-feedback" id="enterpriseCityValidationFeedback">

                        <?php if (isset($errors['enterprise_city'])) echo $errors['enterprise_city']; ?>

                    </div>

                </div>


                <form method="post" action="../controllers/controller-signup.php">

                    <div class="form-group col-md-6">

                        <label for="email" class="cyan-text text-lighten-5">Email: </label>

                        <input type="email" class="form-control <?php if (isset($errors['enterprise_email'])) echo 'is-invalid'; ?>" id="email" name="enterprise_email" placeholder="saisissez votre adresse mail" value="<?= isset($_POST['enterprise_email']) ? htmlspecialchars($_POST['enterprise_email']) : '' ?>" required>

                        <div class="invalid-feedback" id="emailValidationFeedback">

                            <?php
                            if (isset($errors['enterprise_email'])) {
                                echo $errors['enterprise_email'];
                            }
                            ?>
                        </div>

                    </div>


                    <div class="form-group col-md-12">

                        <label for="enterprise_password" class="cyan-text text-lighten-5">Mot de passe: </label>

                        <div class="input-group d-flex">

                            <input type="password" class="form-control rounded mt-1 password-input <?php if (isset($errors['enterprise_password'])) echo 'is-invalid'; ?>" name="enterprise_password" placeholder="********" aria-label="password" aria-describedby="password" id="password-input">

                            <div class="invalid-feedback" id="passwordValidationFeedback">

                                <?php

                                if (isset($errors['enterprise_password'])) {

                                    echo $errors['enterprise_password'];
                                }

                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="conditionPassword col-6 mt-4 mt-xxl-0 w-auto h-auto">
                        <div class="alert px-4 py-3 mb-0 d-none" role="alert" data-mdb-color="warning" id="password-alert">
                            <ul class="list-unstyled mb-0">
                                <div class="requirements leng">
                                    <i class="bi bi-check text-success me-2 d-none"></i>
                                    <i class="bi bi-x text-danger me-3"></i>
                                    Votre mot de passe doit contenir au moins 8 caractères.
                                </div>
                                <div class="requirements big-letter">
                                    <i class="bi bi-check text-success me-2 d-none"></i>
                                    <i class="bi bi-x text-danger me-3"></i>
                                    Votre mot de passe doit contenir une lettre majuscule.
                                </div>
                                <div class="requirements num">
                                    <i class="bi bi-check text-success me-2 d-none"></i>
                                    <i class="bi bi-x text-danger me-3"></i>
                                    Votre mot de passe doit contenir un chiffre.
                                </div>
                                <div class="requirements special-char">
                                    <i class="bi bi-check text-success me-2 d-none"></i>
                                    <i class="bi bi-x text-danger me-3"></i>
                                    Votre mot de passe doit contenir un caractère spécial.
                                </div>
                            </ul>
                        </div>
                    </div>


                    <div class="col-12 mt-4 mt-xxl-0  h-auto">

                        <div class="input-group d-flex">

                            <label for="mot_de_passe" class="cyan-text text-lighten-5">Confirmer Mot de passe:</label>

                            <input type="password" class="form-control rounded mt-1 password-input <?php if (isset($errors['conf_mot_de_passe'])) echo 'is-invalid'; ?>" name="conf_mot_de_passe" placeholder="Confirmez votre mot de passe" aria-label="confirm-password" aria-describedby="confirm-password" id="confirm-password-input" />

                            <div class="invalid-feedback" id="confirmPasswordValidationFeedback"></div>

                            <div class="valid-feedback"></div>

                        </div>

                    </div>

                    <div class="input-field blue-border-checkbox">

                        <label>

                            <input type="checkbox" class="filled-in" id="cgu" name="cgu" required value="on">

                            <span class="cyan-text text-lighten-5">J'accepte les conditions d'utilisation</span>

                        </label>

                        <div class="invalid-feedback" id="cguValidationFeedback">

                            <?php if (isset($errors['cgu'])) echo $errors['cgu']; ?>

                        </div>

                    </div>


                    <div class="text-center">

                        <button class="btn waves-effect custom-btn" name="g-recaptcha-response" type="submit" id="submitButton">S'enregistrer</button>

                    </div>


                </form>


                <div class="row">
                    <div class="custom-div center-align #01579b light-blue darken-4">
                    <div class="text-center">
                    <p class="textBold blue-grey-text darken-3">Déjà inscrit?</p>
                        </div>
                        <a href="../controllers/controller-signin.php" class="textBold green-text"">Connexion</a>

                    </div>
                </div>

            <?php } else { ?>
                <h2>Inscription réussie</h2>
                <p><strong><em>Vous pouvez maintenant vous connecter.</em></strong></p>
                <a href="../controllers/controller-signin.php" class="button">Connexion</a>

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