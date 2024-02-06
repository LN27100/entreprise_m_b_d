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
            <nav class="navbar white">
                <div class="nav-wrapper"><a href="#" class="brand-logo grey-text text-darken-4">Portail entreprise</a>
                </div>
            </nav>
        </div>
        <ul id="sidenav-left" class="sidenav sidenav-fixed">
            <li><a href="../controllers/controller-home.php" class="logo-container"><?=$nom ?><i class="material-icons left"></i></a></li>
          
                       
    </header>

    <main>
    <div class="container">
        <div class="masonry row">
            <div class="col s12">
                <h2>Dashboard <?= $nom ?></h2>
            </div>
            <div class="col l3 m6 s12">
                <div class="card">
                    <div class="card-stacked">
                        <div class="card-metrics card-metrics-static">
                            <div class="card-metric">
                                <div class="card-metric-title">Revenue</div>
                                <div class="card-metric-value">$12,476.00</div>
                                <div class="card-metric-change increase">
                                    <i class="material-icons left">keyboard_arrow_up</i>
                                    12%
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-chart">
                        <canvas id="flush-area-chart-blue" height="100px"></canvas>
                    </div>
                </div>
            </div>
            <div class="col l3 m6 s12">
                <div class="card">
                    <div class="card-stacked">
                        <div class="card-metrics card-metrics-static">
                            <div class="card-metric">
                                <div class="card-metric-title">Clicks</div>
                                <div class="card-metric-value">11,893</div>
                                <div class="card-metric-change increase">
                                    <i class="material-icons left">keyboard_arrow_up</i>
                                    8%
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-chart">
                        <canvas id="flush-area-chart-yellow" height="100px"></canvas>
                    </div>
                </div>
            </div>
            <div class="col l3 m6 s12">
                <div class="card">
                    <div class="card-stacked">
                        <div class="card-metrics card-metrics-static">
                            <div class="card-metric">
                                <div class="card-metric-title">Users</div>
                                <div class="card-metric-value">230,648</div>
                                <div class="card-metric-change decrease">
                                    <i class="material-icons left">keyboard_arrow_down</i>
                                    2%
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-chart">
                        <canvas id="flush-area-chart-pink" height="100"></canvas>
                    </div>
                </div>
            </div>
            <div class="col l3 m6 s12">
                <div class="card">
                    <div class="card-stacked">
                        <div class="card-metrics card-metrics-static">
                            <div class="card-metric">
                                <div class="card-metric-title">Conversion Rate</div>
                                <div class="card-metric-value">0.24%</div>
                                <div class="card-metric-change decrease">
                                    <i class="material-icons left">keyboard_arrow_down</i>
                                    9%
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-chart">
                        <canvas id="flush-area-chart-green" height="100"></canvas>
                    </div>
                </div>
            </div>
            <div class="col s12">
                <div class="card">
                    <div class="card-metrics card-metrics-toggle card-metrics-centered">
                        <div class="card-metric waves-effect active" data-metric="revenue">
                            <div class="card-metric-title">Revenue</div>
                            <div class="card-metric-value">$12,476.00</div>
                            <div class="card-metric-change">
                                <i class="material-icons">keyboard_arrow_up</i>
                                12%
                            </div>
                        </div>
                        <div class="card-metric waves-effect" data-metric="users">
                            <div class="card-metric-title">Users</div>
                            <div class="card-metric-value">2024</div>
                            <div class="card-metric-change">
                                <i class="material-icons">keyboard_arrow_up</i>
                                9%
                            </div>
                        </div>
                        <div class="card-metric waves-effect" data-metric="ctr">
                            <div class="card-metric-title">CTR</div>
                            <div class="card-metric-value">0.20%</div>
                            <div class="card-metric-change">
                                <i class="material-icons">keyboard_arrow_up</i>
                                4%
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <canvas class="card-chart" id="main-toggle-line-chart" width="400" height="400"></canvas>
                    </div>
                </div>
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
