// !Burger menu

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