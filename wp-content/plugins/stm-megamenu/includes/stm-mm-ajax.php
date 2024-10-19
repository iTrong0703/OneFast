<?php
add_action( 'wp_footer', 'stm_mm_CurrentUrl' );
function stm_mm_CurrentUrl() {
	?>
	<script>
		var mmAjaxUrl = '<?php echo esc_js( admin_url( 'admin-ajax.php', 'relative' ) ); ?>';
	</script>
	<?php
}
