document.addEventListener("DOMContentLoaded", () => {
    initQuantitySelector(".quantity-selector", ".passengerCount", "nbPlaceInput", 1, 4);
    initQuantitySelector(".quantity-credit-selector", ".creditCount", "creditInput", 1, 100);
});

function initQuantitySelector(selectorClass, inputClass, hiddenInputId, minValue, maxValue) {
    document.querySelectorAll(selectorClass).forEach(selector => {
        const input = selector.querySelector(inputClass);
        const decreaseBtn = selector.querySelector(".decrease");
        const increaseBtn = selector.querySelector(".increase");
        const hiddenInput = document.getElementById(hiddenInputId);

        if (!input.value || isNaN(parseInt(input.value))) {
            input.value = minValue;
            hiddenInput.value = minValue;
        }

        const updateRecap = () =>{
            hiddenInput.value = input.value;
            hiddenInput.dispatchEvent(new Event('input'));
        }

        decreaseBtn.addEventListener("click", () => {
            let currentValue = parseInt(input.value);

            if (currentValue > minValue) {
                input.value = currentValue - 1;
                updateRecap();
            }
        });

        increaseBtn.addEventListener("click", () => {
            let currentValue = parseInt(input.value);

            if (currentValue < maxValue) {
                input.value = currentValue + 1;
                updateRecap();
            }
        });
    });
}
