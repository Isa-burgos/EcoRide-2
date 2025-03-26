<?php

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    $statuts = $statuts ?? [];
    $vehicles = $vehicles ?? [];
    $user = $user ?? null;

    $birthDate = ($user && method_exists($user, 'getBirthDate')) ? substr($user->getBirthDate(), 0, 10) : '';
    $photo = ($user && method_exists($user, 'getPhoto')) ? '/' . htmlspecialchars($user->getPhoto()) : '/public/assets/img/default-profile.png';

?>
<main>
    <section class="big-hero text-center">
        <div class="big-hero-content">
            <h1>Mon compte</h1>
        </div>
    </section>

    <section>
        <div class="container mt-5 mb-5">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card shadow">
                        <div class="card-header bg-dark text-light text-center">
                            <h4>Modifier mon compte</h4>
                            <?php if(isset($_SESSION['info'])): ?>
                                <div class="alert alert-info">
                                    <?= htmlspecialchars($_SESSION['info']) ?>
                                </div>
                                <?php unset($_SESSION['info']) ?>
                            <?php endif ?>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="/update-account" enctype="multipart/form-data">

                                <div class="mb-4 text-center">
                                    <img src="<?= $photo ?>" alt="profil" class="rounded-circle" width="120" height="120">
                                </div>
                                <div class="mb-3">
                                    <label for="photo" class="form-label">Changer la photo de profil</label>
                                    <input type="file" name="photo" id="photo" class="form-control" accept="image/png, image/jpeg">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Genre</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" id="homme" name="gender" value="homme"<?= ($user?->getGender() ?? '') === 'homme' ? 'checked' : '' ?>>
                                            <label for="homme">Homme</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" id="femme" name="gender" value="femme"<?= ($user?->getGender() ?? '') === 'femme' ? 'checked' : '' ?>>
                                            <label for="femme">Femme</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="name" class="form-label">Nom</label>
                                    <input class="input form-control" type="text" name="name" id="name" placeholder="Nom" value="<?= htmlspecialchars($user?->getName() ?? '')?>">
                                </div>
                                <div class="mb-3">
                                    <label for="firstname" class="form-label">Prénom</label>
                                    <input class="input form-control" type="text" name="firstname" id="firstname" placeholder="Prénom" value="<?= htmlspecialchars($user?->getFirstname() ?? '')?>">
                                </div>
                                <div class="mb-3">
                                    <label for="pseudo" class="form-label">Pseudo</label>
                                    <input class="input form-control" name="pseudo" type="text" id="pseudo" placeholder="Pseudo" value="<?= htmlspecialchars($user?->getPseudo() ?? '')?>" required>
                                    <div class="invalid-feedback">
                                        Le pseudo est requis
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="phoneNumber" class="form-label">Téléphone</label>
                                    <input class="input form-control" type="text" name="phone" id="phone" placeholder="0606060606" value="<?= htmlspecialchars($user?->getPhone() ?? '')?>">
                                </div>
                                <div class="mb-3">
                                    <label for="birth_date" class="form-label">Date de naissance</label>
                                    <input type="date" class="input form-control" name="birth_date" value="<?= htmlspecialchars($birthDate)?>">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input class="input form-control" type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($user?->getEmail() ?? '')?>">
                                </div>

                                <hr class="my-4">

                                <h5 class="mb-3">Je suis</h5>
                                <div class="mb-3">
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="checkbox form-check-input" type="checkbox" id="isPassenger" name="statuts[]" value="Passager"
                                                <?= in_array('passager', $statuts) ? 'checked' : '' ?>>
                                            <label for="isPassenger" class="form-check-label">Je suis passager</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input checkbox-driver" type="checkbox" id="isDriver" name="statuts[]" value="Conducteur"
                                                <?= in_array('conducteur', $statuts) ? 'checked' : '' ?>>
                                            <label for="isDriver" class="form-check-label">Je suis conducteur</label>
                                        </div>
                                    </div>
                                </div>

                                <div id="vehicle-section" class="bg-light p-3 rounded mb-3" hidden>
                                    <h5>Véhicules enregistrés</h5>
                                    <div class="row">
                                        <div class="mb-3">
                                            <?php if (!empty($vehicles)): ?>
                                                <ul class="list-group mb-3">
                                                    <?php foreach ($vehicles as $vehicle): ?>
                                                        <li class="card mb-3">
                                                            <strong><?= htmlspecialchars($vehicle?->getBrand()) . " " . htmlspecialchars($vehicle?->getModel()) ?></strong> 
                                                            (<?= htmlspecialchars($vehicle?->getColor()) ?>)
                                                            <br><small>Immatriculation : <?= htmlspecialchars($vehicle?->getRegistration()) ?></small>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php else: ?>
                                                <p>Pas de véhicule enregistré</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <button type="button" class="btn" id="addVehicle">Ajouter un véhicule</button>

                                    <?php renderPartial('alert'); ?>

                                    <div class="d-none" id="addVehicleSection">
                                        <div class="col-md-6 mb-3">
                                            <label for="registration" class="form-label">Plaque d'immatriculation</label>
                                            <input class="input form-control" type="text" name="registration" id="registration" placeholder="XX-111-XX" value="" disabled>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="first_registration_date" class="form-label">Date de la première immatriculation</label>
                                            <input class="input form-control" type="date" name="first_registration_date" id="first_registration_date" placeholder="01/01/2020" value="" disabled>
                                        </div>
        
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label for="brand" class="form-label">Marque</label>
                                                <select class="form-select input" aria-label="select marque voiture" id="carBrand" name="brand" disabled>
                                                    <option value="">Sélectionner une marque</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="model" class="form-label">Modèle</label>
                                                <select class="form-select input" aria-label="select modele voiture" id="carModel" name="model" disabled>
                                                    <option value="">Sélectionner un modèle</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="color" class="form-label">Couleur</label>
                                                <select class="form-select input" aria-label="select couleur voiture" id="carColor" name="color" disabled>
                                                    <option value="">Sélectionnez une couleur</option>
                                                    <option value="blanc">Blanc</option>
                                                    <option value="noir">Noir</option>
                                                    <option value="gris">Gris</option>
                                                    <option value="bleu">Bleu</option>
                                                    <option value="rouge">Rouge</option>
                                                    <option value="vert">Vert</option>
                                                    <option value="jaune">Jaune</option>
                                                    <option value="orange">Orange</option>
                                                    <option value="marron">Marron</option>
                                                    <option value="violet">Violet</option>
                                                    <option value="rose">Rose</option>
                                                    <option value="beige">Beige</option>
                                                </select>
                                            </div>
                                        </div>
        
        
                                        <div class="mb-3">
                                            <label for="nb_place" class="form-label">Places disponibles</label>
                                            <select class="form-select input" aria-label="select places disponibles" id="nb_place" name="nb_place" required>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Véhicule électrique</label>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" id="electric_yes" name="energy" value="1" checked>
                                                <label for="electric_yes" class="form-check-label">Oui</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" id="electric_no" name="energy" value="0">
                                                <label for="electric_no" class="form-check-label">Non</label>
                                            </div>
                                        </div>
                            
                                        <h5 class="mb-3">Préférences</h5>
                                        <div class="mb-3">
                                            <label class="form-label">Fumeur</label>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" id="smoking_yes" name="smoking" value="1">
                                                <label for="smoking_yes" class="form-check-label">Oui</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" id="smoking_no" name="smoking" value="0" checked>
                                                <label for="smoking_no" class="form-check-label">Non</label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Animaux acceptés</label>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" id="pets_yes" name="pets" value="1">
                                                <label for="pets_yes" class="form-check-label">Oui</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" id="pets_no" name="pets" value="0" checked>
                                                <label for="pets_no" class="form-check-label">Non</label>
                                            </div>
                                        </div>
        
                                        <div class="mb-3">
                                            <label for="other_preferences" class="form-label">Autres préférences</label>
                                            <textarea name="other_preferences" class="form-control" rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center mt-4">
                                    <button class="btn d-flex justify-content-center" name="updateProfile" type="submit">Mettre à jour</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    
    <section class="conteneur page my-3">
        <div class="formulaire-title mx-auto mb-3">
            <h2>Mot de passe</h2>
        </div>
        <div class="formulaire-title m-auto">
            <a href="#">Modifier mon mot de passe</a>
        </div>
    </section>
    <section class="conteneur">
        <div class="formulaire-title mx-auto mb-3">
            <h2>Supprimer mon compte</h2>
        </div>
        <div class="formulaire-title m-auto">
            <p>La suppression de compte est définitive. Vos données personnelles ainsi que vos annonces seront supprimées.</p>
        </div>
        <button class="btn btn-danger d-flex justify-content-center" type="submit" data-bs-toggle="modal" data-bs-target="#suppressionModal">Supprimer mon compte</button>
    </section>
    <div style="height: 1rem;"></div>

    <!-- Modal add vehicle-->
    <div class="modal fade" id="addVehicleModal" tabindex="-1" aria-labelledby="addVehicleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content bg-secondary">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="addVehicleModalLabel">Ajouter un véhicule</h1>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="updateVehicle.php" method="post">
                    
                </form>
            </div>
        </div>
        </div>
    </div>
    </div>
    
    <!-- Modal suppression-->
    <div class="modal fade" id="suppressionModal" tabindex="-1" aria-labelledby="suppressionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content bg-secondary">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="suppressionModalLabel">Supprimer mon compte</h1>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container mt-3 text-center">
                    <p>Voulez-vous vraiment supprimer votre compte ?</p>
                    <div class="container d-flex justify-content-center">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-secondary">Confirmer la suppression</button>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</main>