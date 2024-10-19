jQuery(document).ready(function ($) {

    let carousel = $('.stm_listing_icon_filter.swiper')

    carousel.each(function (index, item) {
        let $item = $(item),
            data = $item.data(),
            responsive, options, widget_id

        if (!data || !data.hasOwnProperty('per_row_responsive') || data.per_row_responsive === undefined)
            return

        responsive = data.per_row_responsive
        options = data.options
        widget_id = data.widget_id

        let slider_options = {
            spaceBetween: 10,
            navigation: {
                nextEl: "#" + widget_id + " .swiper-button-next",
                prevEl: "#" + widget_id + " .swiper-button-prev",
            },
            simulateTouch: false,
            autoplay: false,
            speed: 500,
            loop: false,
            breakpoints: {
                0: {
                    slidesPerView: responsive.mobile,
                    slidesPerGroup: options.hasOwnProperty('slides_per_transition') ? options.slides_per_transition.mobile : 1,
                },
                768: {
                    slidesPerView: responsive.tablet,
                    slidesPerGroup: options.hasOwnProperty('slides_per_transition') ? options.slides_per_transition.tablet : 1,
                },
                992: {
                    slidesPerView: responsive.desktop,
                    slidesPerGroup: options.hasOwnProperty('slides_per_transition') ? options.slides_per_transition.desktop : 1,
                },
            }
        }

        if (options.hasOwnProperty('click_drag') && options.click_drag)
            slider_options.simulateTouch = true

        if (options.hasOwnProperty('loop') && options.loop)
            slider_options.loop = true

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

        if (options.hasOwnProperty('navigation') && !options.navigation)
            slider_options.navigation = false

        let swiper = new Swiper('#' + widget_id + ' .swiper-container', slider_options);

        if (options.hasOwnProperty('pause_on_mouseover') && options.pause_on_mouseover) {
            $(swiper.$el[0]).hover(swiper.autoplay.stop, swiper.autoplay.start)
        }

    })
})
