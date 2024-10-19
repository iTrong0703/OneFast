<?php
/**
 * Shortcode attributes
 * @var $id
 * @var $taxonomies
 * @var $use_inputs
 * @var $show_listing_title
 */

defined( 'ABSPATH' ) || exit;

$car_edit = false;

if ( ! empty( apply_filters( 'stm_listings_input', null, 'edit_car' ) ) ) {
	$car_edit = true;
}

$restricted = false;

$user_id = '';
if ( is_user_logged_in() ) {
	$user    = wp_get_current_user();
	$user_id = $user->ID;
}

$restrictions = apply_filters(
	'stm_get_post_limits',
	array(
		'premoderation' => true,
		'posts_allowed' => 0,
		'posts'         => 0,
		'images'        => 0,
		'role'          => 'user',
	),
	$user_id,
	'publish'
);

if ( $restrictions['posts'] < 1 ) {
	$restricted = true;
}

$vars = array(
	'id'                    => ( ! empty( $id ) ) ? $id : false,
	'show_listing_title'    => ( ! empty( $show_listing_title ) ) ? $show_listing_title : false,
	'taxonomies'            => ( ! empty( $taxonomies ) ) ? $taxonomies : array(),
	'use_inputs'            => ( ! empty( $use_inputs ) ) ? $use_inputs : false,
	'show_sale_price_label' => ( ! empty( $show_sale_price ) ) ? $show_sale_price : 'no',
	'show_custom_label'     => ( ! empty( $show_custom_price_label ) ) ? $show_custom_price_label : 'no',
);
?>

<?php if ( $restricted && ! $car_edit ) : ?>
	<div class="stm-no-available-adds-overlay"></div>
	<div class="stm-no-available-adds">
		<h3><?php esc_html_e( 'Posts Available', 'stm_vehicles_listing' ); ?>: <span>0</span></h3>
		<p><?php esc_html_e( 'You ended the limit of free classified ads.', 'stm_vehicles_listing' ); ?></p>
	</div>
<?php endif; ?>

<!--CAR ADD-->
<?php if ( $car_edit ) : ?>
	<?php
	if ( ! is_user_logged_in() ) {
		echo '<h4>' . esc_html__( 'Please login.', 'stm_vehicles_listing' ) . '</h4>';

		return false;
	}

	if ( ! empty( apply_filters( 'stm_listings_input', null, 'item_id' ) ) ) {
		$item_id  = apply_filters( 'stm_listings_input', null, 'item_id' );
		$car_user = get_post_meta( $item_id, 'stm_car_user', true );

		if ( intval( $user_id ) !== intval( $car_user ) ) {
			echo sprintf( '<h4>%s</h4>', esc_html__( 'You are not the owner of this car.', 'stm_vehicles_listing' ) );

			return false;
		}
	} else {
		echo sprintf( '<h4>%s</h4>', esc_html__( 'No car to edit.', 'stm_vehicles_listing' ) );

		return false;
	}

	$vars['id'] = $item_id;
endif;
?>
<div class="stm_add_car_form stm_add_car_form_<?php echo esc_attr( $car_edit ); ?> motors-alignwide">

	<form method="POST" action="" enctype="multipart/form-data" id="stm_sell_a_car_form">

		<?php if ( $car_edit ) : ?>
			<input type="hidden" value="<?php echo esc_attr( $item_id ); ?>" name="stm_current_car_id"/>
		<?php endif; ?>

		<?php
		do_action( 'stm_listings_load_template', 'add_car/desc_slots', $vars );
		do_action( 'stm_listings_load_template', 'add_car/title', $vars );

		$steps = apply_filters( 'motors_vl_get_nuxy_mod', '', 'sorted_steps' );

		if ( ! empty( $steps ) ) {
			foreach ( reset( $steps )['options'] as $step ) {
				$template = $step['id'];

				if ( 'item_features' === $template && ! empty( apply_filters( 'motors_vl_get_nuxy_mod', array(), 'fs_user_features' ) ) ) {
					$template = 'item_grouped_features';
				}

				do_action( 'stm_listings_load_template', 'add_car/' . $template, $vars );
			}
		}
		?>

	</form>

	<?php do_action( 'stm_listings_load_template', 'add_car/progress-bar', $vars ); ?>

	<?php do_action( 'stm_listings_load_template', 'add_car/check_user' ); ?>

</div>
