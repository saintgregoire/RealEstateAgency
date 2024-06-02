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
	
	btnRight.addEventListener('click', () => {
		counter++;
		btnLeft.classList.add('onClick');
		
		if (counter >= 6){
			counter = 0;
			btnLeft.classList.remove('onClick');
		}
		
		for(let i=0; i < cards.length; i++){
			if(i !== counter){
				cards[i].classList.add('hidden');
			}
			else{
				cards[i].classList.remove('hidden');
			}
		}
		
	});

	btnLeft.addEventListener('click', () => {

		if(counter !== 0){
			counter--;
			
			for(let i=0; i < cards.length; i++){
				if(i !== counter ){
					cards[i].classList.add('hidden');
				}
				else{
					cards[i].classList.remove('hidden');
				}
			}
			if(counter === 0){
				btnLeft.classList.remove('onClick');
			}
		}
	});





});


