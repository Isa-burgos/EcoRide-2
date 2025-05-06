<?php
    $statuts = $statuts ?? [];
    $vehicles = $vehicles ?? [];
    $user = $user ?? null;

    $birthDate = ($user && method_exists($user, 'getBirthDate')) ? substr($user->getBirthDate(), 0, 10) : '';
    $photo = ($user && method_exists($user, 'getPhoto')) ? '/' . htmlspecialchars($user->getPhoto()) : '/public/assets/img/default-profile.svg';

?>
<main>
    <section class="big-hero text-center">
        <div class="big-hero-content">
            <h1>Mon compte</h1>
        </div>
    </section>

    <section>
        <!-- Formulaire de mise à jour -->
        <div class="container mt-5 mb-5">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card shadow">
                        <div class="card-header bg-dark text-light text-center">
                            <h4>Modifier mon compte</h4>
                            <?php renderPartial('alert'); ?>
                        </div>
                        <div class="card-body bg-white text-black">
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
                                            <label for="homme" class="text-dark">Homme</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" id="femme" name="gender" value="femme"<?= ($user?->getGender() ?? '') === 'femme' ? 'checked' : '' ?>>
                                            <label for="femme" class="text-dark">Femme</label>
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
                                    <input class="input form-control" type="tel" name="phone" id="phone" placeholder="0606060606" value="<?= htmlspecialchars($user?->getPhone() ?? '')?>">
                                </div>
                                <div class="mb-3">
                                    <label for="birth_date" class="form-label">Date de naissance</label>
                                    <input type="date" class="input form-control" name="birth_date" value="<?= htmlspecialchars($birthDate)?>">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input class="input form-control" type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($user?->getEmail() ?? '')?>">
                                </div>

                                <hr>

                                <h5 class="mb-3">Je suis</h5>
                                <div class="mb-3">
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="checkbox form-check-input" type="checkbox" id="isPassenger" name="statuts[]" value="Passager"
                                                <?= in_array('passager', $statuts) ? 'checked' : '' ?>>
                                            <label for="isPassenger" class="form-check-label text-dark">Je suis passager</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input checkbox-driver" type="checkbox" id="isDriver" name="statuts[]" value="Conducteur"
                                                <?= in_array('conducteur', $statuts) ? 'checked' : '' ?>>
                                            <label for="isDriver" class="form-check-label text-dark">Je suis conducteur</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center mt-4">
                                    <button class="btn d-flex justify-content-center" type="submit">Mettre à jour</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Véhicules enregistrés -->

    <section class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow">
                    <div id="vehicle-section" class="bg-light p-3 rounded mb-3" hidden>
                        <div class="card-header bg-dark text-light text-center mb-3">
                            <h4 >Véhicules enregistrés</h4>
                            <?php renderPartial('alert'); ?>
                            </div>
                        <div class="row">
                            <div class="mb-3">
                                <?php if (!empty($vehicles)): ?>
                                    <ul class="list-group mb-3">
                                        <?php foreach ($vehicles as $vehicle): ?>
                                            <li class="card mb-3 bg-dark">
                                                <?php renderPartial('alert'); ?>
                                                <?php renderPartial('success'); ?>
                                                <div class="card-body">
                                                    <?php renderPartial('alert'); ?>
                                                    <strong><?= htmlspecialchars($vehicle?->getBrand()) . " " . htmlspecialchars($vehicle?->getModel()) ?></strong> 
                                                    (<?= htmlspecialchars($vehicle?->getColor()) ?>)
                                                    <br><small>Immatriculation : <?= htmlspecialchars($vehicle?->getRegistration()) ?></small>
                                                    <?php if($vehicle->getNbPlace()): ?>
                                                        <br><?= $vehicle?->getNbPlace() . " place" . ($vehicle->getNbPlace() > 1 ? 's' : "") ?> disponible<?= $vehicle->getNbPlace() > 1 ? 's' : "" ?>
                                                    <?php endif ?>
                                                </div>
                                                <?php
                                                    $prefService = new \App\Services\PreferenceService();
                                                    $preferences = $prefService->getPreferencesByVehicle($vehicle->getVehicleId());
                                                ?>
                                                <div class="mt-2 px-2">
                                                    <?php if (!empty($preferences)): ?>
                                                        <ul class="list-unstyled">
                                                            <?php if (isset($preferences['smoking'])): ?>
                                                                <li>Fumeur : <?= $preferences['smoking'] ? 'oui' : 'non' ?></li>
                                                            <?php endif; ?>
                                                            <?php if (isset($preferences['pets'])): ?>
                                                                <li>Animaux acceptés : <?= $preferences['pets'] ? 'oui' : 'non' ?></li>
                                                            <?php endif; ?>
                                                            <?php if (!empty($preferences['custom'])): ?>
                                                                <li><em><?= htmlspecialchars($preferences['custom']) ?></em></li>
                                                            <?php endif; ?>
                                                        </ul>
                                                    <?php else: ?>
                                                        <p><em>Aucune préférence enregistrée</em></p>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="card-footer text-end bg-light">
                                                    <a href="/vehicle/<?= $vehicle->getVehicleId() ?>/edit" class="mx-2" title="Modifier le véhicule">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5 20H19C19.2652 20 19.5196 20.1054 19.7071 20.2929C19.8946 20.4804 20 20.7348 20 21C20 21.2652 19.8946 21.5196 19.7071 21.7071C19.5196 21.8946 19.2652 22 19 22H5C4.73478 22 4.48043 21.8946 4.29289 21.7071C4.10536 21.5196 4 21.2652 4 21C4 20.7348 4.10536 20.4804 4.29289 20.2929C4.48043 20.1054 4.73478 20 5 20ZM4 15L14 5L17 8L7 18H4V15ZM15 4L17 2L20 5L17.999 7.001L15 4Z" fill="#A3A847"/>
                                                    </svg>
                                                    </a>
                                                    <form method="POST" action="/vehicle/<?= $vehicle->getVehicleId() ?>/delete" style="display:inline;">
                                                        <button type="submit" class="bg-transparent border-0 mx-2" title="Supprimer le véhicule" onclick="return confirm('Supprimer ce véhicule ?')">
                                                        <svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M12.241 1.721L12.534 3.75H16.5C16.6989 3.75 16.8897 3.82902 17.0303 3.96967C17.171 4.11032 17.25 4.30109 17.25 4.5C17.25 4.69891 17.171 4.88968 17.0303 5.03033C16.8897 5.17098 16.6989 5.25 16.5 5.25H15.731L14.858 15.435C14.805 16.055 14.762 16.565 14.693 16.977C14.623 17.406 14.516 17.79 14.307 18.146C13.9788 18.7051 13.4909 19.1533 12.906 19.433C12.534 19.61 12.142 19.683 11.708 19.717C11.291 19.75 10.78 19.75 10.158 19.75H7.842C7.22 19.75 6.709 19.75 6.292 19.717C5.858 19.683 5.466 19.61 5.094 19.433C4.50908 19.1533 4.02118 18.7051 3.693 18.146C3.483 17.79 3.378 17.406 3.307 16.977C3.238 16.564 3.195 16.055 3.142 15.435L2.269 5.25H1.5C1.30109 5.25 1.11032 5.17098 0.96967 5.03033C0.829018 4.88968 0.75 4.69891 0.75 4.5C0.75 4.30109 0.829018 4.11032 0.96967 3.96967C1.11032 3.82902 1.30109 3.75 1.5 3.75H5.466L5.759 1.721L5.77 1.66C5.952 0.87 6.63 0.25 7.48 0.25H10.52C11.37 0.25 12.048 0.87 12.23 1.66L12.241 1.721ZM6.981 3.75H11.018L10.762 1.974C10.714 1.807 10.592 1.75 10.519 1.75H7.481C7.408 1.75 7.286 1.807 7.238 1.974L6.981 3.75ZM8.25 8.5C8.25 8.30109 8.17098 8.11032 8.03033 7.96967C7.88968 7.82902 7.69891 7.75 7.5 7.75C7.30109 7.75 7.11032 7.82902 6.96967 7.96967C6.82902 8.11032 6.75 8.30109 6.75 8.5V13.5C6.75 13.6989 6.82902 13.8897 6.96967 14.0303C7.11032 14.171 7.30109 14.25 7.5 14.25C7.69891 14.25 7.88968 14.171 8.03033 14.0303C8.17098 13.8897 8.25 13.6989 8.25 13.5V8.5ZM11.25 8.5C11.25 8.30109 11.171 8.11032 11.0303 7.96967C10.8897 7.82902 10.6989 7.75 10.5 7.75C10.3011 7.75 10.1103 7.82902 9.96967 7.96967C9.82902 8.11032 9.75 8.30109 9.75 8.5V13.5C9.75 13.6989 9.82902 13.8897 9.96967 14.0303C10.1103 14.171 10.3011 14.25 10.5 14.25C10.6989 14.25 10.8897 14.171 11.0303 14.0303C11.171 13.8897 11.25 13.6989 11.25 13.5V8.5Z" fill="#BC2E0A"/>
                                                        </svg>
                                                        </button>
                                                    </form>
                                                </div>
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

                        <!-- Ajouter un véhicule -->
                        
                        <div class="d-none" id="addVehicleSection">
                            <form method="POST" action="/vehicle/create" class="bg-white p-2">
                                <div class="col-md-6 mb-3">
                                    <label for="registration" class="form-label">Plaque d'immatriculation</label>
                                    <input class="form-control" type="text" name="registration" id="registration" placeholder="XX-111-XX" value="" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="first_registration_date" class="form-label">Date de la première immatriculation</label>
                                    <input class="form-control" type="date" name="first_registration_date" id="first_registration_date" placeholder="01/01/2020" value="" required>
                                </div>

                                <div class="row">
                                    <div class=" mb-3">
                                        <label for="brand" class="form-label">Marque</label>
                                        <select class="form-select" aria-label="select marque voiture" id="carBrand" name="brand" required>
                                            <option value="">Sélectionner une marque</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="model" class="form-label">Modèle</label>
                                        <select class="form-select" aria-label="select modele voiture" id="carModel" name="model" required>
                                            <option value="">Sélectionner un modèle</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="color" class="form-label">Couleur</label>
                                        <select class="form-select" aria-label="select couleur voiture" id="carColor" name="color" required>
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
                                    <div>
                                        <label for="nb_place">Places disponibles</label>
                                        <select class="form-select" aria-label="select places disponibles" id="nb_place" name="nb_place" required>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                        </select>
                                    </div>
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

                                <h5 class="mb-3 text-dark">Préférences</h5>
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
                                    <textarea name="custom_preferences" class="form-control" rows="2"></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary">Ajouter le véhicule</button>
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