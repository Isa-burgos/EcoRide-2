<section class="big-hero text-center">
    <div class="big-hero-content">
        <div class="container search-trip">
            <button class="search-trip-btn" type="button">
                <div class="search-trip-container">
                    <span>
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12.6667 21.3333C10.2444 21.3333 8.19467 20.4942 6.51733 18.816C4.84 17.1378 4.00089 15.088 4 12.6667C3.99911 10.2453 4.83822 8.19556 6.51733 6.51733C8.19645 4.83911 10.2462 4 12.6667 4C15.0871 4 17.1373 4.83911 18.8173 6.51733C20.4973 8.19556 21.336 10.2453 21.3333 12.6667C21.3333 13.6444 21.1778 14.5667 20.8667 15.4333C20.5556 16.3 20.1333 17.0667 19.6 17.7333L27.0667 25.2C27.3111 25.4444 27.4333 25.7556 27.4333 26.1333C27.4333 26.5111 27.3111 26.8222 27.0667 27.0667C26.8222 27.3111 26.5111 27.4333 26.1333 27.4333C25.7556 27.4333 25.4444 27.3111 25.2 27.0667L17.7333 19.6C17.0667 20.1333 16.3 20.5556 15.4333 20.8667C14.5667 21.1778 13.6444 21.3333 12.6667 21.3333ZM12.6667 18.6667C14.3333 18.6667 15.7502 18.0836 16.9173 16.9173C18.0844 15.7511 18.6676 14.3342 18.6667 12.6667C18.6658 10.9991 18.0827 9.58267 16.9173 8.41733C15.752 7.252 14.3351 6.66844 12.6667 6.66667C10.9982 6.66489 9.58178 7.24844 8.41733 8.41733C7.25289 9.58622 6.66933 11.0027 6.66667 12.6667C6.664 14.3307 7.24756 15.7476 8.41733 16.9173C9.58711 18.0871 11.0036 18.6702 12.6667 18.6667Z" fill="black"/>
                        </svg>
                    </span>
                    <div class="search-trip-direction">
                        <div>
                            <p class="m-0 text-start">
                                <span class="text-dark me-2"><?= htmlspecialchars($depart_adress) ?></span>
                                <span>
                                    <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_41_993)">
                                            <path d="M16.9699 11.0892C17.1261 10.9329 17.2139 10.721 17.2139 10.5C17.2139 10.279 17.1261 10.0671 16.9699 9.91083L12.2557 5.19667C12.1788 5.11708 12.0869 5.05359 11.9852 5.00992C11.8835 4.96624 11.7742 4.94325 11.6635 4.94229C11.5529 4.94133 11.4432 4.96242 11.3408 5.00432C11.2383 5.04622 11.1453 5.10809 11.067 5.18634C10.9888 5.26458 10.9269 5.35763 10.885 5.46004C10.8431 5.56245 10.822 5.67219 10.823 5.78284C10.824 5.89348 10.847 6.00283 10.8906 6.1045C10.9343 6.20617 10.9978 6.29813 11.0774 6.375L14.369 9.66667H3.33321C3.1122 9.66667 2.90024 9.75447 2.74396 9.91075C2.58768 10.067 2.49988 10.279 2.49988 10.5C2.49988 10.721 2.58768 10.933 2.74396 11.0893C2.90024 11.2455 3.1122 11.3333 3.33321 11.3333H14.369L11.0774 14.625C10.9256 14.7822 10.8416 14.9927 10.8435 15.2112C10.8454 15.4297 10.933 15.6387 11.0875 15.7932C11.242 15.9477 11.451 16.0353 11.6695 16.0372C11.888 16.0391 12.0985 15.9551 12.2557 15.8033L16.9699 11.0892Z" fill="black"/>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_41_993">
                                                <rect width="20" height="20" fill="white" transform="matrix(0 1 -1 0 20 0.5)"/>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </span>
                                <span class="text-dark me-2"><?= htmlspecialchars($arrival_adress) ?></span>
                            </p>
                        </div>
                        <div>
                            <p class="m-0 text-secondary text-start me-2"><?= htmlspecialchars(formatDateFr($depart_date)) ?>, <?= htmlspecialchars($nb_place) ?> passager<?= $nb_place > 1 ? 's' : '' ?></p>
                        </div>
                    </div>
                </div>
            </button>
            <button class="filter-btn" type="button" data-bs-toggle="modal" data-bs-target="#filterModal">Filtrer</button>
        </div>
    </div>
</section>

<main class="covoiturages-results">
    <section class="covoiturages-dashboard">
        <div class="covoiturages-dashboard-content">
            <div class="recap-search">
            <?php if (!empty($error)) : ?>
                <div class="alert alert-warning"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

                <div class="recap-search-date">
                    <h2><?= htmlspecialchars(formatDateFr($depart_date)) ?></h2>
                </div>
                <div class="recap-search-trip text-primary">
                    <span><?= htmlspecialchars($depart_adress) ?></span>
                    <span>
                        <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_41_993)">
                                <path class="arrow" d="M16.9699 11.0892C17.1261 10.9329 17.2139 10.721 17.2139 10.5C17.2139 10.279 17.1261 10.0671 16.9699 9.91083L12.2557 5.19667C12.1788 5.11708 12.0869 5.05359 11.9852 5.00992C11.8835 4.96624 11.7742 4.94325 11.6635 4.94229C11.5529 4.94133 11.4432 4.96242 11.3408 5.00432C11.2383 5.04622 11.1453 5.10809 11.067 5.18634C10.9888 5.26458 10.9269 5.35763 10.885 5.46004C10.8431 5.56245 10.822 5.67219 10.823 5.78284C10.824 5.89348 10.847 6.00283 10.8906 6.1045C10.9343 6.20617 10.9978 6.29813 11.0774 6.375L14.369 9.66667H3.33321C3.1122 9.66667 2.90024 9.75447 2.74396 9.91075C2.58768 10.067 2.49988 10.279 2.49988 10.5C2.49988 10.721 2.58768 10.933 2.74396 11.0893C2.90024 11.2455 3.1122 11.3333 3.33321 11.3333H14.369L11.0774 14.625C10.9256 14.7822 10.8416 14.9927 10.8435 15.2112C10.8454 15.4297 10.933 15.6387 11.0875 15.7932C11.242 15.9477 11.451 16.0353 11.6695 16.0372C11.888 16.0391 12.0985 15.9551 12.2557 15.8033L16.9699 11.0892Z" fill="black"/>
                            </g>
                            <defs>
                                <clipPath id="clip0_41_993">
                                    <rect width="20" height="20" fill="white" transform="matrix(0 1 -1 0 20 0.5)"/>
                                </clipPath>
                            </defs>
                        </svg>
                    </span>
                    <span><?= htmlspecialchars($arrival_adress) ?></span>
                    <span>:</span><br>
                    
                    <span><?= count($results) ?> trajet<?= count($results) > 1 ? 's' : '' ?> disponible<?= count($results) > 1 ? 's' : '' ?></span>

                </p>
                </div>
            </div>
    
            <div class="dashboard-result">
                <?php foreach($results as $carshare): ?>
                    <?php
                        $start = new DateTime($carshare->getDepartTime());
                        $end = new DateTime($carshare->getArrivalTime());
                        $interval = $start->diff($end);
                        $duration = sprintf('%01dh%02d', $interval->h, $interval->i);
                        ?>
                <ul class="p-0">
                    <li>
                        <a href="/carshare/<?= $carshare->getCarshareId() ?>/details">
                            <div class="trip-card p-0">
                                <div class="trip-details-top">
                                    <div class="trip-details-left p-2">
                                        <div class="trip-hour">
                                            <span class="trip-depart"><?= htmlspecialchars(formatHeureFr($carshare->getDepartTime())) ?></span>
                                            <span class="trip-duration"><?= $duration ?></span>
                                            <span class="trip-arrival"><?= htmlspecialchars(formatHeureFr($carshare->getArrivalTime())) ?></span>
                                        </div>
                                        <div class="trip-picto">
                                            <div class="dot"></div>
                                            <hr class="line"></hr>
                                            <div class="dot"></div>
                                        </div>
                                        <div class="trip-place">
                                            <span class="trip-depart"><?= htmlspecialchars($carshare->getDepartAdress()) ?></span>
                                            <span class="trip-arrival"><?= htmlspecialchars($carshare->getArrivalAdress()) ?></span>
                                        </div>
                                    </div>
                                    <div class="trip-details-right p-2">
                                        <div class="trip-price">
                                            <p class="m-0"><?= htmlspecialchars($carshare->getPricePerson()) ?> <span>crédits</span></p>
                                        </div>
                                        <div class="trip-passenger">
                                            <?php if($carshare->getAvailablePlaces() > 0) : ?>
                                                <p class="m-0"><?= htmlspecialchars($carshare->getAvailablePlaces()) ?><span> passager<?= ($carshare->getAvailablePlaces()) > 1 ? 's' : '' ?></span></p>
                                            <?php else : ?>
                                                <p class="m-0">COMPLET</p>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <hr>
                                <div class="trip-details-bottom">
                                    <?php if ($carshare->getDriver()): ?>
                                    <div class="profile-photo">
                                        <img src="/<?= htmlspecialchars($carshare->getDriver()->getPhoto()) ?>" alt="Photo de profil">
                                    </div>
                                    <div class="name-container">
                                        <div>
                                            <p class="text-secondary"><?= htmlspecialchars($carshare->getDriver()->getPseudo()) ?></p>
                                        </div>
                                        <div class="rating">
                                            <div>
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M9.99979 14.3958L6.54145 16.4792C6.38867 16.5764 6.22895 16.6181 6.06229 16.6042C5.89562 16.5903 5.74979 16.5347 5.62479 16.4375C5.49979 16.3403 5.40256 16.2189 5.33312 16.0733C5.26367 15.9278 5.24979 15.7645 5.29145 15.5833L6.20812 11.6458L3.14562 9.00001C3.00673 8.87501 2.92006 8.7325 2.88562 8.5725C2.85117 8.4125 2.86145 8.25639 2.91645 8.10417C2.97145 7.95195 3.05479 7.82695 3.16645 7.72917C3.27812 7.63139 3.4309 7.56889 3.62479 7.54167L7.66645 7.18751L9.22895 3.47917C9.2984 3.31251 9.40617 3.1875 9.55229 3.10417C9.6984 3.02084 9.84756 2.97917 9.99979 2.97917C10.152 2.97917 10.3012 3.02084 10.4473 3.10417C10.5934 3.1875 10.7012 3.31251 10.7706 3.47917L12.3331 7.18751L16.3748 7.54167C16.5692 7.56945 16.722 7.63195 16.8331 7.72917C16.9442 7.82639 17.0276 7.95139 17.0831 8.10417C17.1387 8.25695 17.1492 8.41334 17.1148 8.57334C17.0803 8.73334 16.9934 8.87556 16.854 9.00001L13.7915 11.6458L14.7081 15.5833C14.7498 15.7639 14.7359 15.9272 14.6665 16.0733C14.597 16.2194 14.4998 16.3408 14.3748 16.4375C14.2498 16.5342 14.104 16.5897 13.9373 16.6042C13.7706 16.6186 13.6109 16.5769 13.4581 16.4792L9.99979 14.3958Z" fill="#59642F"/>
                                                    </svg>
                                            </div>
                                            <div class="note">
                                                <p class="text-secondary">5,0</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <!--<span class="badge rounded-pill text-bg-primary">
                                            <img src="<?= htmlspecialchars($carshare->getEnergyIcon()) ?>" alt="énergie" width="20">
                                        </span> -->
                                    </div>
                                    <?php endif ?>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
                <?php endforeach ?>
            </div>
        </div>
    </section>
    
    <aside class="filter">
        <form action="/carshare/results" method="get">
            <input type="hidden" name="depart_adress" value="<?= htmlspecialchars($_GET['depart_adress'] ?? '') ?>">
            <input type="hidden" name="arrival_adress" value="<?= htmlspecialchars($_GET['arrival_adress'] ?? '') ?>">
            <input type="hidden" name="depart_date" value="<?= htmlspecialchars($_GET['depart_date'] ?? '') ?>">
            <input type="hidden" name="nb_place" value="<?= htmlspecialchars($_GET['nb_place'] ?? 1) ?>">

            <div class="container mt-3">
                <h3>Trier par</h3>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="sort" value="depart_asc">
                    <label class="form-check-label" for="sort">Départ le plus tôt</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="sort" value="price_asc">
                    <label class="form-check-label" for="sort">Prix le plus bas</label>
                </div>
            </div>
            <hr>
            <div class="container">
                <h3>Heure de départ</h3>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="time[]" value="morning">
                    <label class="form-check-label" for="">06:00 - 12:00</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="time[]" value="afternoon">
                    <label class="form-check-label" for="">12:01 - 18:00</label>
                </div>
            </div>
            <hr>
            <div class="container mb-3">
                <h3>Services</h3>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="services[]" value="electric">
                    <label class="form-check-label" for="">Véhicule électrique</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="services[]" value="smoking">
                    <label class="form-check-label" for="">Cigarette autorisée</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="services[]" value="pets">
                    <label class="form-check-label" for="">Animaux de compagnie autorisés</label>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">Voir les trajets</button>
                </div>
            </div>
        </form>
    </aside>
</main>

<!-- Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-secondary">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="filterModalLabel">Filtrer</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/carshare/results" method="get">
                <input type="hidden" name="depart_adress" value="<?= htmlspecialchars($_GET['depart_adress'] ?? '') ?>">
                <input type="hidden" name="arrival_adress" value="<?= htmlspecialchars($_GET['arrival_adress'] ?? '') ?>">
                <input type="hidden" name="depart_date" value="<?= htmlspecialchars($_GET['depart_date'] ?? '') ?>">
                <input type="hidden" name="nb_place" value="<?= htmlspecialchars($_GET['nb_place'] ?? 1) ?>">
                
                    <div class="container mt-3">
                        <h3>Trier par</h3>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="sort" value="depart_asc">
                            <label class="form-check-label" for="sort">Départ le plus tôt</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="sort" value="price_asc">
                            <label class="form-check-label" for="sort">Prix le plus bas</label>
                        </div>
                    </div>
                    <hr>
                    <div class="container">
                        <h3>Heure de départ</h3>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="time[]" value="morning">
                            <label class="form-check-label" for="">06:00 - 12:00</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="time[]" value="afternoon">
                            <label class="form-check-label" for="">12:01 - 18:00</label>
                        </div>
                    </div>
                    <hr>
                    <div class="container mb-3">
                        <h3>Services</h3>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="services[]" value="electric">
                            <label class="form-check-label" for="">Véhicule électrique</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="services[]" value="smoking">
                            <label class="form-check-label" for="">Cigarette autorisée</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="services[]" value="pets">
                            <label class="form-check-label" for="">Animaux de compagnie autorisés</label>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">Voir les trajets</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>