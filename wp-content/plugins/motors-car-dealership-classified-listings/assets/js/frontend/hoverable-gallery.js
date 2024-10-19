(function ($) {
	"use strict";

	$(document).ready(function () {

		if ($('.stm-hoverable-interactive-galleries .interactive-hoverable .hoverable-wrap').length > 0) {
			// on desktop, hover
			$(document).on('mousemove', '.interactive-hoverable .hoverable-wrap .hoverable-unit', function(){
				var index = $(this).index();
				if($(this).parent().siblings('.hoverable-indicators').find('.indicator.active').index() !== index) {
					$(this).parent().siblings('.hoverable-indicators').find('.indicator.active').removeClass('active');
					$(this).parent().siblings('.hoverable-indicators').find('.indicator').eq(index).addClass('active');
				}

				$(this).siblings().removeClass('active');
				$(this).addClass('active');
			});

			$(document).on('mouseleave', '.interactive-hoverable', function(){
				$(this).find('.hoverable-indicators .indicator.active').removeClass('active');
				$(this).find('.hoverable-indicators .indicator:first-child').addClass('active');

				$(this).find('.hoverable-wrap .hoverable-unit.active').removeClass('active');
				$(this).find('.hoverable-wrap .hoverable-unit:first-child').addClass('active');
			});

			// on mobile, swipe
			stm_init_hoverable_swipe();
		}

	});

	function stm_init_hoverable_swipe() {
		if ($('.stm-hoverable-interactive-galleries .interactive-hoverable .hoverable-wrap').length > 0) {
			$('.stm-hoverable-interactive-galleries .interactive-hoverable .hoverable-wrap').each((index, el) => {
				let galleryPreviewSwiper = new SwipeEvent(el);

				galleryPreviewSwiper.onRight(function() {
					let active_index = $(this.element).find('.hoverable-unit.active').index();
					$(this.element).find('.hoverable-unit').removeClass('active');
					$(this.element).siblings('.hoverable-indicators').find('.indicator.active').removeClass('active');
					if(active_index === 0) {
						$(this.element).find('.hoverable-unit:last-child').addClass('active');
						$(this.element).siblings('.hoverable-indicators').find('.indicator:last-child').addClass('active');
					} else {
						$(this.element).find('.hoverable-unit').eq(active_index - 1).addClass('active');
						$(this.element).siblings('.hoverable-indicators').find('.indicator').eq(active_index - 1).addClass('active');
					}
				});

				galleryPreviewSwiper.onLeft(function() {
					let active_index = $(this.element).find('.hoverable-unit.active').index();
					let total_items = $(this.element).find('.hoverable-unit');
					$(this.element).find('.hoverable-unit').removeClass('active');
					$(this.element).siblings('.hoverable-indicators').find('.indicator.active').removeClass('active');
					if(active_index === parseInt(total_items.length - 1)) {
						$(this.element).find('.hoverable-unit:first-child').addClass('active');
						$(this.element).siblings('.hoverable-indicators').find('.indicator:first-child').addClass('active');
					} else {
						$(this.element).find('.hoverable-unit').eq(active_index + 1).addClass('active');
						$(this.element).siblings('.hoverable-indicators').find('.indicator').eq(active_index + 1).addClass('active');
					}
				});

				galleryPreviewSwiper.run();
			});
		}
	}

	// swipe events using vanilla js
	var  SwipeEvent  = (function () {
		function  SwipeEvent(element) {
			this.xDown  =  null;
			this.yDown  =  null;
			this.element  =  typeof (element) === 'string' ? document.querySelector(element) : element;
			this.element.addEventListener('touchstart', function (evt) {
				this.xDown  =  evt.touches[0].clientX;
				this.yDown  =  evt.touches[0].clientY;
			}.bind(this), false);
		}

		SwipeEvent.prototype.onLeft  =  function (callback) {
			this.onLeft  =  callback;
			return this;
		};
		SwipeEvent.prototype.onRight  =  function (callback) {
			this.onRight  =  callback;
			return this;
		};
		SwipeEvent.prototype.onUp  =  function (callback) {
			this.onUp  =  callback;
			return this;
		};
		SwipeEvent.prototype.onDown  =  function (callback) {
			this.onDown  =  callback;
			return this;
		};

		SwipeEvent.prototype.handleTouchMove  =  function (evt) {
			if (!this.xDown  ||  !this.yDown) {
				return;
			}
			var  xUp  =  evt.touches[0].clientX;
			var  yUp  =  evt.touches[0].clientY;
			this.xDiff  = this.xDown  -  xUp;
			this.yDiff  = this.yDown  -  yUp;

			if (Math.abs(this.xDiff) !==  0) {
				if (this.xDiff  >  2) {
					typeof (this.onLeft) ===  "function"  && this.onLeft();
				} else  if (this.xDiff  <  -2) {
					typeof (this.onRight) ===  "function"  && this.onRight();
				}
			}

			if (Math.abs(this.yDiff) !==  0) {
				if (this.yDiff  >  2) {
					typeof (this.onUp) ===  "function"  && this.onUp();
				} else  if (this.yDiff  <  -2) {
					typeof (this.onDown) ===  "function"  && this.onDown();
				}
			}
			// Reset values.
			this.xDown  =  null;
			this.yDown  =  null;
		};

		SwipeEvent.prototype.run  =  function () {
			this.element.addEventListener('touchmove', function (evt) {
				this.handleTouchMove(evt);
			}.bind(this), false);
		};

		return  SwipeEvent;
	}());

})(jQuery);
