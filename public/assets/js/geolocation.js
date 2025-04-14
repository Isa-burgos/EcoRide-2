// Géolocalisation
const apiKey = "5b3ce3597851110001cf624894e6d5ed94c843baa9d0888a16c6e6a7";

async function getAdressFromCoordinates(latitude, longitude) {
    const url = `https://api.openrouteservice.org/geocode/reverse?api_key=${apiKey}&point.lat=${latitude}&point.lon=${longitude}&size=1`;

    try{
        const response = await fetch(url);
        const data = await response.json();

        if(data.features.length > 0){
            return data.features[0].properties.label;
        } else{
            console.error("Adresse introuvable");
            return null;
        }
    } catch(error){
        console.error("Erreur de géocodage inversé :", error);
        return null;
    }
}

async function getGeolocation(inputField) {
    if(!navigator.geolocation){
        alert("La géolocalisation n'est pas supportée par votre navigateur");
        return;
    }

    navigator.geolocation.getCurrentPosition(
        async (position) =>{
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;

            const adress = await getAdressFromCoordinates(latitude, longitude);

            if(adress){
                inputField.value = adress;
                inputField.dispatchEvent(new Event('input', {bubbles: true}));
            }
        },
        (error)=>{
            console.error("Erreur de géolocalisation", error);
            alert("Impossible d'obtenir votre position")
            
        }
    );
}

document.getElementById("geolocDepart").addEventListener("click", ()=>{
    getGeolocation(document.getElementById("depart_adress"));
});

document.getElementById("geolocArrival").addEventListener("click", ()=>{
    getGeolocation(document.getElementById("arrival_adress"));
})

// Autocomplétion
let debounceTimer = null;

async function getAdressSuggestions(query, inputElement) {
    if(query.length < 3) return;

    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(async() =>{
        const url = `https://api.openrouteservice.org/geocode/search?api_key=${apiKey}&text=${encodeURIComponent(query)}&boundary.country=FR&size=5`;

        try{
            const response = await fetch(url);
            const data = await response.json();
        
            const container = inputElement.closest('.input-container').querySelector('.suggestions-container');
            container.innerHTML = "";
            container.style.display = "block";
        
            if (!data.features || data.features.length === 0) {
                container.style.display = "none";
                console.warn("Aucun résultat trouvé !");
                return;
            }
        
            data.features.forEach(place =>{
                let div = document.createElement("div");
                div.classList.add("suggestion-item");
                div.textContent = place.properties.label;
                div.addEventListener("click", () =>{
                    inputElement.value = place.properties.label;
                    container.innerHTML = "";
                    container.style.display = "none";
                    getSelectedAdress();
                })
                container.appendChild(div);
            });
            }catch (error) {
                console.error("Erreur lors de la récupération des adresses :", error);
            }
        }, 300);
    }

    document.querySelectorAll(".input-container .input").forEach(input => {
        input.addEventListener("input", (e) => {
            getAdressSuggestions(e.target.value, e.target);
        });
    });

document.addEventListener("click", (e) => {
    if (!e.target.closest(".input-container")) {
        document.querySelectorAll(".suggestions-container").forEach(container => {
            container.style.display = "none";
        });
    }
});


function getSelectedAdress(){
    const departAdress = document.getElementById("depart_adress");
    const arrivalAdress = document.getElementById("arrival_adress");
    const selectedAdressDepart = document.getElementById("selectedAdressDepart");
    const selectedAdressArrival = document.getElementById("selectedAdressArrival");

    if(departAdress.value.trim() !==""){
        selectedAdressDepart.textContent = departAdress.value;
    } else{
        selectedAdressDepart.textContent = "Aucune adresse sélectionnée";
    }
    if(arrivalAdress.value.trim() !==""){
        selectedAdressArrival.textContent = arrivalAdress.value;
    } else{
        selectedAdressArrival.textContent = "Aucune adresse sélectionnée";
    }
}

document.getElementById("depart_adress").addEventListener("input", getSelectedAdress);
document.getElementById("arrival_adress").addEventListener("input", getSelectedAdress);

// Distance entre 2 points
async function getCoordinates(query) {
    try{
        const url = `https://api.openrouteservice.org/geocode/search?api_key=${apiKey}&text=${encodeURIComponent(query)}&boundary.country=FR&size=1`;
        const response = await fetch(url);
        const data = await response.json();

        if(data.features && data.features.length > 0){
            return{
                lon: data.features[0].geometry.coordinates[0],
                lat: data.features[0].geometry.coordinates[1]
            };
        }else {
            console.error("Aucune coordonnée trouvée pour cette adresse :", query);
            return null;
        }
    } catch (error){
        console.error("Erreur lors de la récupération des coordonnées :", error);
        return null;
    }
}

async function getDistance(depart, arrivee) {
    
    try {
        const url = "https://api.openrouteservice.org/v2/directions/driving-car";
        const response = await fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Authorization": apiKey
            },
            body: JSON.stringify({
                coordinates: [
                    [depart.lon, depart.lat], 
                    [arrivee.lon, arrivee.lat]
                ]
            })
        });

        const data = await response.json();
        if (data.routes && data.routes.length > 0) {
            const distanceKm = data.routes[0].summary.distance / 1000;
            const durationSec = data.routes[0].summary.duration;

            return {distanceKm, durationSec};
        } else {
            console.error("Impossible de récupérer la distance et la durée.");
            return null;
        }
    } catch (error) {
        console.error("Erreur de calcul de distance :", error);
        return null;
    }
}

document.addEventListener("DOMContentLoaded", async () => {
    const departInput = document.getElementById("depart_adress");
    const arriveeInput = document.getElementById("arrival_adress");
    const distanceSpan = document.getElementById("tripDistance");

    async function updateDistance() {
        if (departInput.value.trim() && arriveeInput.value.trim()) {
            const depart = await getCoordinates(departInput.value);
            const arrivee = await getCoordinates(arriveeInput.value);

            if (depart && arrivee) {
                const routeData = await getDistance(depart, arrivee);
                if (routeData) {
                    distanceSpan.textContent = `${routeData.distanceKm.toFixed(1)} km`;
                }
            }
        }
    }

    departInput.addEventListener("change", updateDistance);
    arriveeInput.addEventListener("change", updateDistance);
});

// Affichage de la carte dans le modal
document.addEventListener('DOMContentLoaded', () =>{
    let map;
    let routeLayer;

    document.getElementById("mapModal").addEventListener("shown.bs.modal", async () =>{
        if(!map){
            map = L.map("map").setView([46.603354, 1.888334], 6);

            L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                attribution: '<a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
            
        }
        await displayRoute();
    });

    async function displayRoute() {
        if (routeLayer) {
            map.removeLayer(routeLayer);
        }

        const depart = await getCoordinates(document.getElementById("depart_adress").value);
        const arrivee = await getCoordinates(document.getElementById("arrival_adress").value);

        if (!depart || !arrivee) {
            alert("Veuillez entrer des adresses valides !");
            return;
        }

        try {
            const apiUrl = "https://api.openrouteservice.org/v2/directions/driving-car/geojson";
            const body = {
                coordinates: [[depart.lon, depart.lat], [arrivee.lon, arrivee.lat]]
            };

            const response = await fetch(apiUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": apiKey
                },
                body: JSON.stringify(body)
            });

            const data = await response.json();

            if (!data.features || data.features.length < 1) {
                alert("Impossible de récupérer l'itinéraire !");
                return;
            }

            const route = data.features[0];

            routeLayer = L.geoJSON(route.geometry, { style: { color: "blue", weight: 4 } }).addTo(map);
            map.fitBounds(routeLayer.getBounds());

            const distance = (route.properties.summary.distance / 1000).toFixed(1);
            const duration = Math.round(route.properties.summary.duration / 60);

            document.getElementById("tripDistance").textContent = `${distance} km`;
            document.getElementById("tripDistanceModal").textContent = `${distance} km`;
            document.getElementById("tripDistanceRecap").textContent = `${distance} km`;
            document.getElementById("tripDurationModal").textContent = `${duration} min`;
            document.getElementById("tripDurationRecap").textContent = `${duration} min`;

        } catch (error) {
            console.error("Erreur lors du chargement de l'itinéraire", error);
        }
    }
});


// Calcul de l'heure d'arrivée
document.addEventListener("DOMContentLoaded", () =>{
    const hourSelect = document.getElementById("hour");
    const minuteSelect = document.getElementById("minute");
    const hiddenDepartInput = document.getElementById("depart_time");
    const hiddenArrivalInput = document.getElementById("arrival_time");
    const departInput = document.getElementById("depart_adress");
    const arrivalInput = document.getElementById("arrival_adress");

    function updateDepartTime(){
        const hour = String(hourSelect.value).padStart(2, "0");
        const minute = String(minuteSelect.value).padStart(2, "0");
        hiddenDepartInput.value = `${hour}:${minute}:00`;
    }

    async function updateArrivalTime() {

        try {
            const depart = await getCoordinates(departInput.value);
            const arrivee = await getCoordinates(arrivalInput.value);
            const routeData = await getDistance(depart, arrivee);
            const durationMin = Math.round(routeData.durationSec / 60);

            const departTime = hiddenDepartInput.value.split(":");
            let arrivalHour = parseInt(departTime[0], 10);
            let arrivalMinute = parseInt(departTime[1], 10);

            arrivalMinute += durationMin;
            arrivalHour += Math.floor(arrivalMinute / 60);
            arrivalMinute %= 60;
            arrivalHour %= 24;

            hiddenArrivalInput.value = `${String(arrivalHour).padStart(2, "0")}:${String(arrivalMinute).padStart(2, "0")}:00`;
        } catch (error) {
            console.error("Erreur lors du calcul de l'heure d'arrivée :", error);
        }
    }

    hourSelect.addEventListener("change", () => {
        updateDepartTime();
        updateArrivalTime();
    });

    minuteSelect.addEventListener("change", () => {
        updateDepartTime();
        updateArrivalTime();
    });

    departInput.addEventListener("change", updateArrivalTime);
    arrivalInput.addEventListener("change", updateArrivalTime);

    updateDepartTime();
    updateArrivalTime();
});