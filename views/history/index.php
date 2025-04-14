<main>
    <section class="big-hero text-center">
        <div class="big-hero-content">
            <h1>Mon historique</h1>
        </div>
    </section>

    <section class="conteneur w-100">
        <div class="row conteneur-content">

            <h2 class="mb-3">Mes trajets proposés</h2>

            <?php if(!empty($myTrips)) : ?>
                <?php foreach($myTrips as $trip) : ?>
                    <div class="col-sm-6">
                        <div class="card mb-4 bg-dark text-white">
                            <div class="card-header">
                                <h5 class="card-title text-center">
                                    <?=htmlspecialchars($trip['depart_adress']) ?><span> - </span><?=htmlspecialchars($trip['arrival_adress']) ?>
                                </h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    Départ : <strong> Le <?= date('d/m/Y', strtotime($trip['depart_date'])) ?> à <?= substr($trip['depart_time'], 0, 5) ?>h</strong>
                                </p>
                                <p class="card-text">
                                    Véhicule utilisé : <?= $trip['brand'] ?>
                                </p>
                                <p class="card-text">
                                    Places disponibles : <?= ($trip['nb_place']) ?>
                                </p>
                                <p class="card-text">
                                    Prix par passagers : <?= ($trip['price_person']) ?> crédits
                                </p>
                                <div class="d-flex justify-content-between align-items-end mt-3">
                                    <a href="#" class="btn btn-primary m-0">Voir le voyage</a>
                                    <?php
                                        $statut = $trip['statut'];
                                        $badgeClass = match($statut) {
                                            'créé' => 'badge bg-secondary',
                                            'en cours' => 'badge bg-warning text-dark',
                                            'terminé' => 'badge bg-success',
                                            default => 'badge bg-light text-dark'
                                        };
                                    ?>
                                    <p class="mt-3">
                                        <span class="<?= $badgeClass ?>"><?= ucfirst($statut) ?></span>
                                    </p>
                                    <span class="badge rounded-pill text-white text-bg-primary">
                                        <img src="<?=htmlspecialchars($trip['energy_icon']); ?>" alt="Type d'énergie du véhicule">
                                    </span>
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
                                    <?=htmlspecialchars($trip['depart_adress']) ?><span> - </span><?=htmlspecialchars($trip['arrival_adress']) ?>
                                </h3>
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    Départ : <?= ($trip['depart_time']) ?> - Arrivée : <?= ($trip['arrival_time']) ?>
                                </p>
                                <p class="card-text">
                                    Places disponibles : <?= ($trip['nb_place']) ?>
                                </p>
                                <p class="card-text">
                                    Prix par passagers : <?= ($trip['price_person']) ?> crédits
                                </p>
                                <div class="d-flex justify-content-between align-items-end mt-3">
                                    <a href="#" class="btn btn-primary m-0">Voir le voyage</a>
                                    <span class="badge rounded-pill text-white text-bg-primary">
                                        <img src="/assets/icons/<?=htmlspecialchars($trip['energy_icon']); ?>" alt="">
                                    </span>
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