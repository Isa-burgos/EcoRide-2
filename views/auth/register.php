<main>
    <section class="big-hero text-center">
        <div class="big-hero-content">
            <h1>Créer un compte</h1>
            <p>Vous avez déjà un compte? <a href="/login">Identifiez-vous</a></p>
    </section>
    
    <section class="conteneur">
    <?php if (!empty($_SESSION['errors'])): ?>
        <?php foreach ($_SESSION['errors'] as $field => $error): ?>
            <?php if (is_array($error)): ?>
                <?php foreach ($error as $message): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
        <?php endforeach; ?>
        <?php unset($_SESSION['errors']);?>
    <?php endif; ?>

        <form class="conteneur-content" method="post" action="register">
            <div class="d-flex pt-2">
                <div class="me-2">
                    <input type="radio" name="gender" value="homme" checked>
                    <label for="gender">Homme</label>
                </div>
                <div>
                    <input type="radio" name="gender" value="femme">
                    <label for="gender">Femme</label>
                </div>
            </div>
            <div>
                <input class="input form-control" name="name" id="nameInput" type="text" placeholder="Nom" required value="<?= isset($_SESSION['old']['name']) ? htmlspecialchars($_SESSION['old']['name']) : '' ?>">
                <?php if(!empty($_SESSION['errors']['name'])) : ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($_SESSION['errors']['name']) ?>
                </div>
                <?php endif ?>
            </div>
            <div>
                <label for="firstnameInput"></label>
                <input class="input form-control" name="firstname" type="text" id="firstnameInput" placeholder="Prénom" required value="<?= isset($_SESSION['old']['firstname']) ? htmlspecialchars($_SESSION['old']['firstname']) : '' ?>">
                <?php if(!empty($_SESSION['errors']['firstname'])) : ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($_SESSION['errors']['firstname']) ?>
                    </div>
                <?php endif ?>
            </div>
            <div>
                <label for="birth_date">Date de naissance</label>
                <input type="date" class="form-control input" aria-label="select annee de naissance" name="birth_date" required value="<?= htmlspecialchars($_POST['birth_date'] ?? '') ?>">
                <?php if(!empty($_SESSION['errors']['birth_date'])) : ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($_SESSION['errors']['birth-date']) ?>
                    </div>
                <?php endif ?>
            <div>
                <label for="emailInput"></label>
                <input class="input form-control" type="email" name="email" id="emailInput" placeholder="Email" value="<?= isset($_SESSION['old']['email']) ? htmlspecialchars($_SESSION['old']['email']) : '' ?>" required>
                <?php if(!empty($_SESSION['errors']['email'])) : ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($_SESSION['errors']['email']) ?>
                    </div>
                <?php endif ?>
            </div>
            <div>
                <label for="passwordInput"></label>
                <input class="input form-control password" type="password" name="password" id="passwordInput" placeholder="Mot de passe" required>
                <?php if(!empty($_SESSION['errors']['password'])) : ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($_SESSION['errors']['password']) ?>
                    </div>
                <?php endif ?>
            </div>
            <div>
                <label for="passwordValidateInput"></label>
                <input class="input form-control password" type="password" name="passwordValidate" id="passwordValidateInput" placeholder="Confirmer le mot de passe" value="">
                <?php if(!empty($_SESSION['errors']['passwordValidate'])) : ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($_SESSION['errors']['passwordValidate']) ?>
                    </div>
                <?php endif ?>
            </div>

            
            <div>
                <input class="checkbox" type="checkbox" required>
                <label for="">En cliquant sur “Valider”, vous acceptez les conditions générales d’utilisation et certifiez avoir plus de 18 ans</label>
            </div>
            <input class="btn d-flex justify-content-center" type="submit" value="Inscription" name="registration" id="btn-validation-inscription">
        </form>
    </section>
</main>
<?php unset($_SESSION['errors']); ?>