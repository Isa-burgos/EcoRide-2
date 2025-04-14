const formatDate = (dateStr) => {
    if(!dateStr) return '--';
    const [year, month, day] = dateStr.split('-');
    return `${day}/${month}/${year}`;
}

const formatTime = (timeStr) => {
    if(!timeStr) return '--';
    const [hour, minute] = timeStr.split(':');
    return `${hour}h${minute}`;
}

document.addEventListener("DOMContentLoaded", () => {
    const bindRecap = (inputId, recapId, isClass = false, formatter = null) => {
        const input = isClass ? document.querySelector(inputId) : document.getElementById(inputId);
        const recap = document.getElementById(recapId);
        if(input && recap){
            const update = () => {
                const value = input.value || '--';
                recap.textContent = formatter ? formatter(value) : value;
            };
            input.addEventListener('input', update);
            update();
        }
    };

    bindRecap("depart_adress", "recap_depart_adress");
    bindRecap("arrival_adress", "recap_arrival_adress");
    bindRecap("depart_date", "recap_depart_date", false, formatDate);
    bindRecap("depart_time", "recap_depart_time", false, formatTime);
    bindRecap("creditInput", "recap_price");

    const vehicleRadios = document.querySelectorAll('input[name="used_vehicle');
    vehicleRadios.forEach(radio => {
        radio.addEventListener('change', () => {
            if(radio.checked){
                document.getElementById("recap_vehicle").textContent = radio.dataset.label || '--';
                document.getElementById("recap_place").textContent = radio.dataset.place || '--';
                document.getElementById("recap_smoking").textContent = radio.dataset.smoking === 1 ? 'oui' : 'non';
                document.getElementById("recap_pets").textContent = radio.dataset.pets === 1 ? 'oui' : 'non';
                document.getElementById("recap_custom").textContent = radio.dataset.custom || 'Pas d\'autres commentaires enregistrés';
            }
        });
    });
});