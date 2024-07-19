
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

function validatePassword(input, fieldset) {
    const password = input.value;
    if (password.length >= 11) {
        if (/[A-Z]/.test(password)) {
            if (/[\W]/.test(password)) {
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

    if(formsEmail){
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
    }




//     !CHANGE PASSWORD FOR USER------------------------

    const changePasswordLinks = document.querySelectorAll('.change-password');
    const cancelPasswordBtn = document.querySelectorAll('.cansel-password');
    const formsPassword = document.querySelectorAll('.password-form');

    if(formsPassword){
        changePasswordLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const userId = this.getAttribute('data-user-id');
                const form = document.querySelector(`#form-password-${ userId}`);
                const dropdown = document.querySelector(`#dropdown-${userId}`);
                form.classList.remove('d-none');
                dropdown.classList.add('d-none');
            });
        });


        cancelPasswordBtn.forEach(button => {
            button.addEventListener('click', function () {
                const form = this.closest('form');
                const userId = this.getAttribute('data-user-id');
                const dropdown = document.querySelector(`#dropdown-${userId}`);
                form.classList.add('d-none');
                dropdown.classList.remove('d-none');
            });
        });

        formsPassword.forEach(form =>{
            form.addEventListener('submit', function (e){
                const formPasswordInput = form.querySelector('.password-input');
                const fieldset = formPasswordInput.parentElement;

                if(!inputIsNotEmpty(formPasswordInput, fieldset)){
                    e.preventDefault();
                }
                else if(!validatePassword(formPasswordInput, fieldset)){
                    e.preventDefault();
                }
                removeErrorMessage(formPasswordInput, fieldset);
            });
        });
    }


//     !SHOW MESSAGE ---------------------------
    const messages = document.querySelectorAll('.contacts-lead-message');

    if(messages){
        messages.forEach(message =>{
            message.addEventListener('click', function () {
                const messageContent = this.innerText;
                document.querySelector('#modalContainer').innerHTML = `
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ${messageContent}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    `;
                let myModal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
                myModal.show();
            });
        });
    }


//     ! CHOOSE TABLE (PENDING LEADS)--------------------

    const leadsBtn = document.querySelector('.leads-form-btn');
    const leadsBtnOptions = document.querySelectorAll('.leads-option');
    const contactLeadsOption = document.querySelector('.contact-option');
    const propertiesLeadsOption = document.querySelector('.properties-option');
    const propertyLeadsOption = document.querySelector('.property-option');
    const contactLeadsTable = document.querySelector('.table-contacts-form');
    const propertiesLeadsTable = document.querySelector('.table-properties-form');
    const propertyLeadsTable = document.querySelector('.table-property-form');

    leadsBtnOptions.forEach(option => {
       option.addEventListener('click', function(e) {
          leadsBtn.innerText = this.innerText;

          if(e.target === contactLeadsOption){
              contactLeadsTable.classList.remove('d-none');
              propertiesLeadsTable.classList.add('d-none');
              propertyLeadsTable.classList.add('d-none');
          }
          else if(e.target === propertyLeadsOption){
              propertyLeadsTable.classList.remove('d-none');
              propertiesLeadsTable.classList.add('d-none');
              contactLeadsTable.classList.add('d-none');
          }
          else{
              propertiesLeadsTable.classList.remove('d-none');
              propertyLeadsTable.classList.add('d-none');
              contactLeadsTable.classList.add('d-none');
          }
       });
    });




});