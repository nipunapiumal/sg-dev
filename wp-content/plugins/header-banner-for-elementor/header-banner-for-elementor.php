<?php
/**
 * Plugin Name: Header Banner for Elementor
 * Plugin URI: https://www.nipunapathirana.com
 * Description: Adds a "Header Banner" widget to Elementor — a fully customizable page-header/hero section with a static or dynamic title, background image, and full style controls.
 * Version: 1.2.0
 * Author: Nipuna Pathirana
 * Author URI: https://www.nipunapathirana.com
 * Text Domain: header-banner-for-elementor
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

define( 'NPHB_VERSION', '1.2.0' );
define( 'NPHB_MIN_PHP', '8.0' );
define( 'NPHB_PATH', plugin_dir_path( __FILE__ ) );
define( 'NPHB_URL', plugin_dir_url( __FILE__ ) );

/**
 * Bail with an admin notice if Elementor isn't active, instead of fataling.
 */
function nphb_admin_notice_missing_elementor() {
	if ( ! current_user_can( 'activate_plugins' ) ) {
		return;
	}
	echo '<div class="notice notice-warning"><p>' .
		esc_html__( '"Header Banner for Elementor" requires Elementor to be installed and active.', 'header-banner-for-elementor' ) .
		'</p></div>';
}

/**
 * Bail with an admin notice if the site is running an unsupported PHP
 * version, instead of fataling on syntax the runtime can't parse.
 */
function nphb_admin_notice_php_version() {
	if ( ! current_user_can( 'activate_plugins' ) ) {
		return;
	}
	echo '<div class="notice notice-error"><p>' .
		sprintf(
			/* translators: 1: required PHP version, 2: current PHP version */
			esc_html__( '"Header Banner for Elementor" requires PHP %1$s or higher. This site is running PHP %2$s.', 'header-banner-for-elementor' ),
			esc_html( NPHB_MIN_PHP ),
			esc_html( PHP_VERSION )
		) .
		'</p></div>';
}

/**
 * Register the widget category and the widget itself once Elementor is ready.
 */
function nphb_register_category( $elements_manager ) {
	$elements_manager->add_category(
		'np-widgets',
		[
			'title' => esc_html__( 'NP Widgets', 'header-banner-for-elementor' ),
			'icon'  => 'fa fa-plug',
		]
	);
}

function nphb_register_widgets( $widgets_manager ) {
	require_once NPHB_PATH . 'includes/widgets/class-nphb-header-banner-widget.php';
	$widgets_manager->register( new \NPHB\Widgets\Header_Banner_Widget() );
}

function nphb_register_assets() {
	wp_register_style(
		'nphb-header-banner',
		NPHB_URL . 'assets/css/nphb-header-banner.css',
		[],
		NPHB_VERSION
	);
}

function nphb_init() {
	if ( version_compare( PHP_VERSION, NPHB_MIN_PHP, '<' ) ) {
		add_action( 'admin_notices', 'nphb_admin_notice_php_version' );
		return;
	}

	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'nphb_admin_notice_missing_elementor' );
		return;
	}

	add_action( 'elementor/elements/categories_registered', 'nphb_register_category' );
	add_action( 'elementor/widgets/register', 'nphb_register_widgets' );
	add_action( 'elementor/frontend/after_register_styles', 'nphb_register_assets' );
	add_action( 'elementor/editor/before_enqueue_scripts', 'nphb_register_assets' );
}
add_action( 'plugins_loaded', 'nphb_init' );
