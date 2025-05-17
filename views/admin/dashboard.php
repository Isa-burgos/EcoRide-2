<h1 class="text-dark">Dashboard administrateur</h1>

<div class="container">
    <h2>Covoiturages par jour</h2>
    <canvas id="ridesChart" width="400" height="200"></canvas>

    <h2>Revenus de la plateforme par jour</h2>
    <canvas id="creditsChart" width="400" height="200"></canvas>
</div>

<script>
    const ridesData = <?= json_encode($ridesPerDay) ?>;
    const creditsData = <?= json_encode($creditsPerDay) ?>;

    console.log("✅ ridesData =", ridesData);
    console.log("✅ creditsData =", creditsData);
</script>