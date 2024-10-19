document.addEventListener('DOMContentLoaded', function () {
	function initializeTabs() {
		var tabs = document.querySelectorAll('.listing-tab')
		var tabPanes = document.querySelectorAll('.listings-tab-content')
		var activeTabFound = false

		tabs.forEach(function (tab) {
			if (tab.classList.contains('active')) {
				activeTabFound = true
			}
		})

		if (!activeTabFound && tabs.length > 0) {
			var firstTab = tabs[0]
			firstTab.classList.add('active')

			var firstTabLink = firstTab.querySelector('a')
			var target = firstTabLink.getAttribute('href')

			if (target && target.startsWith('#')) {
				tabPanes.forEach(function (pane) {
					pane.classList.remove('active')
					pane.classList.remove('in')
				})

				var targetElement = document.querySelector(target)
				if (targetElement) {
					targetElement.classList.add('active')
					targetElement.classList.add('in')
				}
			}
		}
	}

	initializeTabs()

	var observer = new MutationObserver(function (mutations) {
		mutations.forEach(function (mutation) {
			if (mutation.type === 'childList') {
				initializeTabs()
			}
		})
	})

	observer.observe(document.body, { childList: true, subtree: true })
})
