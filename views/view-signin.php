<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">

    <title>Connexion pro</title>
</head>

<body>

    <?php

    ?>
    <h1 class="center-align">Portail entreprise</h1>

    <h2 class="center-align">Veuillez vous connecter</h2>
    <div class="container">
        <form class="row" method="POST" action="../controllers/controller-signin.php" novalidate>

            <div class="input-field col s12 m6">
                <input id="enterprise_email" type="email" class="validate <?php if (isset($errors['enterprise_email'])) echo 'invalid'; ?>" name="enterprise_email" placeholder="adresse email" value="<?= isset($_POST['enterprise_email']) ? htmlspecialchars($_POST['enterprise_email']) : '' ?>" required>
                <label for="enterprise_email" class="active">Email :</label>
                <span class="helper-text" data-error="<?php echo isset($errors['enterprise_email']) ? $errors['enterprise_email'] : 'Champ obligatoire'; ?>"></span>
            </div>

            <div class="input-field col s12">
                <input id="enterprise_password" type="password" class="validate <?php if (isset($errors['enterprise_password'])) echo 'invalid'; ?>" name="enterprise_password" placeholder="Votre mot de passe" aria-label="password" aria-describedby="password">
                <label for="enterprise_password">Mot de passe :</label>
                <span class="helper-text" data-error="<?php echo isset($errors['enterprise_password']) ? $errors['enterprise_password'] : 'Champ obligatoire'; ?>"></span>
                <i class="material-icons suffix" style="cursor:pointer" onclick="togglePasswordVisibility()">remove_red_eye</i>
            </div>

            <div class="center-align">
                <button class="btn waves-effect waves-light" type="submit" id="submitButton">Se connecter</button>
            </div>

            <div class="center-align">
                <p>Pas encore membre?</p>
                <a href="../controllers/controller-signup.php">Inscrivez-vous!</a>
            </div>

        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById('enterprise_password');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        }
    </script>
</body>

</html>
