<?php
/**
 * Plugin Name: Single Card Designs for Elementor
 * Plugin URI: https://www.nipunapathirana.com
 * Description: Adds a "Single Card" widget to Elementor — a product/content showcase card with two selectable templates, fully customizable text, fonts, image, height, and button styling.
 * Version: 1.1.0
 * Author: Nipuna Pathirana
 * Author URI: https://www.nipunapathirana.com
 * Text Domain: single-card-designs-for-elementor
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

define( 'NPSC_VERSION', '1.1.0' );
define( 'NPSC_MIN_PHP', '8.0' );
define( 'NPSC_PATH', plugin_dir_path( __FILE__ ) );
define( 'NPSC_URL', plugin_dir_url( __FILE__ ) );

/**
 * Bail with an admin notice if Elementor isn't active, instead of fataling.
 */
function npsc_admin_notice_missing_elementor() {
	if ( ! current_user_can( 'activate_plugins' ) ) {
		return;
	}
	echo '<div class="notice notice-warning"><p>' .
		esc_html__( '"Single Card Designs for Elementor" requires Elementor to be installed and active.', 'single-card-designs-for-elementor' ) .
		'</p></div>';
}

/**
 * Bail with an admin notice if the site is running an unsupported PHP
 * version, instead of fataling on syntax the runtime can't parse.
 */
function npsc_admin_notice_php_version() {
	if ( ! current_user_can( 'activate_plugins' ) ) {
		return;
	}
	echo '<div class="notice notice-error"><p>' .
		sprintf(
			/* translators: 1: required PHP version, 2: current PHP version */
			esc_html__( '"Single Card Designs for Elementor" requires PHP %1$s or higher. This site is running PHP %2$s.', 'single-card-designs-for-elementor' ),
			esc_html( NPSC_MIN_PHP ),
			esc_html( PHP_VERSION )
		) .
		'</p></div>';
}

/**
 * Register the widget category and the widget itself once Elementor is ready.
 */
function npsc_register_category( $elements_manager ) {
	$elements_manager->add_category(
		'np-widgets',
		[
			'title' => esc_html__( 'NP Widgets', 'single-card-designs-for-elementor' ),
			'icon'  => 'fa fa-plug',
		]
	);
}

function npsc_register_widgets( $widgets_manager ) {
	require_once NPSC_PATH . 'includes/widgets/class-npsc-single-card-widget.php';
	$widgets_manager->register( new \NPSC\Widgets\Single_Card_Widget() );
}

function npsc_register_assets() {
	wp_register_style(
		'npsc-single-card',
		NPSC_URL . 'assets/css/npsc-single-card.css',
		[],
		NPSC_VERSION
	);
}

function npsc_init() {
	if ( version_compare( PHP_VERSION, NPSC_MIN_PHP, '<' ) ) {
		add_action( 'admin_notices', 'npsc_admin_notice_php_version' );
		return;
	}

	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'npsc_admin_notice_missing_elementor' );
		return;
	}

	add_action( 'elementor/elements/categories_registered', 'npsc_register_category' );
	add_action( 'elementor/widgets/register', 'npsc_register_widgets' );
	add_action( 'elementor/frontend/after_register_styles', 'npsc_register_assets' );
	add_action( 'elementor/editor/before_enqueue_scripts', 'npsc_register_assets' );
}
add_action( 'plugins_loaded', 'npsc_init' );
