<main>
    <section class="big-hero text-center">
        <div class="big-hero-content">
            <h1>Se connecter</h1>
            <p>Vous n’avez pas de compte? <a href="/register">Créez un compte</a></p>
        </div>
    </section>

    <section class="conteneur">
        <form class="conteneur-content" method="post" action="/login">
            <div>
                <input class="input form-control" type="email" name="email" id="emailInput" placeholder="Email" required>
                <?php if(!empty($_SESSION['errors']['email'])): ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($_SESSION['errors']['email'][0]) ?>
                    </div>
                <?php endif; ?>
            </div>
            <div>
                <input class="input password form-control" type="password" name="password" id="passwordInput" placeholder="Mot de passe" required>
                    <?php if(!empty($_SESSION['errors']['password'])): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($_SESSION['errors']['password'][0]) ?>
                        </div>
                    <?php endif; ?>
            </div>

            <?php unset($_SESSION['errors']); ?>

            <?php if(!empty($_SESSION['error'])) : ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($_SESSION['error']) ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif ?>

            <div>
                <input class="checkbox" type="checkbox">
                <label for="">Rester connecté</label>
            </div>
            <div class="text-end">
                <a href="#">J’ai oublié mon mot de passe</a>
            </div>

                <input class="btn d-flex justify-content-center" name="btnLogin" id="btnLogin" type="submit" value="Connexion">

        </form>
    </section>
</main>