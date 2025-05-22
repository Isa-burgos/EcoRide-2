<h1 class="text-dark mb-5">Dashboard administrateur</h1>

<section>
    <div class="container">
        <div class="mb-5">
            <h2 class="text-dark mb-5">Covoiturages par jour</h2>
            <canvas id="ridesChart" width="400" height="200"></canvas>
        </div>
    
        <div>
            <h2 class="text-dark">Revenus de la plateforme par jour</h2>
            <canvas id="creditsChart" width="400" height="200"></canvas>
        </div>
    </div>
</section>

<script>
    const ridesData = <?= json_encode($ridesPerDay) ?>;
    const creditsData = <?= json_encode($creditsPerDay) ?>;
</script>