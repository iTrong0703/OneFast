class MotorsListingsCategoriesMasonryAdmin extends elementorModules.frontend.handlers.Base {

	getDefaultSettings() {
		return {
			selectors: {
				carousel: '.stm-img-filter-container.swiper',
			}
		};
	}

	getDefaultElements() {
		const selectors = this.getSettings('selectors');
		return {
			$carousel: this.$element.find(selectors.carousel),
		};
	}

	onInit() {
		super.onInit();
		let data = this.elements.$carousel.data(),
			uniqid = this.elements.$carousel.data('widget-id'),
			responsive, options

		let $ = jQuery

		options = data.options

		let slider_options = {
			slidesPerView: 1,
			spaceBetween: 30,
			speed: 500,
		}

		if (options.hasOwnProperty('loop') && options.loop)
			slider_options.loop = true

		if (options.hasOwnProperty('click_drag') && options.click_drag)
			slider_options.simulateTouch = true

		if (options.hasOwnProperty('autoplay') && options.autoplay) {
			slider_options.autoplay = {
				delay: 1000,
				reverseDirection: false,
			}

			if (options.hasOwnProperty('delay') && options.delay) {
				slider_options.autoplay.delay = options.delay
			}

			if (options.hasOwnProperty('reverse') && options.reverse) {
				slider_options.autoplay.reverseDirection = true
			}

		}

		if (options.hasOwnProperty('transition_speed') && options.transition_speed)
			slider_options.speed = options.transition_speed

		if (options.hasOwnProperty('navigation') && options.navigation) {
			slider_options.navigation = {
				nextEl: '.stm-image-filter-wrap-' + uniqid + ' .carousel-nav-next',
				prevEl: '.stm-image-filter-wrap-' + uniqid + ' .carousel-nav-prev',
			}
		}

		let swiper = new Swiper('.stm-image-filter-wrap-' + uniqid + ' .stm-img-filter-container.swiper', slider_options);

		if (options.hasOwnProperty('pause_on_mouseover') && options.pause_on_mouseover) {
			$(swiper.$el[0]).hover(swiper.autoplay.stop, swiper.autoplay.start)
		}

	}
}

jQuery(window).on('elementor/frontend/init', () => {
	const addHandler = ($element) => {
		elementorFrontend.elementsHandler.addHandler(MotorsListingsCategoriesMasonryAdmin, {
			$element,
		});
	};
	elementorFrontend.hooks.addAction('frontend/element_ready/motors-listings-categories-masonry.default', addHandler);
});
