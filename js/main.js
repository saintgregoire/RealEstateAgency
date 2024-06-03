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

	// !SWIPER-------------------------------------

	const btnRight = document.querySelector('.featured__btn.right');
	const btnLeft = document.querySelector('.featured__btn.left');
	const cards = document.querySelectorAll('.featured__card');

	let counter = 0;
	

	btnRight.addEventListener('click', ()=>{
		if(counter === 4){
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
		console.log(counter)
		if(counter > 0){
			cards[counter-1].classList.remove('hidden');
			counter--;
		}
		if(!cards[0].classList.contains('hidden')){
			btnLeft.classList.remove('onClick');
		}
	});
	





});


