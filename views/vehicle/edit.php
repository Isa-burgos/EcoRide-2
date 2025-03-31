<?php

use App\Services\PreferenceService;

    $vehicle = $vehicle ?? null;

    if (!$vehicle) {
        echo "<p class='text-danger text-center mt-5'>Véhicule introuvable</p>";
        return;
    }

    $prefService = new PreferenceService();
    $preferences = $prefService->getPreferencesByVehicle($vehicle->getVehicleId()) ?? [];
?>

<main class="container mt-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow">
                    <h1 class="text-center">Modifier le véhicule</h1>
                
                    <form method="POST" action="/vehicle/<?= $vehicle->getVehicleId() ?>/update" class="mb-5 px-3">
                        <div class="mb-3">
                            <label for="registration" class="form-label">Immatriculation</label>
                            <input type="text" name="registration" id="registration" class="form-control"
                                    value="<?= htmlspecialchars($vehicle->getRegistration()) ?>" required>
                        </div>
                
                        <div class="mb-3">
                            <label for="first_registration_date" class="form-label">Date de 1ère immatriculation</label>
                            <input type="date" name="first_registration_date" id="first_registration_date" class="form-control"
                                    value="<?= htmlspecialchars(substr($vehicle->getFirstRegistrationDate(), 0, 10)) ?>" required>
                        </div>
                
                        <div class="mb-3">
                            <label for="brand" class="form-label">Marque</label>
                            <select class="form-select input" aria-label="select marque voiture" id="carBrand" name="brand">
                                <option value="<?= htmlspecialchars($vehicle->getBrand()) ?>" required><?= htmlspecialchars($vehicle->getBrand()) ?></option>
                            </select>
                        </div>
                
                        <div class="mb-3">
                            <label for="model" class="form-label">Modèle</label>
                            <select class="form-select input" aria-label="select modele voiture" id="carModel" name="model">
                                <option value="<?= htmlspecialchars($vehicle->getModel()) ?>" required><?= htmlspecialchars($vehicle->getModel()) ?></option>
                            </select>
                        </div>
                
                        <div class="mb-3">
                            <label for="color" class="form-label">Couleur</label>
                            <select class="form-select input" aria-label="select couleur voiture" id="carColor" name="color">
                                <option value="<?= htmlspecialchars($vehicle->getColor()) ?>" required><?= htmlspecialchars($vehicle->getColor()) ?></option>
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
                
                        <div class="mb-3">
                            <label class="form-label">Véhicule électrique</label>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="electric_yes" name="energy" value="1"
                                    <?= $vehicle->getEnergy() == 1 ? 'checked' : '' ?>>
                                <label for="electric_yes" class="form-check-label">Oui</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="electric_no" name="energy" value="0"
                                    <?= $vehicle->getEnergy() == 0 ? 'checked' : '' ?>>
                                <label for="electric_no" class="form-check-label">Non</label>
                            </div>
                        </div>

                        <h5 class="mb-3">Préférences</h5>
                                <div class="mb-3">
                                    <label class="form-label">Fumeur</label>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" id="smoking_yes" name="smoking" value="1" <?= !empty($preferences['smoking']) ? 'checked' : '' ?>>
                                        <label for="smoking_yes" class="form-check-label">Oui</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" id="smoking_no" name="smoking" value="0" <?= isset($preferences['smoking']) && !$preferences['smoking'] ? 'checked' : '' ?>>
                                        <label for="smoking_no" class="form-check-label">Non</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Animaux acceptés</label>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" id="pets_yes" name="pets" value="1" <?= !empty($preferences['pets']) ? 'checked' : '' ?>>
                                        <label for="pets_yes" class="form-check-label">Oui</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" id="pets_no" name="pets" value="0" <?= isset($preferences['pets']) && !$preferences['pets'] ? 'checked' : '' ?>>
                                        <label for="pets_no" class="form-check-label">Non</label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="custom_preferences" class="form-label">Autres préférences</label>
                                    <textarea name="custom_preferences" class="form-control" rows="2"><?= htmlspecialchars($preferences['custom']) ?? '' ?></textarea>
                                </div>
                
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
