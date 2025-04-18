<main>
    <section class="big-hero text-center">
        <div class="big-hero-content">
            <h1>Covoiturages</h1>
        </div>
    </section>
    
    <section class="conteneur">
        <form class="conteneur-content py-3" method="GET" action="/carshare/search">
            <div class="champ gx-1">
                <input class="startAdress form-control input" type="text" id="departAdress" name="depart_adress" placeholder="Adresse de départ">
            </div>
            <div class="champ gx-1">
                <input class="endAdress form-control input" type="text" id="arrivalAdress" name="arrival_adress" placeholder="Adresse d'arrivée">
            </div>
            <div class="champ gx-1">
                <input class="date-depart form-control input" type="date" name="depart_date" placeholder="Date de départ">
            </div>
            <div class="champ gx-1">
                <input class="passenger form-control input" type="number" name="nb_place" placeholder="Passager">
            </div>
    
                <button type="submit" class="btn d-flex justify-content-center">Lancer ma recherche</button>
    
        </form>
    </section>
</main>