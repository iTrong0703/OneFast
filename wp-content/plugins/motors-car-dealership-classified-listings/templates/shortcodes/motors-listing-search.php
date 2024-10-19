<?php
$args = array(
	'post_type'              => apply_filters( 'stm_listings_post_type', 'listings' ),
	'post_status'            => 'publish',
	'posts_per_page'         => 1,
	'suppress_filters'       => 0,
	'update_post_meta_cache' => false,
	'update_post_term_cache' => false,
);

if ( apply_filters( 'stm_sold_status_enabled', true ) ) {
	$args['meta_query'][] = array(
		'key'     => 'car_mark_as_sold',
		'value'   => '',
		'compare' => '=',
	);
}
?>
<div class="motors_dynamic_listing_filter filter-listing stm-vc-ajax-filter animated fadeIn motors-alignwide"
		data-options="<?php echo esc_attr( wp_json_encode( apply_filters( 'stm_data_binding_func', array(), true ) ) ); ?>"
		data-show_amount="yes"
>
	<form action="<?php echo esc_url( apply_filters( 'stm_filter_listing_link', '' ) ); ?>" method="GET">
		<div class="stm-filter-tab-selects filter stm-vc-ajax-filter">
			<?php apply_filters( 'motors_listing_filter_get_selects', $filter_fields ?? 'make', '', array(), $show_amount ?? '' ); ?>
			<button type="submit" class="search-submit heading-font">
				<i class="fas fa-search"></i>
				<?php
				$all = new WP_Query( $args );

				echo '<span>' . esc_html( $all->found_posts ) . '</span> ' . esc_html__( 'Cars', 'stm_vehicles_listing' );
				?>
			</button>
		</div>
	</form>
</div>
<?php //phpcs:disable ?>
<script type="text/javascript">
    jQuery(function ($) {
        let options = $('.motors_dynamic_listing_filter').data('options');

        $.each(options, function (slug, config) {
            config.selector = '[name=' + slug.replace('-',  '_pre_') + ']';
        });

        $('.stm-filter-tab-selects').each(function () {
            new STMCascadingSelect(this, options);
        });

        $("select[data-class='stm_select_overflowed']").on("change", function () {
            var sel = $(this);
            var selValue = sel.val();
            var selType = sel.attr("data-sel-type");
            var min = 'min_' + selType;
            var max = 'max_' + selType;

            if( selValue === null || selValue.length == 0 ) return;

            if (selValue.includes("<")) {
                var str = selValue.replace("<", "").trim();
                $("input[name='" + min + "']").val("");
                $("input[name='" + max + "']").val(str);
            } else if (selValue.includes("-")) {
                var strSplit = selValue.split("-");
                $("input[name='" + min + "']").val(strSplit[0]);
                $("input[name='" + max + "']").val(strSplit[1]);
            } else {
                var str = selValue.replace(">", "").trim();
                $("input[name='" + min + "']").val(str);
                $("input[name='" + max + "']").val("");
            }
        });
    });
</script>
<?php //phpcs:enable ?>

