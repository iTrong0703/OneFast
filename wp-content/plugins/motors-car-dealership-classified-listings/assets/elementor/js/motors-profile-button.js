'use strict'

const buttons = document.querySelectorAll('.motors-profile-button')
const dropdowns = document.querySelectorAll('.lOffer-account-dropdown')
let hideTimeout

function showDropdown(dropdown) {
	clearTimeout(hideTimeout)
	dropdown.style.visibility = 'visible'
	dropdown.style.opacity = '1'
}

function hideDropdown(dropdown) {
	hideTimeout = setTimeout(() => {
		dropdown.style.visibility = 'hidden'
		dropdown.style.opacity = '0'
	}, 200)
}

buttons.forEach((button, index) => {
	const dropdown = dropdowns[index]

	if (dropdown) {
		button.addEventListener('mouseover', () => showDropdown(dropdown))
		button.addEventListener('mouseout', () => hideDropdown(dropdown))

		dropdown.addEventListener('mouseover', () => showDropdown(dropdown))
		dropdown.addEventListener('mouseout', () => hideDropdown(dropdown))
	}
})
