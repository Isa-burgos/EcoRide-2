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
                <label for="email"></label>
                <input class="input form-control" type="email" name="email" id="emailInput" placeholder="Email">
            </div>
            <div>
                <label for="password"></label>
                <input class="input password form-control" type="password" name="password" id="passwordInput" placeholder="Mot de passe">
            </div>

            <?php if(isset($error)):  ?>
                <div class="alert alert-danger" role="alert">
                    <?= $error ?>
                </div>
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