<?php
    $statut = $trip->getStatut();
    $badgeClass = match($statut) {
        'créé' => 'badge bg-light text-dark',
        'en cours' => 'badge bg-warning text-dark',
        'terminé' => 'badge bg-success',
        'annulé' => 'badge bg-danger',
        default => 'badge bg-light text-dark'
    };
?>

<main>
    <section class="big-hero text-center">
        <div class="big-hero-content">
            <h1>Détails du trajet</h1>
        </div>
    </section>

    <section class="conteneur w-100">
        <div class="row conteneur-content">

            <h2>Trajet du <?= date('d/m/Y', strtotime($trip->getDepartDate())) ?> à <?= substr($trip->getDepartTime(), 0, 5) ?></h2>
            <p>Départ : <?= $trip->getDepartAdress() ?></p>
            <p>Arrivée : <?= $trip->getArrivalAdress() ?></p>
            <p>Véhicule : <?= $trip->getVehicle()->getBrand() ?> <?= $trip->getVehicle()->getModel() ?> (<?= $trip->getVehicle()->getColor() ?>)</p>
            <p>Énergie : <?= $trip->getVehicle()->getEnergy() ? 'électrique' : "thermique" ?><img src="<?= $trip->getVehicle()->getEnergyIcon() ?>" alt="" width="25"></p>
            <p>Places dispo : <?= $trip->getVehicle()->getNbPlace() ?></p>
            <p class="<?= $badgeClass ?> my-3 w-25"><?= ucfirst($trip->getStatut()) ?></p>

            <?php if ($trip->getStatut() === 'créé'): ?>
                <div class="d-flex align-items-center">
                <a href="/carshare/<?= $trip->getCarshareId() ?>/edit" class="btn btn-light text-dark me-3">
                    Modifier le trajet
                </a>
                    <form method="POST" action="/carshare/<?= $trip->getCarshareId() ?>/start">
                    <?= csrfField(); ?>
                        <button class="btn btn-warning me-3">Démarrer le trajet</button>
                    </form>
                    <form method="POST" action="/carshare/<?= $trip->getCarshareId() ?>/cancel">
                    <?= csrfField(); ?>
                        <button class="btn bg-danger text-white border-danger me-3">Annuler le trajet</button>
                    </form>
                    <div>
                        <button type="button" class="btn btn-danger me-3" data-bs-toggle="modal" data-bs-target="#suppressionCarshareModal">Supprimer le trajet</button>
                    </div>
                </div>
            <?php elseif ($trip->getStatut() === 'en cours'): ?>
                <form method="POST" action="/carshare/<?= $trip->getCarshareId() ?>/end">
                <?= csrfField(); ?>
                    <button class="btn btn-success">Terminer le trajet</button>
                </form>
            <?php endif; ?>

            <hr>
            <h3>Passagers</h3>
            <?php if(!empty($passengers)): ?>
                <ul>
                    <?php foreach($passengers as $passenger): ?>
                        <li><?= htmlspecialchars($passenger->getFirstName()) ?> <?= htmlspecialchars($passenger->getName()) ?> (<?= htmlspecialchars($passenger->getEmail()) ?>)</li>
                    <?php endforeach; ?>
                </ul>
                <?php else :?>
                    <p>Personne n'a réservé de trajet</p>
            <?php endif ?>
        </div>
    </section>

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
</main>
