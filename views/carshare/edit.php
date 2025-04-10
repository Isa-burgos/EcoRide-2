<main>
    <section class="big-hero text-center">
        <div class="big-hero-content">
            <h1>Proposer un trajet</h1>
        </div>
    </section>


    <section class="conteneur">
        <form class="conteneur-content" method="POST" action="trip.php">

            <!-- START STEP 1 -->
                <div id="step1" class="step active">
                    <h2>Mon trajet</h2>
                    <hr class="separator">
                    <div class="step-content">
                        <fieldset>
                            <legend>Adresse de départ</legend>
                            <div class="input-container">
                                <label for="depart_adress"></label>
                                <input class="input startAdress" type="text" value="<?= $departAdress?>" name="depart_adress" placeholder="Adresse de départ" required>
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
                        <fieldset>
                            <legend>Adresse d'arrivée</legend>
                            <div class="input-container">
                                <label for="arrival_adress"></label>
                                <input class="input endAdress" type="text" value="<?= $arrivalAdress?>" name="arrival_adress" placeholder="Adresse d'arrivée" required>
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
                                        <?php foreach($userVehicles as$index => $vehicle) : ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                        name="used_vehicle"
                                                        value="<?= $vehicle['vehicle_id']?>"
                                                        id="vehicle_<?= $vehicle['vehicle_id']?>"
                                                        <?=count($userVehicles) === 1 ? 'checked' : '' ?>>
                                                <label class="form-check-label text-white" for="vehicle_<?= $vehicle['vehicle_id']; ?>">
                                                <?= htmlspecialchars($vehicle['brand'] . " " . $vehicle['model']); ?>
                                                </label>
                                            </div>
                                        <?php endforeach ?>
                                    <?php else : ?>
                                        <p>Aucun véhicule enregistré <a href="/add-vehicle.php">Ajouter un véhicule</a></p>
                                    <?php endif ?>
                                </div>
                                <div class="reservation">
                                    <div class="passenger-quantity p-0">
                                        <div class="passenger-icon p-2">
                                            <div class="trip-price">
                                                <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.5 7C8.5 5.93913 8.92143 4.92172 9.67157 4.17157C10.4217 3.42143 11.4391 3 12.5 3C13.5609 3 14.5783 3.42143 15.3284 4.17157C16.0786 4.92172 16.5 5.93913 16.5 7C16.5 8.06087 16.0786 9.07828 15.3284 9.82843C14.5783 10.5786 13.5609 11 12.5 11C11.4391 11 10.4217 10.5786 9.67157 9.82843C8.92143 9.07828 8.5 8.06087 8.5 7ZM8.5 13C7.17392 13 5.90215 13.5268 4.96447 14.4645C4.02678 15.4021 3.5 16.6739 3.5 18C3.5 18.7956 3.81607 19.5587 4.37868 20.1213C4.94129 20.6839 5.70435 21 6.5 21H18.5C19.2956 21 20.0587 20.6839 20.6213 20.1213C21.1839 19.5587 21.5 18.7956 21.5 18C21.5 16.6739 20.9732 15.4021 20.0355 14.4645C19.0979 13.5268 17.8261 13 16.5 13H8.5Z" fill="#59642F"/>
                                                </svg>
                                            </div>
                                            <div class="trip-passenger">
                                                <p class="m-0">Nombre de places disponibles</p>
                                            </div>
                                        </div>
                                        <div class="passenger-quantity-and-price p-2">
                                            <div class="quantity-selector btn-quantity-selector">
                                                <button type="button" class="btn-quantity decrease">-</button>
                                                <input type="text" name="quantityPassenger" class="passengerCount quantity-input" value="<?= $nbPlace?>" readonly>
                                                <button type="button" class="btn-quantity increase">+</button>
                                            </div>
                                            <input type="hidden" name="nb_place" id="nbPlaceInput" value="<?= $nbPlace?>">
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="">
                                        <label class="form-check-label" for="">
                                        Mon véhicule est électrique
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="">
                                        <label class="form-check-label" for="">
                                        Mon véhicule est fumeur
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="">
                                        <label class="form-check-label" for="">
                                        J'accepte les animaux de compagnie
                                        </label>
                                    </div>
                                    <div class="mb-3">
                                        <label for="otherPreferences" class="form-label">Quelque chose à ajouter?</label>
                                        <textarea class="form-control input" id="otherPreferences" rows="3" placeholder="Vous ne prenez pas l'autoroute? L'espace dans votre coffre est limité?"></textarea>
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
                                            <input class="input form-control" name="depart_date" id="depart_date" type="date" value="<?= $departDate?>" required>
                                        </div>
                                        <div>
                                            <fieldset>
                                                <legend>Heure</legend>
                                                <select class="input" name="hour" id="hour">
                                                    <?php for($h = 8; $h <= 19; $h++): ?>
                                                        <option value="<?= sprintf('%02d', $h) ?>" <?= ($hour == $h) ? 'selected' : '' ?>>
                                                            <?= sprintf('%02d', $h) ?>
                                                        </option>
                                                    <?php endfor ?>
                                                </select>
                                                <label for="hour">h</label>
                                                <select class="input" name="minute" id="minute">
                                                    <?php foreach (["00", "15", "30", "45"] as $m): ?>
                                                        <option value="<?= $m ?>" <?= ($minute == $m) ? 'selected' : '' ?>>
                                                            <?= $m ?>
                                                        </option>
                                                    <?php endforeach ?>
                                                </select>
                                                <label for="minute">min</label>
                                                <input type="hidden" name="depart_time" id="depart_time" value="<?= $departTime?>">
                                                <input type="hidden" name="arrival_time" id="arrival_time" value="<?= $arrivalTime?>">

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
                                <div>
                                    <input type="checkbox">
                                    <label for="">Je souhaite éviter les péages</label>
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
                                                <input type="text" class="creditCount quantity-input" value="<?= $pricePerson?>" readonly>
                                                <button type="button" class="btn-quantity increase">+</button>
                                            </div>
                                            <input type="hidden" name="price_person" id="creditInput" value="<?= $pricePerson?>">
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
                            <fieldset>
                                <legend>Mon trajet</legend>
                                <div>
                                    <div>
                                        <p>Départ : <span><?= $_SESSION['carshare']['depart_adress'] ?? '' ?></span></p>
                                        <p>Arrivée : <span><?= $_POST['arrival_adress'] ?? '' ?></span></p>
                                    </div>
                                    <div>
                                        <p>Distance : <span id="tripDistanceRecap">-- km</span></p>
                                        <p>Durée théorique : <span id="tripDurationRecap">-- min</span></p>
                                    </div>
                                    <a href="#step1">Modifier</a>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Mon véhicule</legend>
                                <div>
                                    <div>
                                        <p>Places disponibles : <span><?= $_POST['nb_place'] ?? 'Non renseigné' ?></span></p>
                                        <p>Véhicule thermique</p>
                                        <p>Véhicule non fumeur</p>
                                        <p>Pas d'animaux de compagnie</p>
                                        <p>Autres commentaires</p>
                                    </div>
                                    <a href="#">Modifier</a>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Date et heure</legend>
                                <div>
                                    <p>Départ le <span> <?= $_POST['depart_date'] ?? 'Non renseigné' ?> </span>à<span> <?= $_POST['depart_time'] ?? 'Non renseigné' ?> </span></p>
                                </div>
                                <a href="#">Modifier</a>
                            </fieldset>
                            <fieldset>
                                <legend>Prix</legend>
                                <div>
                                    <p>Prix par passager :<span> <?= $_POST['price_person'] ?? 'Non renseigné' ?></span></p>
                                </div>
                                <a href="#">Modifier</a>
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
            
                <div class="container conteneur pt-5">
                    <div class="conteneur-content d-flex justify-content-center flex-wrap">
                        <p class="text-center">Connectez-vous pour ajouter un trajet</p>
                        <a href="/login.php" class="btn">Je me connecte</a>
                    </div>

                </div>

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