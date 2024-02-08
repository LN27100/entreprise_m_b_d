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

<body class="#e0f7fa cyan lighten-5">

    <?php

    ?>
    <h1 class="center-align indigo-text">Portail entreprise</h1>

    <h2 class="center-align">Veuillez vous connecter</h2>
    
    <div class="container">
        <form class="row #455a64 blue-grey darken-2" method="POST" action="../controllers/controller-signin.php" novalidate>

            <div class="input-field col s12 m6 offset-m3 center-align">
                <input id="enterprise_email" type="email" class="validate <?php if (isset($errors['enterprise_email'])) echo 'invalid'; ?>" name="enterprise_email" placeholder="adresse email" value="<?= isset($_POST['enterprise_email']) ? htmlspecialchars($_POST['enterprise_email']) : '' ?>" required>
                <label for="enterprise_email" class="active cyan-text text-lighten-5">Email :</label>
                <span class="helper-text" data-error="<?php echo isset($errors['enterprise_email']) ? $errors['enterprise_email'] : 'Champ obligatoire'; ?>"></span>
            </div>

            <div class="input-field col s12 m6 offset-m3 center-align">
                <input id="enterprise_password" type="password" class="validate <?php if (isset($errors['enterprise_password'])) echo 'invalid'; ?>" name="enterprise_password" placeholder="Votre mot de passe" aria-label="password" aria-describedby="password">
                <label for="enterprise_password" class="cyan-text text-lighten-5">Mot de passe :</label>
                <i class="material-icons suffix cyan-text text-lighten-5" style="cursor:pointer; position: absolute; right: 10px; top: 50%; transform: translateY(-50%);" onclick="togglePasswordVisibility()">remove_red_eye</i>
                <span class="helper-text" data-error="<?php echo isset($errors['enterprise_password']) ? $errors['enterprise_password'] : 'Champ obligatoire'; ?>"></span>
            </div>

            <div class="input-field col s12 center-align">
            <button class="btn waves-effect custom-btn" type="submit" id="submitButton">Se connecter</button>
            </div>

        </form>

        <div class="row">
        <div class="custom-div center-align #01579b light-blue darken-4">
            <p class="textBold blue-grey-text darken-3">Pas encore membre?</p>
            <a href="../controllers/controller-signup.php" class="textBold green-text">Inscrivez-vous!</a>
        </div>
    </div>
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