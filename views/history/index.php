<main>
    <section class="big-hero text-center">
        <div class="big-hero-content">
            <h1>Mon historique</h1>
        </div>
        <div class="container">
            <?php renderPartial('alert') ?>
        </div>
    </section>

    <section class="conteneur w-100">
        <div class="row conteneur-content">

            <h2 class="mb-3">Mes trajets proposés</h2>

            <?php if(!empty($myTrips)) : ?>
                <?php foreach($myTrips as $trip) : ?>
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h3 class="card-title text-center">
                                    <?=htmlspecialchars($trip->getDepartAdress()) ?><span>
                                        <svg class="mx-3" width="24" height="24" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_41_993)">
                                            <path d="M16.9699 11.0892C17.1261 10.9329 17.2139 10.721 17.2139 10.5C17.2139 10.279 17.1261 10.0671 16.9699 9.91083L12.2557 5.19667C12.1788 5.11708 12.0869 5.05359 11.9852 5.00992C11.8835 4.96624 11.7742 4.94325 11.6635 4.94229C11.5529 4.94133 11.4432 4.96242 11.3408 5.00432C11.2383 5.04622 11.1453 5.10809 11.067 5.18634C10.9888 5.26458 10.9269 5.35763 10.885 5.46004C10.8431 5.56245 10.822 5.67219 10.823 5.78284C10.824 5.89348 10.847 6.00283 10.8906 6.1045C10.9343 6.20617 10.9978 6.29813 11.0774 6.375L14.369 9.66667H3.33321C3.1122 9.66667 2.90024 9.75447 2.74396 9.91075C2.58768 10.067 2.49988 10.279 2.49988 10.5C2.49988 10.721 2.58768 10.933 2.74396 11.0893C2.90024 11.2455 3.1122 11.3333 3.33321 11.3333H14.369L11.0774 14.625C10.9256 14.7822 10.8416 14.9927 10.8435 15.2112C10.8454 15.4297 10.933 15.6387 11.0875 15.7932C11.242 15.9477 11.451 16.0353 11.6695 16.0372C11.888 16.0391 12.0985 15.9551 12.2557 15.8033L16.9699 11.0892Z" fill="black"/>
                                            </g>
                                            <defs>
                                            <clipPath id="clip0_41_993">
                                            <rect width="20" height="20" fill="white" transform="matrix(0 1 -1 0 20 0.5)"/>
                                            </clipPath>
                                            </defs>
                                        </svg>
                                    </span><?=htmlspecialchars($trip->getArrivalAdress()) ?>
                                </h3>
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    Départ : <strong> Le <?= date('d/m/Y', strtotime($trip->getDepartDate())) ?> à <?= substr($trip->getDepartTime(), 0, 5) ?>h</strong>
                                </p>
                                <p class="card-text">
                                    Véhicule utilisé : <?= $trip->getVehicle()->getBrand() ?>
                                </p>
                                <p class="card-text">
                                    Places disponibles : <?= ($trip->getVehicle()->getNbPlace()) ?>
                                </p>
                                <p class="card-text">
                                    Prix par passagers : <?= ($trip->getPricePerson()) ?> crédits
                                </p>
                                <div class="d-flex align-items-start justify-content-between w-50 my-2">
                                    <span class="badge rounded-pill text-white text-bg-primary">
                                        <img src="<?=htmlspecialchars($trip->getVehicle()->getEnergyIcon()); ?>" alt="">
                                    </span>
                                    <span class="badge rounded-pill text-white text-bg-primary">
                                    <?php $smokingIcon = $trip->smoking_icon ?? '/assets/icons/no-smoking.svg'; ?>
                                        <img src="<?=htmlspecialchars($trip->smoking_icon); ?>" alt="">
                                    </span>
                                    <span class="badge rounded-pill text-white text-bg-primary">
                                    <?php $petsIcon = $trip->pets_icon ?? '/assets/icons/no-pets.svg'; ?>
                                        <img src="<?=htmlspecialchars($trip->pets_icon); ?>" alt="">
                                    </span>
                                </div>
                                <p class="card-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-quote" viewBox="0 0 16 16">
                                        <path d="M12 12a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1h-1.388q0-.527.062-1.054.093-.558.31-.992t.559-.683q.34-.279.868-.279V3q-.868 0-1.52.372a3.3 3.3 0 0 0-1.085.992 4.9 4.9 0 0 0-.62 1.458A7.7 7.7 0 0 0 9 7.558V11a1 1 0 0 0 1 1zm-6 0a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1H4.612q0-.527.062-1.054.094-.558.31-.992.217-.434.559-.683.34-.279.868-.279V3q-.868 0-1.52.372a3.3 3.3 0 0 0-1.085.992 4.9 4.9 0 0 0-.62 1.458A7.7 7.7 0 0 0 3 7.558V11a1 1 0 0 0 1 1z"/>
                                    </svg>
                                    <?= htmlspecialchars($trip->custom_preferences) ?>
                                    <svg class="rotate-180" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-quote" viewBox="0 0 16 16" transform="rotate(180)">
                                        <path d="M12 12a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1h-1.388q0-.527.062-1.054.093-.558.31-.992t.559-.683q.34-.279.868-.279V3q-.868 0-1.52.372a3.3 3.3 0 0 0-1.085.992 4.9 4.9 0 0 0-.62 1.458A7.7 7.7 0 0 0 9 7.558V11a1 1 0 0 0 1 1zm-6 0a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1H4.612q0-.527.062-1.054.094-.558.31-.992.217-.434.559-.683.34-.279.868-.279V3q-.868 0-1.52.372a3.3 3.3 0 0 0-1.085.992 4.9 4.9 0 0 0-.62 1.458A7.7 7.7 0 0 0 3 7.558V11a1 1 0 0 0 1 1z"/>
                                    </svg></p>
                                <div class="d-flex justify-content-between align-items-end mt-3">
                                    <a href="/carshare/<?= $trip->getCarshareId() ?>" class="btn btn-primary m-0">Voir le voyage</a>
                                    <?php
                                        $statut = $trip->getStatut();
                                        $badgeClass = match($statut) {
                                            'créé' => 'badge bg-secondary',
                                            'en cours' => 'badge bg-warning text-dark',
                                            'terminé' => 'badge bg-success',
                                            'annulé' => 'badge bg-danger',
                                            default => 'badge bg-light text-dark'
                                        };
                                    ?>
                                    <p class="mt-3">
                                        <span class="<?= $badgeClass ?>"><?= ucfirst($statut) ?></span>
                                    </p>
                                        <a href="/carshare/<?= $trip->getCarshareId() ?>/edit" class="btn-edit" title="Modifier le trajet">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5 20H19C19.2652 20 19.5196 20.1054 19.7071 20.2929C19.8946 20.4804 20 20.7348 20 21C20 21.2652 19.8946 21.5196 19.7071 21.7071C19.5196 21.8946 19.2652 22 19 22H5C4.73478 22 4.48043 21.8946 4.29289 21.7071C4.10536 21.5196 4 21.2652 4 21C4 20.7348 4.10536 20.4804 4.29289 20.2929C4.48043 20.1054 4.73478 20 5 20ZM4 15L14 5L17 8L7 18H4V15ZM15 4L17 2L20 5L17.999 7.001L15 4Z" fill=""/>
                                            </svg>
                                        </a>
                                        <a data-bs-toggle="modal" data-bs-target="#suppressionCarshareModal" class="btn-delete" title="Supprimer le trajet">
                                        <svg width="24" height="24" viewBox="0 0 18 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12.241 1.721L12.534 3.75H16.5C16.6989 3.75 16.8897 3.82902 17.0303 3.96967C17.171 4.11032 17.25 4.30109 17.25 4.5C17.25 4.69891 17.171 4.88968 17.0303 5.03033C16.8897 5.17098 16.6989 5.25 16.5 5.25H15.731L14.858 15.435C14.805 16.055 14.762 16.565 14.693 16.977C14.623 17.406 14.516 17.79 14.307 18.146C13.9788 18.7051 13.4909 19.1533 12.906 19.433C12.534 19.61 12.142 19.683 11.708 19.717C11.291 19.75 10.78 19.75 10.158 19.75H7.842C7.22 19.75 6.709 19.75 6.292 19.717C5.858 19.683 5.466 19.61 5.094 19.433C4.50908 19.1533 4.02118 18.7051 3.693 18.146C3.483 17.79 3.378 17.406 3.307 16.977C3.238 16.564 3.195 16.055 3.142 15.435L2.269 5.25H1.5C1.30109 5.25 1.11032 5.17098 0.96967 5.03033C0.829018 4.88968 0.75 4.69891 0.75 4.5C0.75 4.30109 0.829018 4.11032 0.96967 3.96967C1.11032 3.82902 1.30109 3.75 1.5 3.75H5.466L5.759 1.721L5.77 1.66C5.952 0.87 6.63 0.25 7.48 0.25H10.52C11.37 0.25 12.048 0.87 12.23 1.66L12.241 1.721ZM6.981 3.75H11.018L10.762 1.974C10.714 1.807 10.592 1.75 10.519 1.75H7.481C7.408 1.75 7.286 1.807 7.238 1.974L6.981 3.75ZM8.25 8.5C8.25 8.30109 8.17098 8.11032 8.03033 7.96967C7.88968 7.82902 7.69891 7.75 7.5 7.75C7.30109 7.75 7.11032 7.82902 6.96967 7.96967C6.82902 8.11032 6.75 8.30109 6.75 8.5V13.5C6.75 13.6989 6.82902 13.8897 6.96967 14.0303C7.11032 14.171 7.30109 14.25 7.5 14.25C7.69891 14.25 7.88968 14.171 8.03033 14.0303C8.17098 13.8897 8.25 13.6989 8.25 13.5V8.5ZM11.25 8.5C11.25 8.30109 11.171 8.11032 11.0303 7.96967C10.8897 7.82902 10.6989 7.75 10.5 7.75C10.3011 7.75 10.1103 7.82902 9.96967 7.96967C9.82902 8.11032 9.75 8.30109 9.75 8.5V13.5C9.75 13.6989 9.82902 13.8897 9.96967 14.0303C10.1103 14.171 10.3011 14.25 10.5 14.25C10.6989 14.25 10.8897 14.171 11.0303 14.0303C11.171 13.8897 11.25 13.6989 11.25 13.5V8.5Z" fill=""/>
                                        </svg>
                                        </a>
                                        <!-- Modal suppression-->
                                        <div class="modal fade" id="suppressionCarshareModal" tabindex="-1" aria-labelledby="suppressionModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content bg-secondary">
                                                    <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="suppressionModalLabel">Supprimer le trajet</h1>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="container mt-3 text-center">
                                                            <p>Voulez-vous vraiment supprimer ce trajet ?</p>
                                                            <div class="container d-flex justify-content-center">
                                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
                                                                <form method="POST" action="/carshare/<?= $trip->getCarshareId() ?>/delete">
                                                                <?= csrfField(); ?>
                                                                    <button type="submit" class="btn btn-secondary">Confirmer la suppression</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p class="text-center">Aucun trajet enregistré.</p>
            <?php endif; ?>


            <h2 class="mb-3">Mes trajets en tant que passager</h2>

            <?php if(!empty($joinedTrips)) : ?>
                <?php foreach($joinedTrips as $trip) : ?>
                    <div class="col-sm-6">
                        <div class="card input p-1">
                            <div class="card-header">
                                <h3 class="card-title text-center">
                                    <?=htmlspecialchars($trip->getDepartAdress()) ?><span> - </span><?=htmlspecialchars($trip->getArrivalAdress()) ?>
                                </h3>
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    Départ : <strong> Le <?= date('d/m/Y', strtotime($trip->getDepartDate())) ?> à <?= substr($trip->getDepartTime(), 0, 5) ?>h</strong>
                                </p>
                                <p class="card-text">
                                    Places réservées : <?= $trip->getReservedPlaces(); ?> place<?= $trip->getReservedPlaces() > 1 ? 's' : '' ?>
                                </p>
                                <p class="card-text">
                                    Prix par passagers : <?= ($trip->getPricePerson()) ?> crédits
                                </p>
                                <p class="card-text">
                                    Prix total payé pour ce trajet : <?= ($trip->getPricePerson() * ($trip->getReservedPlaces())) ?> crédits
                                </p>
                                <div>
                                    <h3 class="text-dark ms-0">Conducteur</h3>
                                    <div class="d-flex align-items-center justify-content-between w-50">
                                        <?php if($trip->getDriver()) : ?>
                                            <img class="profile-picture-mini" src="<?= $trip->getDriver()->getPhoto() ?>" alt="Photo du conducteur">
                                            <p class="text-dark"><?= $trip->getDriver()->getFirstname() ?> <?= $trip->getDriver()->getName() ?></p>
                                        <?php else : ?>
                                            <p>Conducteur inconnu</p>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="d-flex align-items-start justify-content-between w-50 my-2">
                                    <span class="badge rounded-pill text-white text-bg-primary">
                                        <img src="<?= $trip->getVehicle()->getEnergyIcon() ?>" alt="Énergie">
                                    </span>
                                    <span class="badge rounded-pill text-white text-bg-primary">
                                        <img src="<?=htmlspecialchars($trip->smoking_icon); ?>" alt="">
                                    </span>
                                    <span class="badge rounded-pill text-white text-bg-primary">
                                        <img src="<?=htmlspecialchars($trip->pets_icon); ?>" alt="">
                                    </span>

                                </div>
                                <div class="d-flex justify-content-between align-items-end mt-3">
                                    <form method="POST" action="/reservation/<?= $trip->getReservationId() ?>/cancel" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?');">
                                        <?= csrfField(); ?>
                                        <button type="submit" class="btn btn-danger">Annuler ma réservation</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p class="text-center">Aucun trajet enregistré.</p>
            <?php endif; ?>
        </div>
    </section>
</main>

