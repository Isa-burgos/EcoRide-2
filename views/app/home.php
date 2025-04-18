<?php

$pageTitle = 'Ecoride | site de covoiturage';
$pageDescription = 'Site de covoiturage écoresponsable';

?>

<!-- START MAIN -->

<main class="mb-5">
    <section class="big-hero text-center">
    <div class="big-hero-content">
        <h1>Trouvez <br><strong>un covoiturage</strong></h1>
        <h2>La solution accessible et durable pour tous</h2>
        <div class="search container w-100">
            <form class="row row-cols-1 row-cols-lg-4 my-2" method="GET" action="/carshare/results">
                <div class="input-container gx-1">
                    <input class="startAdress input" type="text" value="" name="depart_adress" id="departAdress" placeholder="Adresse de départ" required>
                    <div id="suggestionsDepart" class="suggestions-container"></div>
                </div>
                <div class="input-container gx-1">
                    <input class="endAdress input" type="text" value="" name="arrival_adress" id="arrivalAdress" placeholder="Adresse d'arrivée" required>
                    <div id="suggestionsArrival" class="suggestions-container"></div>
                </div>
                <div class="input-container gx-1">
                    <input class="date-depart input" type="date" placeholder="Date de départ">
                </div>
                <div class="input-container gx-1">
                    <input class="passenger input" type="number" placeholder="Passager">
                </div>
            </form>
            <button class="btn" type="submit">Lancer ma recherche</button>
        </div>
    </div>
</section>

<section class="trip text-center">
    <h2>Vous avez une voiture ?</h2>
    <p>Proposez des trajets et économisez sur vos déplacements</p>
    <a href="/trip.php" class="btn">Proposer un trajet</a>
</section>

<section class="about text-center">
    <div>
        <h2>Qui sommes-nous ?</h2>
        <div class="about-paragraph m-auto">
            <p>Chez EcoRide, nous croyons qu’il est possible de voyager tout en respectant notre planète. Notre mission est de rendre les trajets quotidiens et occasionnels plus écoresponsables, accessibles et agréables pour tous.
                Fondée par une équipe de passionnés d’écologie et de mobilité durable, EcoRide vise à réduire l’impact environnemental des déplacements en favorisant le partage de véhicules. En connectant des conducteurs et des passagers qui partagent une même destination, nous optimisons les trajets et contribuons à diminuer les émissions de CO₂.</p>
        </div>

    <div class="valeurs pt-2">
        <h2 class="mt-2">Nos valeurs</h2>
        <div class="container row row-cols-1 row-cols-lg-4 mx-auto">
            <div class="card-content">
                <h3 class="card-title">Respect de l’environnement</h3>
                <img src="/assets/img/environnement.webp" alt="Voitures sur une route de forêt">
                <p class="card-text">Chaque trajet partagé est une action concrète pour la planète</p>
            </div>
            <div class="card-content">
                <h3 class="card-title">Solidarité</h3>
                <img src="/assets/img/solidarite.webp" alt="Mains de différentes nationalités formant un cercle">
                <p class="card-text">Nous encourageons la collaboration et les liens sociaux entre voyageurs</p>
            </div>
            <div class="card-content">
                <h3 class="card-title">Confiance</h3>
                <img class="img-fluid" src="/assets/img/confiance.webp" alt="Femme souriante qui regarde par la vitre arrière d'une voiture">
                <p class="card-text">La sécurité et la fiabilité sont au cœur de nos préoccupations</p>
            </div>
            <div class="card-content">
                <h3 class="card-title">Innovation</h3>
                <img src="/assets/img/innovation.webp" alt="Plante qui pousse dans une ampoule">
                <p class="card-text">Nous utilisons la technologie pour simplifier vos trajets et réduire votre empreinte carbone</p>
            </div>
        </div>
        
    </div>
    <div class="about-paragraph m-auto">
    <p>Avec EcoRide, chaque kilomètre compte pour un avenir plus vert. Ensemble, nous pouvons changer la façon dont nous nous déplaçons tout en protégeant notre planète.</p>
    </div>
</section>
</main>
    <!-- END MAIN -->