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

function displayErrorMessageInput(fieldset, errorMessage){

	if(!fieldset.querySelector('.js-error-input')){
		const inputWithError = fieldset.querySelector('input');
		const selectWithError = fieldset.querySelector('select');
		const par = document.createElement('p');
		par.innerText = errorMessage;
		par.classList.add('js-error-input');
		fieldset.appendChild(par);
		if(inputWithError){
			inputWithError.style.border = '1px solid red';
		}
		else{
			selectWithError.style.border = '1px solid red';
		}
	}
}

// * REMOVE ERROR MESSAGE------------------------
function removeErrorMessage(input, fieldset){
	input.addEventListener('input', () =>{
		input.style.border = 'none';
		const inputWithError = fieldset.querySelector('.js-error-input');
		if(inputWithError){
			fieldset.removeChild(inputWithError);
		}
	});
}


//  * INPUT NOT EMPTY--------------------------
function inputIsNotEmpty(input, fieldset){
	if (input.value.trim() === '' ){
		displayErrorMessageInput(fieldset, "*This field cannot be empty.");
		return false;
	}
	else {
		return true;
	}
}


// * INPUT EMAIL FORMAT-----------------------------
function isEmailInputValid(emailInput, fieldset){
		const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
	if(!emailRegex.test(emailInput.value)){
		displayErrorMessageInput(fieldset, '*Wrong email');
		return false;
	}
	return true;
}


// * INPUT PHONE FORMAT-----------------------
function isPhoneValid(phoneInput, fieldset){
		const phonePattern = /^\+?[1-9]\d{1,14}$/;
		if(!phonePattern.test(phoneInput.value)){
			displayErrorMessageInput(fieldset, '*Wrong phone number');
			return false;
		}
		else{
			return true;
		}
}

// * CHECKBOX VALIDATION-------------------

function isCheckboxValid(checkbox, fieldset){
	if(checkbox.checked){
		return true;
	}
	else{
		displayErrorMessageInput(fieldset, '*Required');
		return false;
	}
}

// *SEARCH INSERT MARK--------------------------

	function insertMark(string, position, len){
		return string.slice(0, position)+'<mark style="background: #703BF7; color: white">'+string.slice(position, position+len)+'</mark>'+string.slice(position+len);
	}

// 	*SEARCH FUNCTION------------------------------------

function search (searchInput, list, listItems) {
	searchInput.addEventListener('click', function (){
		list.classList.remove('hidden');
	});
	searchInput.addEventListener('blur', function (){
		setTimeout(function (){
			list.classList.add('hidden');
		}, 200);
	});
	searchInput.addEventListener('input', function () {
		let val = this.value.trim().toLowerCase();
		if(val !== ''){
			listItems.forEach(function (elem){
				if(elem.innerText.toLowerCase().search(val) === -1){
					elem.classList.add('hidden');
					elem.innerHTML = elem.innerText;
				}
				else{
					elem.classList.remove('hidden');
					let str = elem.innerText;
					let startPos = elem.innerText.toLowerCase().search(val);
					elem.innerHTML = insertMark(str, startPos, val.length);
				}
			});
		}
		else{
			listItems.forEach(function (elem){
				elem.classList.remove('hidden');
				elem.innerHTML = elem.innerText;
			});
		}
	});

	listItems.forEach(function (item){
		item.addEventListener('click', function (){
			searchInput.value = item.innerText;
			list.classList.add('hidden');
		});
	});

}


// * CHECK FORM FUNCTION -------------------

function checkForm(form, isNotEmptyArray, emailInput, phoneInput, checkbox) {
	if(form){
		form.addEventListener('submit', (e) => {
			isNotEmptyArray.forEach(element =>{
				const parentFieldset = element.parentElement;
				const notEmpty = inputIsNotEmpty(element, parentFieldset);
				removeErrorMessage(element, parentFieldset);
				if(!notEmpty){
					e.preventDefault();
				}
			});

			const isEmailValid = isEmailInputValid(emailInput, emailInput.parentElement);

			const isPhoneInputValid = isPhoneValid(phoneInput, phoneInput.parentElement);

			const isCheckboxChecked = isCheckboxValid(checkbox, checkbox.parentElement);
			removeErrorMessage(checkbox, checkbox.parentElement);

			if(!isEmailValid || !isPhoneInputValid || !isCheckboxChecked){
				e.preventDefault();
			}
		});
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
	let lengthMdLg = cards.length - 1;
	let lengthXl = cards.length - 2;
	let lengthXxl = cards.length - 3;


	mySwiper(btnRight, btnLeft, cards, lengthMdLg, lengthMdLg, lengthXl, lengthXxl);


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


	// ! POP-UP----------------------------

	const popUp = document.querySelector('.pop-up');
	const closePopUp = document.querySelector('.pop-up__close');

	if(popUp){
		popUp.addEventListener('click', (e) => {
			if(e.target === popUp || e.target === closePopUp ){
				popUp.classList.add('hidden');
			}
		});
	}


	// !SEARCH-----------------------------------

	const searchInput = document.querySelector('#search');
	const list = document.querySelector('.dream__options');
	const listItems = document.querySelectorAll('.dream__options > li');
	const searchForm = document.querySelector('#searchForm');

	if(searchForm){
		search(searchInput, list, listItems );

		searchForm.addEventListener('submit', (e) =>{
				const fieldset = searchInput.parentElement;
				const check = inputIsNotEmpty(searchInput, fieldset);
				if(check === false){
					e.preventDefault();
				}
				else{
					let options = [];
					listItems.forEach(item =>{
						options.push(item.innerText);
					});
					if(!options.includes(searchInput.value)){
						e.preventDefault();
						displayErrorMessageInput(fieldset, '*The property does not exist.');
					}
				}
		});
			const fieldset = searchInput.parentElement;
			removeErrorMessage(searchInput, fieldset);
	}


// 	! CHECK EMAIL FOOTER FORM-----------------------------------

	const emailForm = document.querySelector('.email__form');
	const emailInput = document.querySelector('.email__input');
	const messageParagraphe = document.querySelector('.email__success');

	emailForm.addEventListener('submit', (e) =>{
		const isNotEmpty = inputIsNotEmpty(emailInput, emailForm);
		const isEmailOk = isEmailInputValid(emailInput, emailForm);
		e.preventDefault();
		if(isEmailOk || isNotEmpty){
			const form = e.target;
			const formData = new FormData(form);
			const link = '/RealEstateAgency/index.php?route=subscribe-newsletter';

			fetch(link, {
				method: 'POST',
				body: formData
			})
				.then((response) => {
					return response.json();
				})
				.then((data) => {
					if(data.success){
						emailInput.value = '';
						messageParagraphe.innerText = data.message;
						messageParagraphe.style.color = 'greenyellow';
						messageParagraphe.classList.remove('hidden');
					}

				})
				.catch((error) => {
					console.error('Error: ', error);
					messageParagraphe.innerText = 'Error. Please try later.';
					messageParagraphe.style.color = 'red';
					messageParagraphe.classList.remove('hidden');
				})
		}

	});
	removeErrorMessage(emailInput, emailForm);




// 	! CHECK PROPERTIES FORM---------------------

	const propertiesForm = document.querySelector('.js-properties-form');
	const propertiesInputs = document.querySelectorAll('.happen__input');
	const propertiesEmailInput = document.querySelector('#email');
	const propertiesPhone = document.querySelector('#phone');
	const propertiesLocation = document.querySelector('#location');
	const propertiesType = document.querySelector('#type');
	const propertiesBudget = document.querySelector('#budget');
	const propertiesCheckbox = document.querySelector('#agree');

	let checkThatNotEmpty = [ propertiesLocation, propertiesType, propertiesBudget ];

	propertiesInputs.forEach(input =>{
		checkThatNotEmpty.push(input);
	});

	checkForm(propertiesForm, checkThatNotEmpty, propertiesEmailInput, propertiesPhone, propertiesCheckbox);



// ! CHECK CONTACTS FORM--------------------------

	const contactForm = document.querySelector('.connect__form');
	const contactInputs = document.querySelectorAll('.connect__input');
	const contactEmailInput = document.querySelector('#email_conn');
	const contactPhoneInput = document.querySelector('#phone_conn');
	const contactInquirySelect = document.querySelector('#inquiry_conn');
	const contactCheckbox = document.querySelector('#agree_conn');

	let isNotEmpty = [contactInquirySelect];
	contactInputs.forEach(input =>{
		isNotEmpty.push(input);
	});

	checkForm(contactForm, isNotEmpty, contactEmailInput, contactPhoneInput, contactCheckbox);



// 	! CHECK PROPERTY DETAILS FORM -----------------------------

	const detailsForm = document.querySelector('.inquire__form');
	const detailsInputs = document.querySelectorAll('.inquire__input');
	const detailSelect = document.querySelector('#inquire__selected');
	const detailsEmail = document.querySelector('#inquire__email');
	const detailsPhone = document.querySelector('#inquire__tel');
	const detailsCheckbox = document.querySelector('#inquire__agree');

	let notEmptyCheck = [detailSelect];
	detailsInputs.forEach(input => {
		notEmptyCheck.push(input);
	});


	if(detailsForm) {

		detailsForm.addEventListener('submit', (e) => {

			e.preventDefault();

			let notEmpty = true;

			notEmptyCheck.forEach(element => {
				const parentFieldset = element.parentElement;
				if (!inputIsNotEmpty(element, parentFieldset)) {
					notEmpty = false;
				}
				removeErrorMessage(element, parentFieldset);
			});

			const isEmailValid = isEmailInputValid(detailsEmail, detailsEmail.parentElement);

			const isPhoneInputValid = isPhoneValid(detailsPhone, detailsPhone.parentElement);

			const isCheckboxChecked = isCheckboxValid(detailsCheckbox, detailsCheckbox.parentElement);
			removeErrorMessage(detailsCheckbox, detailsCheckbox.parentElement);


			if (isEmailValid && isPhoneInputValid && isCheckboxChecked && notEmpty) {
				const form = e.target;
				const formData = new FormData(form);
				const link = '/index.php?route=check-property-lead';
				fetch(link, {
					method: 'POST',
					body: formData
				})
					.then((response) => {
						return response.json();
					})
					.then((data) => {
						if (data.success) {
							popUp.classList.remove('hidden');
							detailsInputs.forEach(input => {
								input.value = '';
								document.querySelector('#inquire__textarea').value = '';
								detailsCheckbox.checked = false;
							})
						}
					})
					.catch((error) => {
						console.error('Error: ', error);
					})
			}
		});
	}



});


