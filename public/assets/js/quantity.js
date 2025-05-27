document.addEventListener("DOMContentLoaded", () => {
    initQuantitySelector(".btn-quantity-selector", ".passengerCount", "passengerCountInputHidden", 1, 4);
    initQuantitySelector(".quantity-credit-selector", ".creditCount", "creditInput", 1, 100);
});

function initQuantitySelector(selectorClass, inputClass, hiddenInputId, minValue, maxValue) {
    
    document.querySelectorAll(selectorClass).forEach(selector => {
        const input = selector.querySelector(inputClass);
        const decreaseBtn = selector.querySelector(".decrease");
        const increaseBtn = selector.querySelector(".increase");
        const hiddenInput = document.getElementById(hiddenInputId);

        const dynamicMin = selector.hasAttribute('data-min') ? parseInt(selector.getAttribute('data-min')) : minValue;
        const dynamicMax = selector.hasAttribute('data-max') ? parseInt(selector.getAttribute('data-max')) : maxValue;

        if (!input.value || isNaN(parseInt(input.value))) {
            input.value = dynamicMin;
            hiddenInput.value = dynamicMin;
        }

        const updateRecap = () =>{
            hiddenInput.value = input.value;
            hiddenInput.dispatchEvent(new Event('input'));
        }

        decreaseBtn.addEventListener("click", () => {
            let currentValue = parseInt(input.value);

            if (currentValue > dynamicMin) {
                input.value = currentValue - 1;
                updateRecap();
            }
        });

        increaseBtn.addEventListener("click", () => {
            let currentValue = parseInt(input.value);

            if (currentValue < dynamicMax) {
                input.value = currentValue + 1;
            } else {
                input.value = dynamicMax;
            }
            updateRecap();
        });
    });
}

document.addEventListener("DOMContentLoaded", () => {
    const selector = document.querySelector(".btn-quantity-selector");
    const input = selector.querySelector(".quantity-input");
    const decreaseBtn = selector.querySelector(".decrease");
    const increaseBtn = selector.querySelector(".increase");
    const hiddenPassengerCount = document.getElementById("passengerCountInputHidden");
    const pricePerson = document.getElementById("pricePerPerson");
    const totalPriceDisplay = document.getElementById("totalPrice");

    let minValue = 1;
    let maxValue = maxPassengers;

    const updateDisplay = () => {
        hiddenPassengerCount.value = input.value;
        const total = parseInt(input.value) * parseInt(pricePerson.value);
        totalPriceDisplay.textContent = total;
    };

    decreaseBtn.addEventListener('click', () => {
        let currentValue = parseInt(input.value);
        if (currentValue > minValue){
            input.value = currentValue -1;
            updateDisplay();
        }
    });

    increaseBtn.addEventListener("click", () => {
        let currentValue = parseInt(input.value);
        if (currentValue < maxValue){
            input.value = currentValue + 1;
            updateDisplay();
        }
    });

    updateDisplay();
});
