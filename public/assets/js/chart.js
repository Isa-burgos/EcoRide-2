const ridesLabels = ridesData.map(item => item.date);
const ridesCounts = ridesData.map(item => item.count);

const creditsLabels = creditsData.map(item => item.date);
const creditsTotals = creditsData.map(item => item.total);

const ridesCtx = document.getElementById('ridesChart').getContext('2d');
new Chart(ridesCtx, {
    type: 'line',
    data: {
        labels: ridesLabels,
        datasets: [{
            label: 'Covoiturages par jour',
            data: ridesCounts,
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
        }]
    }
});

const creditsCtx = document.getElementById('creditsChart').getContext('2d');
new Chart(creditsCtx, {
    type: 'bar',
    data: {
        labels: creditsLabels,
        datasets: [{
            label: 'Crédits gagnés par la plateforme par jour',
            data: creditsTotals,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
        }]
    }
});
