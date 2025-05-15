<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard admin' ?></title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/assets/css/main.min.css">
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">
        <nav class="navbar nav-pills d-flex flex-column">
            <div class="container-fluid mx-auto p-0">
                <button class="bg-transparent border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminSidebar" aria-controls="adminSidebar">
                    <img src="/assets/icons/burger.svg" alt="icône menu burger">
                </button>
            </div>
        </nav>

        <div class="offcanvas offcanvas-start d-lg-block show sidebar d-flex flex-column justify-content-center align-items-stretch py-3" tabindex="-1" id="adminSidebar" aria-labelledby="adminSidebarLabel">
            <div class="offcanvas-header">
                <h3 class="offcanvas-title" id="adminSidebarLabel">Espace administrateur</h3>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
            <?php
                $current = $_SERVER['REQUEST_URI'];
            ?>
            <ul class="nav nav-pills nav-justified flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link <?= strpos($current, '/admin/dashboard') === 0 && $current === '/admin/dashboard' ? 'active' : '' ?>" href="/admin/dashboard">Dashboard</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link<?= strpos($current, '/admin/employes') === 0 && $current === '/admin/employes' ? 'active' : '' ?>" href="">Employés</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link<?= strpos($current, '/admin/users') === 0 && $current === '/admin/users' ? 'active' : '' ?>" href="">Utilisateurs</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link<?= strpos($current, '/admin/credits') === 0 && $current === '/admin/credits' ? 'active' : '' ?>" href="">Crédits</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="/logout">Déconnexion</a>
                </li>
            </ul>
            </div>
        </div>

    <main class="main-admin">
        <?= $pageContent ?>
    </main>
    
</body>
</html>