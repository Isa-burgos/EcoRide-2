<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Ecoride'?></title>
    <meta name="description" content="<?= $pageDescription ?? '' ?>">
</head>
<body>
    <header>
        <h2>mon header</h2>
    </header>

<?= $pageContent ?>
    
    <footer>
        <h2>mon footer</h2>
    </footer>
    
</body>
</html>