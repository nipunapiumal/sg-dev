<?php
/**
 * Plugin Name: Card Carousel for Elementor
 * Plugin URI: https://www.nipunapathirana.com
 * Description: Adds a "Card Carousel" widget to Elementor — a Swiper-powered carousel of media cards (image, badges, title, subtitle, description, link), styled after a product/vehicle showcase card.
 * Version: 1.7.3
 * Author: Nipuna Pathirana
 * Author URI: https://www.nipunapathirana.com
 * Text Domain: card-carousel-for-elementor
 * Requires Plugins: elementor
 * Requires at least: 5.8
 * Requires PHP: 8.0
 * Elementor tested up to: 4.2
 * Elementor Pro tested up to: 4.2
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'NPCC_VERSION', '1.7.3' );
define( 'NPCC_MIN_PHP', '8.0' );
define( 'NPCC_PATH', plugin_dir_path( __FILE__ ) );
define( 'NPCC_URL', plugin_dir_url( __FILE__ ) );

/**
 * Bail with an admin notice if Elementor isn't active, instead of fataling.
 */
function npcc_admin_notice_missing_elementor() {
	if ( ! current_user_can( 'activate_plugins' ) ) {
		return;
	}
	echo '<div class="notice notice-warning"><p>' .
		esc_html__( '"Card Carousel for Elementor" requires Elementor to be installed and active.', 'card-carousel-for-elementor' ) .
		'</p></div>';
}

/**
 * Bail with an admin notice if the site is running an unsupported PHP
 * version, instead of fataling on syntax the runtime can't parse.
 */
function npcc_admin_notice_php_version() {
	if ( ! current_user_can( 'activate_plugins' ) ) {
		return;
	}
	echo '<div class="notice notice-error"><p>' .
		sprintf(
			/* translators: 1: required PHP version, 2: current PHP version */
			esc_html__( '"Card Carousel for Elementor" requires PHP %1$s or higher. This site is running PHP %2$s.', 'card-carousel-for-elementor' ),
			esc_html( NPCC_MIN_PHP ),
			esc_html( PHP_VERSION )
		) .
		'</p></div>';
}

/**
 * Register the widget category and the widget itself once Elementor is ready.
 */
function npcc_register_category( $elements_manager ) {
	$elements_manager->add_category(
		'np-widgets',
		[
			'title' => esc_html__( 'NP Widgets', 'card-carousel-for-elementor' ),
			'icon'  => 'fa fa-plug',
		]
	);
}

function npcc_register_widgets( $widgets_manager ) {
	require_once NPCC_PATH . 'includes/widgets/class-npcc-card-carousel-widget.php';
	$widgets_manager->register( new \NPCC\Widgets\Card_Carousel_Widget() );
}

function npcc_register_assets() {
	wp_register_style(
		'npcc-card-carousel',
		NPCC_URL . 'assets/css/npcc-card-carousel.css',
		[ 'e-swiper' ],
		NPCC_VERSION
	);

	wp_register_script(
		'npcc-card-carousel',
		NPCC_URL . 'assets/js/npcc-card-carousel.js',
		[ 'elementor-frontend', 'swiper' ],
		NPCC_VERSION,
		true
	);
}

function npcc_init() {
	if ( version_compare( PHP_VERSION, NPCC_MIN_PHP, '<' ) ) {
		add_action( 'admin_notices', 'npcc_admin_notice_php_version' );
		return;
	}

	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'npcc_admin_notice_missing_elementor' );
		return;
	}

	add_action( 'elementor/elements/categories_registered', 'npcc_register_category' );
	add_action( 'elementor/widgets/register', 'npcc_register_widgets' );
	add_action( 'elementor/frontend/after_register_styles', 'npcc_register_assets' );
	add_action( 'elementor/editor/before_enqueue_scripts', 'npcc_register_assets' );
}
add_action( 'plugins_loaded', 'npcc_init' );
