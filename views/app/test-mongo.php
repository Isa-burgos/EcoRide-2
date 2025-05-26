<?php
try {
    $manager = new MongoDB\Driver\Manager("mongodb://ecoride-2-mongodb-1:27017");
    echo "✅ Connexion MongoDB réussie !";
} catch (MongoDB\Driver\Exception\Exception $e) {
    echo "❌ Erreur de connexion : " . $e->getMessage();
}
