const inputNom = document.getElementById("nameInput");
const inputPrenom = document.getElementById("firstnameInput");
const inputEmail = document.getElementById("emailInput");
const inputPassword = document.getElementById("passwordInput");
const inputValidationPassword = document.getElementById("passwordValidateInput");
const btnValidation = document.getElementById("btn-validation-inscription")

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", function () {
        validateForm();
    });
} else {
    validateForm();
}

if(inputNom) inputNom.addEventListener("keyup", validateForm);
if(inputNom) inputPrenom.addEventListener("keyup", validateForm);
if(inputEmail) inputEmail.addEventListener("keyup", validateForm);
if(inputPassword) inputPassword.addEventListener("keyup", validateForm);
if(inputValidationPassword) inputValidationPassword.addEventListener("keyup", validateForm);

function validateConfirmPassword(inputPwd, inputConfirmPwd){
    if(inputPwd.value === inputConfirmPwd.value){
        inputConfirmPwd.classList.add("is-valid");
        inputConfirmPwd.classList.remove("is-invalid");
        return true;
    }
    else{
        inputConfirmPwd.classList.add("is-invalid");
        inputConfirmPwd.classList.remove("is-valid");
        return false;
    }
}

function validateForm(){
    const nomOk = validateRequired(inputNom);
    const prenomOk = validateRequired(inputPrenom);
    const mailOk = validateMail(inputEmail);
    const passwordOk = validatePassword(inputPassword);
    const confirmPasswordOk = validateConfirmPassword(inputPassword, inputValidationPassword)
    
    if(nomOk && prenomOk && mailOk && passwordOk && confirmPasswordOk){
        btnValidation.disabled = false;
    }
    else{
        btnValidation.disabled = true;
    }
}

function validatePassword(input){
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{12,}$/;
    const passwordUser = input.value;
    if(passwordUser.match(passwordRegex)){
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

function validateMail(input){
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const emailUser = input.value;
    if(emailUser.match(emailRegex)){
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