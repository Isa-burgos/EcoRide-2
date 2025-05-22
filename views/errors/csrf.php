<main>
    <section class="big-hero text-center">
        <div class="big-hero-content">
            <h1>Echec de vérification CSRF</h1>
        </div>
    </section>
    
    <section class="conteneur my-5">
        <div class="conteneur-content">
            <h2>Échec de vérification CSRF</h2>
            <p>Par mesure de sécurité, l'envoi de ce formulaire a été bloqué.<br>
                Cela peut arriver si votre session a expiré ou si vous avez ouvert ce formulaire depuis un site externe.</p>
            <a href="<?= $_SERVER['HTTP_REFERER'] ?? '/' ?>">Retour à la page précédente</a>
        </div>
    </section>

</main>
