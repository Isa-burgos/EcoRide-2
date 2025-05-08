<?php

use App\Services\AuthService;

    $auth = new AuthService();
    $userId = $auth->getCurrentUserId();

    if (!$userId) {
        $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
        header('Location: /login');
        exit;
    }

    $currentHour = date('H');
    $currentMinute = date('i');

?>

<main>
    <section class="big-hero text-center">
        <div class="big-hero-content">
            <h1>Proposer un trajet</h1>
        </div>
    </section>

    <?php if ($userId) : ?>
    <section class="conteneur">
        <form class="conteneur-content" method="POST" action="/carshare/create">

            <!-- START STEP 1 -->
                <div id="step1" class="step active">
                    <h2>Mon trajet</h2>
                    <hr class="separator">
                    <div class="step-content">
                        <fieldset class="mb-5">
                            <legend>Adresse de départ</legend>
                            <div class="input-container">
                                <label for="depart_adress"></label>
                                <input class="input form-control startAdress" type="text" value="" id="depart_adress" name="depart_adress" placeholder="Adresse de départ" required>
                                <div class="suggestions-container"></div>
                                <button type="button" class="btn-geoloc" id="geolocDepart" aria-label="Utiliser ma position"></button>
                                <div class="invalid-feedback">
                                    Ce champ est requis
                                </div>
                            </div>
                            <div>
                                <span>Adresse sélectionnée :</span>
                                <span id="selectedAdressDepart"></span>
                            </div>
                        </fieldset>
                        <fieldset class="mb-3">
                            <legend>Adresse d'arrivée</legend>
                            <div class="input-container">
                                <label for="arrival_adress"></label>
                                <input class="input form-control endAdress" type="text" value="" id="arrival_adress" name="arrival_adress" placeholder="Adresse d'arrivée" required>
                                <div class="suggestions-container"></div>
                                <button type="button" class="btn-geoloc" id="geolocArrival" aria-label="Utiliser ma position"></button>
                                <div class="invalid-feedback">
                                    Ce champ est requis
                                </div>
                            </div>
                            <div>
                                <span>Adresse sélectionnée :</span>
                                <span id="selectedAdressArrival"></span>
                            </div>
                        </fieldset>
                    </div>
                    <div class="step-buttons">
                        <button type="button" class="btn btn-next">Étape suivante</button>
                    </div>
                </div>
            <!-- END STEP 1 -->

            <!-- START STEP 2 -->
                    <div id="step2" class="step">
                        <h2>Mon véhicule</h2>
                        <hr class="separator">
                        <div class="step-content">
                            <fieldset>
                                <legend></legend>
                                <div>
                                    <legend for="carChoice">Je choisis un véhicule</legend>
                                    <?php if(!empty($userVehicles)) : ?>
                                        <?php foreach($userVehicles as $v) : ?>
                                            <?php
                                                $prefs = $vehiclePreferences[$v->getVehicleId()] ?? [];
                                                $smoking = $prefs['smoking'] ?? false;
                                                $pets = $prefs['pets'] ?? false;
                                                $custom = $prefs['custom'] ?? '';
                                                $selectedVehicleId = $_POST['used_vehicle'] ?? null;
                                            ?>
                                            <div class="card bg-light text-dark mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                            name="used_vehicle"
                                                            value="<?= $v->getVehicleId()?>"
                                                            id="vehicle_<?= $v->getVehicleId()?>"
                                                            data-label="<?= $v->getBrand() . ' ' . $v->getModel() ?>"
                                                            data-place="<?= $v->getNbPlace() ?>"
                                                            data-smoking="<?= $smoking ?>"
                                                            data-pets="<?= $pets ?>"
                                                            data-custom="<?= htmlspecialchars($custom) ?>">
                                                            <?=count($userVehicles) === 1 ? 'checked' : '' ?>>
                                                    <label class="form-check-label text-dark" for="vehicle_<?= $v->getVehicleId(); ?>">
                                                    <?= htmlspecialchars($v->getBrand() . " " . $v->getModel()); ?>
                                                    </label>
                                                    <p class="text-dark">Nombre de places disponibles : <?= $v->getNbPlace() ?></p>
                                                    <p class="text-dark">Fumeur : <?= $smoking ? 'oui' : 'non' ?></p>
                                                    <p class="text-dark">Animaux acceptés : <?= $pets ? 'oui' : 'non' ?></p>
                                                    <p class="text-dark">Préférences : <?= $custom  ?: '' ?></p>
                                                    <a href="/vehicle/<?= $v->getVehicleId() ?>/edit?redirect=/carshare/create" class="btn btn-primary">Modifier</a>
                                                </div>
                                            </div>
                                        <?php endforeach ?>
                                    <?php else : ?>
                                        <p>Aucun véhicule enregistré <a href="/add-vehicle.php">Ajouter un véhicule</a></p>
                                    <?php endif ?>
                                </div>
                            </fieldset>
                        </div>
                        <div class="step-buttons">
                            <button type="button" class="btn btn-prev mx-2">Étape précédente</button>
                            <button type="button" class="btn btn-next mx-2">Étape suivante</button>
                        </div>
                    </div>
            <!-- END STEP 2 -->

            <!-- START STEP 3 -->
                    <div id="step3" class="step">
                        <h2>Date et heure</h2>
                        <hr class="separator">
                        <div class="step-content">
                            <fieldset>
                                <legend>Départ</legend>
                                <div>
                                    <div>
                                        <div>
                                            <label for="depart_date">Jour</label>
                                            <input class="input form-control" name="depart_date" id="depart_date" type="date" value="" required min="<?= date('Y-m-d') ?>" >
                                        </div>
                                        <div>
                                            <fieldset>
                                                <legend>Heure</legend>
                                                <select class="input" name="hour" id="hour">
                                                    <?php for ($h = 0; $h <= 23; $h++): ?>
                                                        <option value="<?= sprintf('%02d', $h) ?>" <?= ($h == $currentHour) ? 'selected' : '' ?>>
                                                        <?= sprintf('%02d', $h) ?>
                                                        </option>
                                                    <?php endfor ?>
                                                </select>
                                                <label for="hour">h</label>
                                                <select class="input" name="minute" id="minute">
                                                <?php foreach (["00", "15", "30", "45"] as $m): ?>
                                                        <option value="<?= $m ?>" <?= ($h == $currentMinute) ? 'selected' : '' ?>>
                                                        <?= $m ?>
                                                        </option>
                                                    <?php endforeach ?>
                                                </select>
                                                <label for="minute">min</label>
                                                <input type="hidden" name="depart_time" id="depart_time"
                                                        value="<?= isset($carshare) ? htmlspecialchars($carshare->getDepartTime()) : '08:00:00'?>">
                                                <input type="hidden" name="arrival_time" id="arrival_time"
                                                        value="<?= isset($carshare) ? htmlspecialchars($carshare->getArrivalTime()) : '' ?>">

                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="step-buttons">
                            <button type="button" class="btn btn-prev mx-2">Étape précédente</button>
                            <button type="button" class="btn btn-next mx-2">Étape suivante</button>
                        </div>
                    </div>
        <!-- END STEP 3 -->

        <!-- START STEP 4 -->
                    <div id="step4" class="step">
                        <h2>Itinéraire et coût</h2>
                        <hr class="separator">
                        <div class="step-content">
                            <fieldset>
                                <legend>Itinéraire</legend>
                                <div>
                                    <p>Votre itinéraire fait <strong><span id="tripDistance"></span></strong></p>
                                    <br>
                                    <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#mapModal">Visualiser votre itinéraire</button>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Prix du trajet</legend>
                                <div class="reservation">
                                    <div class="passenger-quantity p-0">
                                        <div class="passenger-icon p-2">
                                            <div class="trip-passenger">
                                                <p class="m-0">Prix par passager (crédit)</p>
                                            </div>
                                        </div>
                                        <div class="passenger-quantity-and-price p-2">
                                            <div class="quantity-credit-selector btn-quantity-selector">
                                                <button type="button" class="btn-quantity decrease">-</button>
                                                <input type="text" class="creditCount quantity-input" value="<?= isset($carshare) ? $carshare->getPricePerson() : 2 ?>" readonly>
                                                <button type="button" class="btn-quantity increase">+</button>
                                            </div>
                                            <input type="hidden" name="price_person" id="creditInput" value="<?= isset($carshare) ? $carshare->getPricePerson() : 2 ?>">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="step-buttons">
                            <button type="button" class="btn btn-prev mx-2">Étape précédente</button>
                            <button type="button" class="btn btn-next mx-2">Étape suivante</button>
                        </div>
                    </div>
        <!-- END STEP 4 -->

        <!-- START STEP 5 -->


                    <div id="step5" class="step">
                        <h2>Publication</h2>
                        <hr class="separator">
                        <div class="step-content">
                            <fieldset class="mb-5">
                                <legend>Mon trajet</legend>
                                <div class="bg-light p-2 mt-2">
                                    <div>
                                        <p class="text-dark">Départ : <span id="recap_depart_adress"></span></p>
                                        <p class="text-dark">Arrivée : <span id="recap_arrival_adress"></span></p>
                                    </div>
                                    <div>
                                        <p class="text-dark">Distance : <span id="tripDistanceRecap">-- km</span></p>
                                        <p class="text-dark">Durée théorique : <span id="tripDurationRecap">-- min</span></p>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="mb-5">
                                <legend>Mon véhicule</legend>
                                <div class="bg-light p-2 mt-2">
                                    <div>
                                        <p class="text-dark">Véhicule sélectionné : <span id="recap_vehicle"></span></p>
                                        <p class="text-dark">Places disponibles : <span id="recap_place"></span></p>
                                        <p class="text-dark">Fumeur : <span id="recap_smoking"></span></p>
                                        <p class="text-dark">Animaux de compagnie : <span id="recap_pets"></span></p>
                                        <p class="text-dark">Autres commentaires : <span id="recap_custom"></span></p>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="mb-5">
                                <legend>Date et heure</legend>
                                <div class="bg-light p-2 mt-2">
                                    <p class="text-dark">Départ le <span id="recap_depart_date">--</span> à <span id="recap_depart_time">--</span></p>
                                </div>
                            </fieldset>
                            <fieldset class="mb-5">
                                <legend>Prix</legend>
                                <div class="bg-light p-2 mt-2">
                                    <p class="text-dark">Prix par passager : <span id="recap_price"></span><span> crédits</span></p>
                                </div>
                            </fieldset>
                            <p>En publiant une annonce en tant que conducteur, vous attestez être en possession d'un permis de conduire en cours de validité et d'un véhicule correctement assuré dont le contrôle technique est à jour.</p>
                        </div>
                        <div class="step-buttons">
                            <button type="button" class="btn btn-prev mx-2">Étape précédente</button>
                            <input type="submit" value="Créer mon annonce" name="saveAnnonce" class="btn btn-submit mx-2">
                        </div>
                    </div>
        <!-- END STEP 5 -->
            </form>
        </section>
        <?php else : ?>
            
            <div class="container conteneur pt-5">
                <div class="conteneur-content d-flex justify-content-center flex-wrap">
                    <p class="text-center">Connectez-vous pour ajouter un trajet</p>
                    <a href="/login" class="btn">Je me connecte</a>
                </div>
            </div>
        
        <?php endif ?>

<!-- Modal -->
    <div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-secondary">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="mapModalLabel">Choisir mon itinéraire</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container mt-3" id="map" style="height: 350px;">
                        </div>
                        <div class="modal-footer d-flex flex-column align-items-center">
                        <p class="w-100 text-center mb-2">Distance estimée : <strong id="tripDistanceModal">-- km</strong></p>
                        <p class="w-100 text-center mb-2">Durée estimée : <strong id="tripDurationModal">-- min</strong></p>
                        <div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            <button type="button" class="btn btn-primary">Valider ce trajet</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>