<?php get_header(); ?>
<?php
if ( class_exists( 'Elementor\Plugin' ) && class_exists( 'MotorsVehiclesListing\Features\Elementor\Nuxy\TemplateManager' ) ) :
	\MotorsVehiclesListing\Features\Elementor\Nuxy\TemplateManager::motors_display_template();
else :

	get_header();
	?>
<div class="stm_single_car_wrapper">
	<div class="stm_single_car_row">
		<div class="stm_single_car_side">
			<div class="stm-single-car-side">

				<!--User info-->
				<?php do_action( 'stm_listings_load_template', 'single-car/car-user', array( 'post_id' => get_the_ID() ) ); ?>

				<!--Prices-->
				<?php do_action( 'stm_listings_load_template', 'single-car/car-price' ); ?>

				<!--Buttons-->
				<?php do_action( 'stm_listings_load_template', 'single-car/car-buttons' ); ?>

				<!--Data-->
				<?php do_action( 'stm_listings_load_template', 'single-car/car-data' ); ?>


				<!--CarGuru-->
				<?php do_action( 'stm_listings_load_template', 'single-car/car-gurus' ); ?>

				<!--MPG-->
				<?php do_action( 'stm_listings_load_template', 'single-car/car-mpg' ); ?>

				<!--Similar cars-->
				<?php do_action( 'stm_listings_load_template', 'single-car/car-similar' ); ?>
			</div>
		</div>
		<div class="stm_single_car_content">
			<h2 class="title">
				<?php
				$as_label = apply_filters( 'motors_vl_get_nuxy_mod', false, 'show_generated_title_as_label' );
				echo wp_kses_post( apply_filters( 'stm_generate_title_from_slugs', get_the_title( get_the_ID() ), get_the_ID(), $as_label ) );
				?>
			</h2>

			<!--Actions-->
			<?php do_action( 'stm_listings_load_template', 'single-car/car-actions' ); ?>

			<!--Gallery-->
			<?php do_action( 'stm_listings_load_template', 'single-car/car-gallery' ); ?>

			<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					the_content();
				endwhile;
			endif;

			/*Seller notes*/
			do_action( 'stm_listings_load_template', 'single-car/car-seller-notes' );

			/* Features */
			do_action( 'stm_listings_load_template', 'single-car/car-features' );
			?>

			<!--Calculator-->
			<?php do_action( 'stm_listings_load_template', 'single-car/car-calculator' ); ?>
		</div>
	</div>
	<?php do_action( 'stm_listings_load_template', '/single-car/search-results/search-results-carousel' ); ?>
</div>
<?php endif; ?>
<?php get_footer(); ?>
