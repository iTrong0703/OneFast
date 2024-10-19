<?php
$bind_tax = apply_filters( 'stm_data_binding_func', array() );
//phpcs:disable
?>
	<script type="text/javascript">
			(function($) {
				"use strict";
				
				var buttonText = '';
				$('document').ready(function(){
					$('.stm-horizontal-expand-filter span').on('click', function(){
						$('.stm-horizontal-filter-sidebar').toggleClass('expanded');
						$('.stm-horizontal-longer-filter').slideToggle();
						
						if(buttonText == '') {
							buttonText = $(this).text();
							$(this).text(stm_filter_expand_close);
						} else {
							$(this).text(buttonText);
							buttonText = '';
						}
					});
					
				});
				
			})(jQuery);
	</script>
<?php //phpcs:enable ?>