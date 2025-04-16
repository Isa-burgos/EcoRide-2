<?php
    $statut = $trip['statut'];
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

            <h2>Trajet du <?= date('d/m/Y', strtotime($trip['depart_date'])) ?> à <?= substr($trip['depart_time'], 0, 5) ?></h2>
            <p>Départ : <?= $trip['depart_adress'] ?></p>
            <p>Arrivée : <?= $trip['arrival_adress'] ?></p>
            <p>Véhicule : <?= $trip['brand'] ?> <?= $trip['model'] ?> (<?= $trip['color'] ?>)</p>
            <p>Énergie : <?= $trip['energy'] ? 'électrique' : "thermique" ?><img src="<?= $trip['energy_icon'] ?>" alt="" width="25"></p>
            <p>Places dispo : <?= $trip['nb_place'] ?></p>
            <p class="<?= $badgeClass ?> my-3 w-25"><?= ucfirst($trip['statut']) ?></p>

            <?php if ($trip['statut'] === 'créé'): ?>
                <div class="d-flex align-items-center">
                <a href="/carshare/<?= $trip['carshare_id'] ?>/edit" class="btn btn-light text-dark me-3">
                    Modifier le trajet
                </a>
                    <form method="POST" action="/carshare/<?= $trip['carshare_id'] ?>/start">
                        <button class="btn btn-warning me-3">Démarrer le trajet</button>
                    </form>
                    <form method="POST" action="/carshare/<?= $trip['carshare_id'] ?>/cancel">
                        <button class="btn bg-danger text-white border-danger me-3">Annuler le trajet</button>
                    </form>
                    <div>
                        <button type="button" class="btn btn-danger me-3" data-bs-toggle="modal" data-bs-target="#suppressionCarshareModal">Supprimer le trajet</button>
                    </div>
                </div>
            <?php elseif ($trip['statut'] === 'en cours'): ?>
                <form method="POST" action="/carshare/<?= $trip['carshare_id'] ?>/end">
                    <button class="btn btn-success">Terminer le trajet</button>
                </form>
            <?php endif; ?>

            <hr>
            <h3>Passagers</h3>
            <?php if(!empty($passengers)): ?>
                <ul>
                    <?php foreach($passengers as $passenger): ?>
                        <li><?= $passenger['firstname'] ?> <?= $passenger['name'] ?> (<?= $passenger['email'] ?>)</li>
                    <?php endforeach; ?>
                <?php else :?>
                    <p>Personne n'a réservé de trajet</p>
                </ul>
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
                        <form method="POST" action="/carshare/<?= $trip['carshare_id'] ?>/delete">
                            <button type="submit" class="btn btn-secondary">Confirmer la suppression</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
