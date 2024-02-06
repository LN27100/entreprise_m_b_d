<!DOCTYPE html>
<html lang="en">

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
</head>

<body class="has-fixed-sidenav">
    <header>
        <div class="navbar-fixed">
            <nav class="navbar #e0f7fa cyan lighten-5">
                <div class="nav-wrapper"><a href="#" class="brand-logo #e0f7fa cyan lighten-5">Portail entreprise</a>
                </div>
            </nav>
        </div>
        <ul id="sidenav-left" class="sidenav sidenav-fixed #e0f7fa cyan lighten-5">
            <li><a href="../controllers/controller-home.php" class="logo-container"><?= $nom ?></a></li>

    </header>

    <main>
        <div class="container">
            <div class="masonry row">
                <div class="col s12">
                    <h2>Dashboard <?= $nom ?></h2>
                </div>

                <div class="row">
                    <div class="col l3 m6 s12">
                    <div class="card #01579b light-blue darken-4">
                            <div class="card-content white-text">
                                <span class="card-title">Total des utilisateurs</span>
                                <p>I am a very simple card. I am good at containing small bits of information.
                                    I am convenient because I require little markup to use effectively.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col l3 m6 s12">
                    <div class="card #01579b light-blue darken-4">
                            <div class="card-content white-text">
                                <span class="card-title">Total des utilisateurs actifs</span>
                                <p>I am a very simple card. I am good at containing small bits of information.
                                    I am convenient because I require little markup to use effectively.</p>
                            </div>

                        </div>
                    </div>

                    <div class="col l3 m6 s12">
                    <div class="card #01579b light-blue darken-4">
                            <div class="card-content white-text">
                                <span class="card-title">Total des trajets</span>
                                <p>I am a very simple card. I am good at containing small bits of information.
                                    I am convenient because I require little markup to use effectively.</p>
                            </div>

                        </div>
                    </div>

                    <div class="col l3 m6 s12">
                    <div class="card #01579b light-blue darken-4">
                            <div class="card-stacked">
                                <div class="card-metrics card-metrics-toggle card-metrics-centered white-text">
                                    <div class="card-metric">
                                    <span class="card-title">5 derniers utilisateurs</span>
                                        <div class="card-metric-value">0.24%</div>
                                        <div class="card-metric-value">0.24%</div>
                                        <div class="card-metric-value">0.24%</div>
                                        <div class="card-metric-value">0.24%</div>
                                        <div class="card-metric-value">0.24%</div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-chart">
                                <canvas id="flush-area-chart-green" height="400px"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col l3 m6 s12">
                    <div class="card #01579b light-blue darken-4">
                            <div class="card-content white-text">
                                <span class="card-title">Stats hebdo</span>
                                <p>I am a very simple card. I am good at containing small bits of information.
                                    I am convenient because I require little markup to use effectively.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col l3 m6 s12">
                    <div class="card #01579b light-blue darken-4">
                            <div class="card-content white-text">
                                <span class="card-title">Stats des Moyens de transport</span>
                                <p>I am a very simple card. I am good at containing small bits of information.
                                    I am convenient because I require little markup to use effectively.</p>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="col l3 m6 s12">
                <div class="card #01579b light-blue darken-4">
                            <div class="card-content white-text">
                                <span class="card-title">Total des trajets</span>
                                <p>I am a very simple card. I am good at containing small bits of information.
                                    I am convenient because I require little markup to use effectively.</p>
                            </div>

                        </div>
                    </div>

    </main>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

        });
    </script>
</body>

</html>