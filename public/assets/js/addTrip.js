const steps = document.querySelectorAll(".step");
const prevBtn = document.querySelector(".btn-prev");
const nextBtn = document.querySelector(".btn-next");
const submitBtn = document.querySelector(".btn-submit");
let currentStep = 0;

function validateRequired(input){
    if(input.value.trim() !== ''){
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
        return true;
    }
    else{
        input.classList.remove("is-valid");
        input.classList.add("is-invalid");
        return false;
    }
}

function checkInputs() {
    const currentStepInputs = steps[currentStep].querySelectorAll("input[required]");
    let allFilled = true;

    currentStepInputs.forEach(input =>{
        if(!validateRequired(input)){
            allFilled = false;
        }
    });

    const currentNextBtn = steps[currentStep].querySelector(".btn-next");
    if (currentNextBtn) {
        currentNextBtn.disabled = !allFilled;
    }
}

function updateSteps(){
    steps.forEach((step, index) =>{
        const stepContent = step.querySelector(".step-content");
        const stepButtons = step.querySelector(".step-buttons")
        if(stepContent){
            if(index === currentStep){
                stepContent.style.display = "block";
            }
            else{
                stepContent.style.display = "none";
            }
        }
        else{
            console.warn(`Pas de .step-content trouvé pour l'étape ${index + 1}`);
        }

        if(stepButtons){
            if(index ===currentStep){
                stepButtons.style.display = "flex";
            }
            else{
                stepButtons.style.display = "none";
            }
        }else {
            console.warn(`Pas de .step-buttons trouvé pour l'étape ${index + 1}`);
        }
    });

    const currentStepElement = steps[currentStep];
    if (!currentStepElement) {
        console.error(`Erreur : Aucune étape trouvée pour index ${currentStep}`);
        return;
    }

    const currentPrevBtn = steps[currentStep].querySelector(".btn-prev");
    const currentNextBtn = steps[currentStep].querySelector(".btn-next");
    const currentSubmitBtn = steps[currentStep].querySelector(".btn-submit");
    
    if (currentPrevBtn) {
        if (currentStep === 0) {
            currentPrevBtn.style.display = "none";
        } else {
            currentPrevBtn.style.display = "inline-block";
        }
    } else if (currentStep !== 0) {
        console.warn(`Bouton "Précédent" non trouvé pour l'étape ${currentStep + 1}`);
    }
    
    if (currentNextBtn) {
        if (currentStep === steps.length - 1) {
            currentNextBtn.style.display = "none";
        } else {
            currentNextBtn.style.display = "inline-block";
        }
    } else if (currentStep !== steps.length - 1) {
        console.warn(`Bouton "Suivant" non trouvé pour l'étape ${currentStep + 1}`);
    }
    
    if (currentSubmitBtn) {
        if (currentStep === steps.length - 1) {
            currentSubmitBtn.style.display = "inline-block";
        } else {
            currentSubmitBtn.style.display = "none";
        }
    } else if (currentStep === steps.length - 1) {
        console.warn(`Bouton "Soumettre" non trouvé pour l'étape ${currentStep + 1}`);
    }

    checkInputs();
}

steps.forEach(step => {
    step.addEventListener("input", checkInputs);
});

document.addEventListener("click", (event)=>{
    if(event.target.classList.contains("btn-next")){
        if(currentStep < steps.length -1){
            currentStep++;
            updateSteps();
        }
    }
});

document.addEventListener("click", (event)=>{
    if(event.target.classList.contains("btn-prev")){
        if(currentStep > 0){
            currentStep--;
            updateSteps();
        }
    }
});

updateSteps();