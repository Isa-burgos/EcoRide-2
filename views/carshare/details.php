<?php
    $start = new DateTime($trip->getDepartTime());
    $end = new DateTime($trip->getArrivalTime());
    $interval = $start->diff($end);
    $duration = sprintf('%01dh%02d', $interval->h, $interval->i);
?>

<main>
    <section class="big-hero text-center">
        <div class="big-hero-content">
        </div>
    </section>
    
    <section class="covoiturages-dashboard">
        <div class="covoiturages-dashboard-content">
            <div class="recap-search">
                <div class="recap-search-date">
                    <h2><?= htmlspecialchars(formatDateFr($trip->getDepartDate())) ?></h2>
                    <?php renderPartial('alert'); ?>
                </div>
            </div>

    
            <div class="dashboard-result">
                <div class="trip-card p-0">
                    <div class="trip-details-top">
                        <div class="trip-details-left p-2">
                            <div class="trip-hour">
                                <span class="trip-depart"><?= htmlspecialchars(formatHeureFr($trip->getDepartTime())) ?></span>
                                <span class="trip-duration"><?= $duration ?></span>
                                <span class="trip-arrival"><?= htmlspecialchars(formatHeureFr($trip->getArrivalTime())) ?></span>
                            </div>
                            <div class="trip-picto">
                                <div class="dot"></div>
                                <hr class="line"></hr>
                                <div class="dot"></div>
                            </div>
                            <div class="trip-place">
                                <span class="trip-depart"><?= htmlspecialchars($trip->getDepartAdress()) ?></span>
                                <span class="trip-arrival"><?= htmlspecialchars($trip->getArrivalAdress()) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="trip-card p-0">
                    <div class="d-flex justify-content-between">
                        <div class="trip-details-bottom">
                            <div>
                            <img class="profile-picture" src="/<?= htmlspecialchars($trip->getDriver()->getPhoto()) ?>" alt="Photo de profil">
                            </div>
                            <div class="name-container">
                                <div>
                                    <p class="text-secondary"><?= htmlspecialchars($trip->getDriver()->getPseudo()) ?></p>
                                </div>
                                <div class="rating">
                                    <div>
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.99979 14.3958L6.54145 16.4792C6.38867 16.5764 6.22895 16.6181 6.06229 16.6042C5.89562 16.5903 5.74979 16.5347 5.62479 16.4375C5.49979 16.3403 5.40256 16.2189 5.33312 16.0733C5.26367 15.9278 5.24979 15.7645 5.29145 15.5833L6.20812 11.6458L3.14562 9.00001C3.00673 8.87501 2.92006 8.7325 2.88562 8.5725C2.85117 8.4125 2.86145 8.25639 2.91645 8.10417C2.97145 7.95195 3.05479 7.82695 3.16645 7.72917C3.27812 7.63139 3.4309 7.56889 3.62479 7.54167L7.66645 7.18751L9.22895 3.47917C9.2984 3.31251 9.40617 3.1875 9.55229 3.10417C9.6984 3.02084 9.84756 2.97917 9.99979 2.97917C10.152 2.97917 10.3012 3.02084 10.4473 3.10417C10.5934 3.1875 10.7012 3.31251 10.7706 3.47917L12.3331 7.18751L16.3748 7.54167C16.5692 7.56945 16.722 7.63195 16.8331 7.72917C16.9442 7.82639 17.0276 7.95139 17.0831 8.10417C17.1387 8.25695 17.1492 8.41334 17.1148 8.57334C17.0803 8.73334 16.9934 8.87556 16.854 9.00001L13.7915 11.6458L14.7081 15.5833C14.7498 15.7639 14.7359 15.9272 14.6665 16.0733C14.597 16.2194 14.4998 16.3408 14.3748 16.4375C14.2498 16.5342 14.104 16.5897 13.9373 16.6042C13.7706 16.6186 13.6109 16.5769 13.4581 16.4792L9.99979 14.3958Z" fill="#59642F"/>
                                            </svg>
                                    </div>
                                    <div class="note">
                                        <p class="text-secondary">5,0/5,0<span> - </span>21 avis</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-2">
                            <button class="btn-little">détails</button>
                        </div>
                    </div>
                    
                    <div class="container">
                        <div class="row row-cols-2 row-cols-lg-4 g-4 my-3 text-center">
                            <div class="col">
                                <div class="trip-services">
                                    <h3>Places disponibles</h3>
                                    <p><?= htmlspecialchars($trip->getAvailablePlaces()) ?></p>
                                </div>
                            </div>
                            <?php
                                $ecoFriendly = in_array($trip->getEnergy(), [1, 2]);
                            ?>
                            <div class="col">
                                <div class="trip-services">
                                    <h3><?= $ecoFriendly ? 'Voyage écologique' : 'Voyage classique' ?></h3>
                                    <span class="trip-picto"><img src="<?= $trip->getEnergyIcon() ?>" alt="icône énergie"></span>
                                </div>
                            </div>
                            <?php $isSmoker = $trip->smoking_icon === 'smoking' ?>
                            <div class="col">
                                <div class="trip-services">
                                    <h3><?= $isSmoker ? 'Fumeur' : 'Non fumeur' ?></h3>
                                    <span class="trip-picto"><img src="<?= $isSmoker ? "/assets/icons/smoke.svg" : "/assets/icons/no-smoking.svg" ?>" alt="icône préférence"> </span>
                                </div>
                            </div>
                            <?php $pets = $trip->pets_icon === 'pets' ?>
                            <div class="col">
                                <div class="trip-services">
                                    <h3><?= $pets ? 'Animaux autorisés' : 'Pas d\'animaux' ?></h3>
                                    <span class="trip-picto"><img src="<?= $pets ? "/assets/icons/pets.svg" : "/assets/icons/no-pets.svg" ?>" alt="icône préférence"></span>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 mb-4">
                                <div class="trip-services">
                                    <h3><?= htmlspecialchars($trip->getBrand()) ?> - <?= htmlspecialchars($trip->getModel()) ?> - <?= htmlspecialchars($trip->getColor()) ?></h3>
                                    <span class="trip-picto"><img class="picto-car" src="/assets/icons/car.svg" alt="icône voiture"></span>
                                </div>
                            </div>
                            <?php if ($trip->custom_preferences) : ?>
                                <div class="col-12 col-lg-6 mb-4">
                                    <div class="trip-services">
                                        <h3>Autres préférences</h3>
                                        <span><?= $trip->custom_preferences ?></span>
                                    </div>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
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
                            <p class="m-0 text-dark">passager</p>
                        </div>
                    </div>
                    <div class="passenger-quantity-and-price p-2">
                        <div class="btn-quantity-container quantity-selector" data-min="1" data-max="<?= htmlspecialchars($trip->getAvailablePlaces()) ?>">
                            <button class="btn-quantity decrease">-</button>
                            <input type="text" class="quantity-input" value="1" readonly>
                            <button class="btn-quantity increase">+</button>
                        </div>
                        <input type="hidden" id="pricePerPerson" value="<?= $trip->getPricePerson() ?>">
                        <input type="hidden" id="displayPassengerCount" value="1">
                        <div class="trip-price">
                            <p class="m-0 text-dark"><span id="totalPrice"><?= htmlspecialchars($trip->getPricePerson()) ?></span> Crédits</p>
                        </div>
                    </div>
                </div>
                <div>
                    <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#confirmationModal">Réserver</button>
                </div>
            </div>
            </div>
        </div>
    </section>
    
    <!-- Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-secondary">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="confirmationModalLabel">Confirmation</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container mt-3 text-center">
                        <p>Voulez-vous vraiment réserver ce trajet ?</p>
                        <div class="container d-flex justify-content-center">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
                            <form action="/carshare/<?= $trip->getCarshareId() ?>/reserve" method="POST">
                            <?= csrfField(); ?>
                                <input type="hidden" name="carshare_id" value="<?= $trip->getCarshareId() ?>">
                                <input type="hidden" name="number_of_passengers" id="passengerCountInputHidden" value="1">
                                <button type="submit" class="btn btn-secondary">Confirmer la réservation</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    const maxPassengers = <?= $trip->getAvailablePlaces() ?>;
</script>
