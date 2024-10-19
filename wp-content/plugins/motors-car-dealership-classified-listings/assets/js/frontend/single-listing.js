(function ($) {
	"use strict";
	if (typeof $.uniform === "object") {
		let uniform_selectors = ':checkbox:not("#createaccount"), :radio:not(".input-radio")';

		$( uniform_selectors, $( '#request-trade-in-offer' ) ).not( '#make_featured' ).uniform( {} );
	}
})( jQuery );
