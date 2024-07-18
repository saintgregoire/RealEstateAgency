
function displayErrorMessageInput(fieldset, errorMessage){

    if(!fieldset.querySelector('.js-error-input')){
        const inputWithError = fieldset.querySelector('input');
        const par = document.createElement('p');
        par.innerText = errorMessage;
        par.classList.add('text-danger');
        par.classList.add('js-error-input');
        par.classList.add('mb-0');
        par.style.fontSize = '12px';
        fieldset.appendChild(par);
        inputWithError.style.border = '1px solid red';
    }
}

function removeErrorMessage(input, fieldset){
    input.addEventListener('input', () =>{
        input.style.border = 'none';
        const inputWithError = fieldset.querySelector('.js-error-input');
        if(inputWithError){
            fieldset.removeChild(inputWithError);
        }
    });
}

// * CHECK THAT FIELD IS NOT EMPTY-----------------------
function inputIsNotEmpty(input, fieldset){
    if (input.value.trim() === '' ){
        displayErrorMessageInput(fieldset, "*This field cannot be empty.");
        return false;
    }
    else {
        return true;
    }
}

// * CHECK EMAIL FORMAT ----------------------------
function isEmailInputValid(emailInput, fieldset){
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if(!emailRegex.test(emailInput.value)){
        displayErrorMessageInput(fieldset, '*Wrong format of email');
        return false;
    }
    return true;
}

// * CHECK PASSWORD FORMAT-------------------------

function validatePassword(password, fieldset) {
    if (password.length < 11) {
        if (!/[A-Z]/.test(password)) {
            if (!/[\W]/.test(password)) {
                return true;
            }
            else{
                displayErrorMessageInput(fieldset, '*Minimum 1 special character.');
                return false;
            }
        }
        else{
            displayErrorMessageInput(fieldset, '*Minimum 1 capital letter.');
            return false;
        }
    }
    else{
        displayErrorMessageInput(fieldset, '*Minimum 11 symbols.');
        return false;
    }
}



document.addEventListener('DOMContentLoaded', ()=>{

    // ! CHANGE EMAIL FOR USER----------------------


    const changeEmailLinks = document.querySelectorAll('.change-email');
    const cancelEmailBtn = document.querySelectorAll('.cancelEmailBtn');
    const formsEmail = document.querySelectorAll('.form-change-email');

    changeEmailLinks.forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            const userId = this.getAttribute('data-user-id');
            const form = document.querySelector(`#form-${userId}`);
            const span = document.querySelector(`.user-email-span-${userId}`);
            form.classList.remove('d-none');
            span.classList.add('d-none');
        })
    });

    cancelEmailBtn.forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form');
            const userId = this.getAttribute('data-user-id');
            const span = document.querySelector(`.user-email-span-${userId}`);
            form.classList.add('d-none');
            span.classList.remove('d-none');
        });
    });

    formsEmail.forEach(form => {
       form.addEventListener('submit', function (event)  {
            const formEmailInput = form.querySelector('.userEmailInput');
            const fieldset = formEmailInput.parentElement;

           if(!inputIsNotEmpty(formEmailInput, fieldset)){
               event.preventDefault();
           }
           else if(!isEmailInputValid(formEmailInput, fieldset)){
               event.preventDefault();
           }
           removeErrorMessage(formEmailInput, fieldset)
        }) ;
    });


//     !CHANGE PASSWORD FOR USER------------------------




});