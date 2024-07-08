// *SWIPER -----------------------------------

function mySwiper(
	btnRight, 
	btnLeft, 
	cards, 
	clicksSmMd = 5, 
	clicksLg = clicksSmMd, 
	clicksXl=clicksLg, 
	clicksXxl=clicksXl ) {
	let counter = 0;

	if (btnRight && btnLeft && cards) {
		const viewportWidth = window.innerWidth;
		let clicksNumber = 0;
		
			if(viewportWidth < 768){
				clicksNumber = clicksSmMd;
			}
			else if(viewportWidth < 1024){
				clicksNumber = clicksLg;
			}
			else if(viewportWidth < 1440){
				clicksNumber = clicksXl;
			}
			else{
				clicksNumber = clicksXxl;
			}


		btnRight.addEventListener('click', ()=>{
			console.log(viewportWidth);
			console.log(counter)
			if(counter === clicksNumber){
				for(let i = 0; i<cards.length; i++){
					cards[i].classList.remove('hidden');
				}
				counter = 0;
				btnLeft.classList.remove('onClick');
			}
			else{
			cards[counter].classList.toggle('hidden');
			counter++;
			btnLeft.classList.add('onClick');
			}
		})

		btnLeft.addEventListener('click', () => {
			
			if(counter > 0){
				cards[counter-1].classList.remove('hidden');
				counter--;
			}
			if(!cards[0].classList.contains('hidden')){
				btnLeft.classList.remove('onClick');
			}
		});

	}
}


// * SHOW ERROR MESSAGE FOR INPUT ----------------------

function displayErrorMessageInput(fieldset, errorMessage, form){
	if(!form.querySelector('#js-form-error')){
		const formPar = document.createElement('p');
		formPar.id = 'js-form-error';
		formPar.innerText = "* Some fields are not filled in correctly.";
		formPar.classList.add('js-error-input');
		form.appendChild(formPar);
	}

	if(!fieldset.querySelector('.js-error-input')){
		const inputWithError = fieldset.querySelector('input');
		const par = document.createElement('p');
		par.innerText = errorMessage;
		par.classList.add('js-error-input');
		fieldset.appendChild(par);
		inputWithError.style.border = '1px solid red';
	}
}

// * CHECK THAT INPUT IS NOT EMPTY ----------------------

function isNotEmpty(input, form){
	if(input.value.trim() === ""){
		displayErrorMessageInput(input.parentElement, "* Field required", form);
		return false;
	}
	else{
		return true;
	}
}

// * FRONTEND EMAIL VERIFICATION ------------------------

function emailVerification(email, form){
	const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

	if(!isNotEmpty(email, form)){
		return false;
	} 
	else if(!emailPattern.test(email.value)){
		displayErrorMessageInput(email.parentElement, "* Invalid data format", form);
		return false;
	}
	else{
		return true;
	}
}

// *FRONTEND PHONE NUMBER CHECK -----------------------

function phoneVerification(phone, form){
	const phonePattern = /^\+?[78][-(]?\d{3}\)?[-]?\d{3}[-]?\d{2}[-]?\d{2}$/;

	if(!isNotEmpty(phone, form)){
		return false;
	}
	else if(!phonePattern.test(phone.value)){
		displayErrorMessageInput(phone.parentElement, "* Invalid data format", form);
		return false;
	}
	else{
		return true;
	}
}

// * FRONTEND CHECKBOX CHECK ---------------------------

function checkboxVerification(input, form){
	if(!input.checked){
		displayErrorMessageInput(input.parentElement, "* Field required", form);
		return false;
	}
	else{
		return true;
	}
}

// *FORM VALIDATION ------------------------------

function formValidation(validationInputArray){
	if (validationInputArray.includes(false)){
		return false;
	}
	else{
		return true;
	}
}





// ? MAIN CODE ----------------------------

document.addEventListener('DOMContentLoaded', ()=>{



		// !Burger menu-----------------------------

	(() => {
		const burgerOpen = document.querySelector('.header__burger_menu')
		const burgerClose = document.querySelector('.header__nav_close')
		const navigation = document.querySelector('.header__nav')

		burgerOpen.addEventListener('click', () => {
			navigation.classList.toggle('active_menu')
		})

		burgerClose.addEventListener('click', () => {
			navigation.classList.remove('active_menu')
		})
	})();

	// !SWIPER PROPERTIES----------------------------------

	const btnRight = document.querySelector('.featured__btn.right');
	const btnLeft = document.querySelector('.featured__btn.left');
	const cards = document.querySelectorAll('.featured__card');

	mySwiper(btnRight, btnLeft, cards, 5, 5, 4, 3);


	// !SWIPER REVIEWS-------------------------------------
	const btnRightReviews = document.querySelector('.reviews__btn.right');
	const btnLeftReviews = document.querySelector('.reviews__btn.left');
	const cardsReviews = document.querySelectorAll('.reviews__card');

	mySwiper(btnRightReviews, btnLeftReviews, cardsReviews, 4, 4, 2);


	// !ZOOM IMG----------------------------------

	const zoomableImage = document.querySelectorAll('.featured__card_img > img');
	const overlay = document.querySelector('.js-overlay');

	if(zoomableImage){
		zoomableImage.forEach(image => {
			image.addEventListener('click', function() {
				overlay.style.display = "flex";
				const imgClone = image.cloneNode();
				overlay.innerHTML = '';
				overlay.appendChild(imgClone);
			});
		});
	}
	
	if(overlay){
		overlay.addEventListener('click', function(event){
			if(event.target === overlay){
				overlay.style.display = 'none';
			}
		});
	}
	

	// !VALIDATION PROPERTIES FORM------------------------------

	const propertiesForm = document.querySelector('.js-properties-form');
	const propertiesTxtInputs = propertiesForm.querySelectorAll('input[type="text"]');
	const propertiesEmail = document.querySelector('#email');
	const propertiesPhone = document.querySelector('#phone');
	const propertiesCheckbox = document.querySelector('#agree');


	propertiesForm.addEventListener('submit', function(event) {
			event.preventDefault();
			let propertiesCheckArray = [];

			propertiesTxtInputs.forEach(item => {
				const result = isNotEmpty(item, propertiesForm);
				propertiesCheckArray.push(result);
			});

			const isEmailCorrect = emailVerification(propertiesEmail, propertiesForm);
			propertiesCheckArray.push(isEmailCorrect);

			const isNumberCorrect = phoneVerification(propertiesPhone, propertiesForm);
			propertiesCheckArray.push(isNumberCorrect);

			const isChecked = checkboxVerification(propertiesCheckbox, propertiesForm);
			propertiesCheckArray.push(isChecked);
			
			// const isFormValid = formValidation(propertiesCheckArray, event);

			// if(isFormValid){
			// 	this.submit();
			// }
		});

	










});


