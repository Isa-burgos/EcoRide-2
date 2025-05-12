<?php

    global $router;

    require_once __DIR__ . '/../config/session.php';

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/assets/css/main.min.css">
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>
    <script src="/assets/js/account.js" defer></script>
    <script src="/assets/js/geolocation.js" defer></script>
    <script src="/assets/js/quantity.js" defer></script>
    <script src="/assets/js/addTrip.js" defer></script>
    <script src="/assets/js/register.js" defer></script>
    <script src="/assets/js/login.js" defer></script>
    <script src="/assets/js/recapTrip.js" defer></script>
    <title>EcoRide v2</title>
</head>
<body>

    <!-- START HEADER -->
    <header class="fixed-top">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <div class="header-nav container-fluid mx-3">
                <a class="navbar-brand" href="/">
                    <img src="/assets/icons/Logo.svg" alt="Logo" width="112" height="49">
                </a>
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
                </svg>
                </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/carshare/search">Covoiturages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contact.php">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link required-connexion-btn" href="/carshare/create">Proposer un trajet</a>
                    </li>
                    <?php if(isset($_SESSION['user'])) : ?>
                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center py-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= htmlspecialchars($_SESSION['user']['pseudo']) ?>
                            <?php if (!empty($_SESSION['user']['photo'])): ?>
                                <img src="/<?= htmlspecialchars($_SESSION['user']['photo']) ?>" alt="avatar" class="rounded-circle ms-2" width="32" height="32">
                            <?php else: ?>
                                <img src="/assets/img/default-profile.svg" alt="Profil" class="rounded-circle ms-2" width="32" height="32">
                            <?php endif; ?>
                        </a>
                        <div class="text-primary ps-2">
                            <?= $_SESSION['user']['credit_balance'] ?> crédits
                        </div>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/dashboard">Mon compte</a></li>
                            <li><a class="dropdown-item" href="/history">Mon historique</a></li>
                            <li><a class="dropdown-item" href="#">Mes avis</a></li>
                            <li><a class="dropdown-item" href="/logout">Déconnexion</a></li>
                        </ul>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/login">Se connecter</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/register">Créer un compte</a>
                        </li>
                    <?php endif ?>
                </ul>
            </div>
            </div>
        </nav>
    </header>

    <!-- END HEADER -->
    <?= $content ?>
    
    <!-- START FOOTER -->

<footer class="footer bg-dark text-primary py-3">
    <div class="container">
        <div class="info row align-items-center justify-content-between mx-auto">
            <div class="contact col-12 col-md-4 text-md-start text-center mb-3 mb-md-0">
                <h3 class="h6 text-uppercase">Contact</h3>
                <p class="text-primary">contact@ecoride.com</p>
            </div>
            <div class="contact col-12 col-md-8 d-flex flex-column flex-md-row justify-content-between align-items-center text-center text-md-end">
                <a href="#" class="mb-2 mb-md-0">Mentions légales</a>
                <div class="contact col-sm-6 col-lg-4 text-center mb-3 mb-md-0">
                    <a href="#" class="me-2"><img src="/assets/icons/facebook.svg" alt="Logo facebook"></a>
                    <a href="#" class="me-2"><img src="/assets/icons/instagram.svg" alt="Logo instagram"></a>
                    <a href="#"><img src="/assets/icons/linkedin.svg" alt="Logo linkedin"></a>
                </div>
            </div>
        </div>
    </div>
</footer>

    <!-- END FOOTER -->
    
</body>
</html>