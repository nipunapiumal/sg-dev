<?php
/**
 * Plugin Name: Card Carousel for Elementor
 * Description: Adds a "Card Carousel" widget to Elementor — a Swiper-powered carousel of media cards (image, badges, title, subtitle, description, link), styled after a product/vehicle showcase card.
 * Version: 1.6.1
 * Author: Nipuna Pathirana
 * Text Domain: sg-card-carousel
 * Requires Plugins: elementor
 * Elementor tested up to: 4.2
 * Elementor Pro tested up to: 4.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'SGCC_VERSION', '1.6.1' );
define( 'SGCC_PATH', plugin_dir_path( __FILE__ ) );
define( 'SGCC_URL', plugin_dir_url( __FILE__ ) );

/**
 * Bail with an admin notice if Elementor isn't active, instead of fataling.
 */
function sgcc_admin_notice_missing_elementor() {
	if ( ! current_user_can( 'activate_plugins' ) ) {
		return;
	}
	echo '<div class="notice notice-warning"><p>' .
		esc_html__( '"Card Carousel for Elementor" requires Elementor to be installed and active.', 'sg-card-carousel' ) .
		'</p></div>';
}

/**
 * Register the widget category and the widget itself once Elementor is ready.
 */
function sgcc_register_category( $elements_manager ) {
	$elements_manager->add_category(
		'sg-widgets',
		[
			'title' => esc_html__( 'SG Widgets', 'sg-card-carousel' ),
			'icon'  => 'fa fa-plug',
		]
	);
}

function sgcc_register_widgets( $widgets_manager ) {
	require_once SGCC_PATH . 'includes/widgets/class-sgcc-card-carousel-widget.php';
	$widgets_manager->register( new \SGCC\Widgets\Card_Carousel_Widget() );
}

function sgcc_register_assets() {
	wp_register_style(
		'sgcc-card-carousel',
		SGCC_URL . 'assets/css/sgcc-card-carousel.css',
		[ 'e-swiper' ],
		SGCC_VERSION
	);

	wp_register_script(
		'sgcc-card-carousel',
		SGCC_URL . 'assets/js/sgcc-card-carousel.js',
		[ 'elementor-frontend', 'swiper' ],
		SGCC_VERSION,
		true
	);
}

function sgcc_init() {
	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'sgcc_admin_notice_missing_elementor' );
		return;
	}

	add_action( 'elementor/elements/categories_registered', 'sgcc_register_category' );
	add_action( 'elementor/widgets/register', 'sgcc_register_widgets' );
	add_action( 'elementor/frontend/after_register_styles', 'sgcc_register_assets' );
	add_action( 'elementor/editor/before_enqueue_scripts', 'sgcc_register_assets' );
}
add_action( 'plugins_loaded', 'sgcc_init' );
