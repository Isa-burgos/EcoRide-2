<section class="container">
    <h2>Modifier les informations d'un employé</h2>

    <div class="container">
        <?php renderPartial('alert') ?>
    </div>

    <?php if($employe->getUserId()): ?>
    <form action="/admin/employes/<?= $employe->getUserId() ?>/update" method="post">
    <?php endif ?>
        <div class="container row g-3">
            <div class="col-md-6">
                <label for="name" class="form-label">Nom</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Nom" value="<?= htmlspecialchars($employe->getName()) ?>" required>
            </div>
            <div class="col-md-6">
                <label for="firstname" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Prénom" value="<?= htmlspecialchars($employe->getFirstname()) ?>" required>
            </div>
            <div class="col-md-12">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($employe->getEmail()) ?>" required>
            </div>
            <div class="col-12">
                <label for="adress" class="form-label">Adresse</label>
                <input type="text" class="form-control" id="adress" name="adress" value="<?= htmlspecialchars($employe->getAdress()) ?>" required>
            </div>
            <div class="col-12">
                <label for="phone" class="form-label">Téléphone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($employe->getPhone()) ?>" required>
            </div>
            <div>
                <a href="/admin/employes" class="btn btn-primary">Retour</a>
                <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
            </div>
        </div>
    </form>
</section>