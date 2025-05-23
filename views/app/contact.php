<main>
    <section class="big-hero text-center">
        <div class="big-hero-content">
            <h1>Nous contacter</h1>
        </div>
    </section>
    
    <section class="conteneur">
        <form class="form conteneur-content" id="contactForm" novalidate action="">
            <div>
                <label for="emailContactInput"></label>
                <input class="text form-control" type="email" id="emailContactInput" placeholder="Email">
                <div class="invalid-feedback">
                    Veuillez entrer un e-mail valide
                </div>
            </div>
            <div>
                <label for="subjectContactInput"></label>
                <input class="text form-control" type="text" id="subjectContactInput" placeholder="Sujet">
                <div class="invalid-feedback">
                    Veuillez entrer un sujet
                </div>
            </div>
            <div>
                <label for="messageContactInput"></label>
                <textarea class="text form-control" placeholder="Votre message" id="messageContactInput" rows="5" cols="33"></textarea>
                <div class="invalid-feedback">
                    Votre message doit comporter au moins 20 caractères
                </div>
            </div>
    
                <button class="btn d-flex justify-content-center" type="submit" id="btn-send">Envoyer</button>
    
        </form>
    </section>
</main>