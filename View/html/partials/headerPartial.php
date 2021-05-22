<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Ajout des feuilles de style -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Exo:400,700">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/View/css/style.css">
    <!-- MDB -->

    <!-- Ajout des scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/View/js/countDownGame.js"></script>
    <script type="text/javascript" src="/View/js/countDown.js"></script>
    <script type="text/javascript" src="/View/js/game.js"></script>
    <script type="text/javascript" src="/View/js/site.js"></script>
    <script type="text/javascript" src="/View/js/timerRank.js"></script>

    <title>Jeux de mots - Wordz</title>
    <nav class="navbar navbar-expand-lg navbar-light navbar-he fixed-top">
        <div class="container-fluid justify-content-between">
            <!-- Left elements -->
            <div class="d-flex">
                <!-- Brand -->
                <a class="navbar-brand me-2 mb-1 d-flex align-items-center" href="/homePage.php">
                    <img
                            src="/View/images/logo.png"
                            height="80"
                            width="60"
                            alt=""
                            loading="lazy"
                            style="margin-top: 2px;"
                    />
                </a>
            </div>

            <div class="collapse navbar-collapse">
                <ul class="navbar-nav">
                    <div class="dropdown">
                        <li class="nav-item ml-5">
                            <a class="nav-link text-white dropdown-toggle h4 effect-shine" href="#" id="dropDownRank" role="button" data-mdb-toggle="dropdown" aria-expanded="false">Classement
                            </a>
                            <ul class="dropdown-menu menu-rank" aria-labelledby="dropDownRank">
                                <li><a class="dropdown-item h5 effect-shine text-white menu-rank" href="/View/html/weeklyRankPage.php">Classement hebdomadaire</a></li>
                                <li><hr class="dropdown-divider menu-rank" /></li>
                                <li><a class="dropdown-item h5 effect-shine text-white menu-rank" href="/View/html/monthlyRankPage.php">Classement mensuel</a></li>
                                <li><hr class="dropdown-divider menu-rank" /></li>
                                <li><a class="dropdown-item h5 effect-shine text-white menu-rank" href="/View/html/globalRankPage.php">Classement général</a></li>
                            </ul>
                        </li>
                    </div>
                    <li class="nav-item ml-5"><a class="nav-link text-white h4 effect-shine" href="/View/html/rulesPage.php">Règles du jeu</a></li>
                    <li class="nav-item ml-5"><a  class="nav-link text-white h4 effect-shine" href="/View/html/about.php">A propos</a></li>
                </ul>
            </div>
            <ul class="navbar-nav flex-row">

                <!-- Vérification si l'utilisateur est connecté -->
                <?php if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) : ?>
                    <!-- Statistiques du joueur -->
                    <div class="border border-white rounded">
                        <div class="form-row" style="margin-top: 2px;">
                            <div class="form-group col-sm-4">
                                <label for="credit-nyt" class="form-control-sm text-white"><strong>Crédits</strong></label>
                            </div>
                            <div class="form-group col-sm-8 ">
                                <div class="input-group">
                                    <?php
                                    require_once $_SERVER['DOCUMENT_ROOT']."/fichiers_php/User/UserController.php";
                                    echo '<input type="text" readonly class="form-control-plaintext form-control-sm text-white" style="text-align:center" id="credit-nyt" value="'.getUserCredit().' NYT"/>';
                                    ?>
                                    <div class="input-group-addon mr-2">
                                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="coins" class="svg-inline--fa fa-coins text-warning" height="20px" width="20px" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M0 405.3V448c0 35.3 86 64 192 64s192-28.7 192-64v-42.7C342.7 434.4 267.2 448 192 448S41.3 434.4 0 405.3zM320 128c106 0 192-28.7 192-64S426 0 320 0 128 28.7 128 64s86 64 192 64zM0 300.4V352c0 35.3 86 64 192 64s192-28.7 192-64v-51.6c-41.3 34-116.9 51.6-192 51.6S41.3 334.4 0 300.4zm416 11c57.3-11.1 96-31.7 96-55.4v-42.7c-23.2 16.4-57.3 27.6-96 34.5v63.6zM192 160C86 160 0 195.8 0 240s86 80 192 80 192-35.8 192-80-86-80-192-80zm219.3 56.3c60-10.8 100.7-32 100.7-56.3v-42.7c-35.5 25.1-96.5 38.6-160.7 41.8 29.5 14.3 51.2 33.5 60 57.2z"></path></svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row" style="margin-top: -30px;">
                            <div class="form-group col-sm-4">
                                <label for="score" class="form-control-sm text-white"><strong>Score</strong></label>
                            </div>
                            <div class="form-group col-sm-8 ">
                                <div class="input-group">
                                    <?php
                                    require_once $_SERVER['DOCUMENT_ROOT']."/fichiers_php/User/UserController.php";
                                    $_SESSION["score"] = getUserScore();
                                    echo '<input type="text" readonly class="form-control-plaintext form-control-sm text-white" style="text-align:center" id="score" value="'.getUserScore().' Points"/>';
                                    ?>

                                    <div class="input-group-addon mr-2">
                                        <i class="fa fa-star text-warning"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row" style="margin-top: -30px;">
                            <div class="form-group col-sm-4">
                                <label for="level" class="form-control-sm text-white"><strong>Niveau</strong></label>
                            </div>
                            <div class="form-group col-sm-8 ">
                                <div class="input-group mr-2">
                                    <?php
                                    require_once $_SERVER['DOCUMENT_ROOT']."/fichiers_php/User/UserQueries.php";
                                    $level = getUserLevel($_SESSION["userId"]);
                                    echo '<input type="text" readonly class="form-control-plaintext form-control-sm text-white" style="text-align:center" id="level" value="'.$level.'"/>';
                                    ?>
                                    <div class="input-group-addon mr-2">
                                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="medal" class="svg-inline--fa fa-medal text-primary" height="20px" width="20px" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M223.75 130.75L154.62 15.54A31.997 31.997 0 0 0 127.18 0H16.03C3.08 0-4.5 14.57 2.92 25.18l111.27 158.96c29.72-27.77 67.52-46.83 109.56-53.39zM495.97 0H384.82c-11.24 0-21.66 5.9-27.44 15.54l-69.13 115.21c42.04 6.56 79.84 25.62 109.56 53.38L509.08 25.18C516.5 14.57 508.92 0 495.97 0zM256 160c-97.2 0-176 78.8-176 176s78.8 176 176 176 176-78.8 176-176-78.8-176-176-176zm92.52 157.26l-37.93 36.96 8.97 52.22c1.6 9.36-8.26 16.51-16.65 12.09L256 393.88l-46.9 24.65c-8.4 4.45-18.25-2.74-16.65-12.09l8.97-52.22-37.93-36.96c-6.82-6.64-3.05-18.23 6.35-19.59l52.43-7.64 23.43-47.52c2.11-4.28 6.19-6.39 10.28-6.39 4.11 0 8.22 2.14 10.33 6.39l23.43 47.52 52.43 7.64c9.4 1.36 13.17 12.95 6.35 19.59z"></path></svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row " style="margin-top: -30px; margin-bottom: -20px;">
                            <div class="form-group col-sm-4">
                                <label for="rank" class="form-control-sm text-white"><strong>Classement</strong></label>
                            </div>
                            <div class="form-group col-sm-8">
                                <div class="input-group mr-2">
                                    <?php
                                    require_once $_SERVER['DOCUMENT_ROOT']."/fichiers_php/User/UserController.php";
                                    echo '<input type="text" readonly class="form-control-plaintext form-control-sm text-white" style="text-align:center" id="rank" value="'.getUserRank($_SESSION["userId"], 1).'"/>';
                                    ?>

                                    <div class="input-group-addon mr-2">
                                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trophy" class="svg-inline--fa fa-trophy text-warning" height="20px" width="20px" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M552 64H448V24c0-13.3-10.7-24-24-24H152c-13.3 0-24 10.7-24 24v40H24C10.7 64 0 74.7 0 88v56c0 35.7 22.5 72.4 61.9 100.7 31.5 22.7 69.8 37.1 110 41.7C203.3 338.5 240 360 240 360v72h-48c-35.3 0-64 20.7-64 56v12c0 6.6 5.4 12 12 12h296c6.6 0 12-5.4 12-12v-12c0-35.3-28.7-56-64-56h-48v-72s36.7-21.5 68.1-73.6c40.3-4.6 78.6-19 110-41.7 39.3-28.3 61.9-65 61.9-100.7V88c0-13.3-10.7-24-24-24zM99.3 192.8C74.9 175.2 64 155.6 64 144v-16h64.2c1 32.6 5.8 61.2 12.8 86.2-15.1-5.2-29.2-12.4-41.7-21.4zM512 144c0 16.1-17.7 36.1-35.3 48.8-12.5 9-26.7 16.2-41.8 21.4 7-25 11.8-53.6 12.8-86.2H512v16z"></path></svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <li class="nav-item me-3 me-lg-1">
                        <a class="nav-link d-sm-flex align-items-sm-center" href="/View/html/profilePage.php" id="profil-image-link">

                            <!-- Vérification si l'utilisateur détient un avatar -->
                            <img src=<?php echo $_SESSION['avatarSrc']; ?> class="rounded float-left" style="height: 50px; width: 50px;">

                            <strong class="d-none d-sm-block ms-1 text-white"><?php echo $_SESSION['username'] ?></strong>
                        </a>
                    </li>
                    <div class="dropdown">
                        <li class="nav-item dropdown me-3 me-lg-1">
                            <a class="nav-link dropdown-toggle hidden-arrow text-white" href="#" id="navbarDropdownMenuLink" role="button" data-mdb-toggle="dropdown" aria-expanded="false" style="margin-top: 13px;">
                                <i class="fa fa-chevron-circle-down fa-lg"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end navbar-he" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item effect-shine text-white menu-rank" href="/View/html/profilePage.php" id="profil-link"><i class="fa fa-cogs" aria-hidden="true"></i>  Modifier profil</a></li>
                                <li><hr class="dropdown-divider menu-rank" /></li>
                                <li><a class="dropdown-item effect-shine text-white menu-rank" href="/View/html/logoutPage.php" id="disconnect-link"><i class='fa fa-sign-out' aria-hidden='true'></i>  Se déconnecter</a></li>
                            </ul>
                        </li>
                    </div>
                <?php else : ?>
                    <li class="nav-item me-3 me-lg-1 mr-2 mt-2">
                        <?php include $_SERVER['DOCUMENT_ROOT'] . '/View/html/partials/googleexternallogin.php'; ?>
                    </li>
                    <li class="nav-item me-3 me-lg-1 mr-2">
                        <a href='/View/html/loginPage.php' id="connection-a" class="nav-link d-sm-flex fa-2x align-items-sm-center"><button id="connection-btn" type="button" class="btn btn-outline-light btn-rounded" data-mdb-ripple-color="dark">Connexion</button></a>
                    </li>
                    <li class="nav-item me-3 me-lg-1 ">
                        <a href='/View/html/registerPage.php' id="register-a" class="nav-link d-sm-flex align-items-sm-center"><button type="button" id="register-btn" class="btn btn-outline-light btn-rounded" data-mdb-ripple-color="dark">S'inscrire</button></a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</head>