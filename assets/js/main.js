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
		const par = document.createElement('p');
		par.innerText = errorMessage;
		par.classList.add('js-error-input');
		fieldset.appendChild(par);
		inputWithError.style.border = '1px solid red';
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
		displayErrorMessageInput(fieldset, "Input cannot be empty.");
		return false;
	}
	else {
		return true;
	}
}



// *SEARCH INSERT MARK--------------------------

	function insertMark(string, position, len){
		return string.slice(0, position)+'<mark style="background: #703BF7; color: white">'+string.slice(position, position+len)+'</mark>'+string.slice(position+len);
	}

// 	*SEARCH FUNCTION-------------------------------------

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
						displayErrorMessageInput(fieldset, 'The property does not exist.');
					}
				}
		});
			const fieldset = searchInput.parentElement;
			removeErrorMessage(searchInput, fieldset);
	}






	


});


