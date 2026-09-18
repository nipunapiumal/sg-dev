<?php
/* Wp Booking System support functions
------------------------------------------------------------------------------- */

// Add Wp Booking System to required plugins list
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'palatio_booking_system_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'palatio_booking_system_theme_setup9', 9 );
	function palatio_booking_system_theme_setup9() {
		if ( palatio_exists_wp_booking_system() ) {
			add_action( 'wp_enqueue_scripts', 'palatio_booking_system_frontend_scripts', 1100 );
			add_action( 'wp_enqueue_scripts', 'palatio_booking_system_responsive_styles', 2000 );
			add_filter( 'palatio_filter_merge_styles', 'palatio_booking_system_merge_styles' );
			add_filter( 'palatio_filter_merge_styles_responsive', 'palatio_booking_system_merge_styles_responsive' );
		}
		if ( is_admin() ) {
			add_filter( 'palatio_filter_tgmpa_required_plugins', 'palatio_booking_system_tgmpa_required_plugins' );
		}
	}
}


// Filter to add in the required plugins list
if ( ! function_exists( 'palatio_booking_system_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('palatio_filter_tgmpa_required_plugins',	'palatio_booking_system_tgmpa_required_plugins');
	function palatio_booking_system_tgmpa_required_plugins( $list = array() ) {
		if ( palatio_storage_isset( 'required_plugins', 'wp-booking-system' ) && palatio_storage_get_array( 'required_plugins', 'wp-booking-system', 'install' ) !== false ) {
			$list[] = array(
				'name'     => palatio_storage_get_array( 'required_plugins', 'wp-booking-system', 'title' ),
				'slug'     => 'wp-booking-system',
				'required' => false,
			);
		}
		
		return $list;
	}
}

// Check if plugin installed and activated
if ( ! function_exists( 'palatio_exists_wp_booking_system' ) ) {
	function palatio_exists_wp_booking_system() {
		return class_exists( 'WPBS_PluginInfo' );
	}
}

// Enqueue styles for frontend
if ( ! function_exists( 'palatio_booking_system_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'palatio_booking_system_frontend_scripts', 1100 );
	function palatio_booking_system_frontend_scripts() {
		if ( palatio_is_on( palatio_get_theme_option( 'debug_mode' ) ) ) {
			$palatio_url = palatio_get_file_url( 'plugins/wp-booking-system/wp-booking-system.css' );
			if ( '' != $palatio_url ) {
				wp_enqueue_style( 'palatio-wp-booking-system', $palatio_url, array(), null );
			}
		}
	}
}
// Enqueue responsive styles for frontend
if ( ! function_exists( 'palatio_booking_system_responsive_styles' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'palatio_booking_system_responsive_styles', 2000 );
	function palatio_booking_system_responsive_styles() {
		if ( palatio_is_on( palatio_get_theme_option( 'debug_mode' ) ) ) {
			$palatio_url = palatio_get_file_url( 'plugins/wp-booking-system/wp-booking-system-responsive.css' );
			if ( '' != $palatio_url ) {
				wp_enqueue_style( 'palatio-wp-booking-system-responsive', $palatio_url, array(), null, palatio_media_for_load_css_responsive( 'wp-booking-system' ) );
			}
		}
	}
}
// Merge custom styles
if ( ! function_exists( 'palatio_booking_system_merge_styles' ) ) {
	//Handler of the add_filter('palatio_filter_merge_styles', 'palatio_booking_system_merge_styles');
	function palatio_booking_system_merge_styles( $list ) {
		$list['plugins/wp-booking-system/wp-booking-system.css'] = true;
		
		return $list;
	}
}
// Merge responsive styles
if ( ! function_exists( 'palatio_booking_system_merge_styles_responsive' ) ) {
	//Handler of the add_filter('palatio_filter_merge_styles_responsive', 'palatio_booking_system_merge_styles_responsive');
	function palatio_booking_system_merge_styles_responsive( $list ) {
		$list['plugins/wp-booking-system/wp-booking-system-responsive.css'] = true;
		
		return $list;
	}
}


// One-click import support
//------------------------------------------------------------------------
if ( ! function_exists( 'palatio_wp_booking_system_importer_required_plugins' ) ) {
	add_filter( 'trx_addons_filter_importer_required_plugins', 'palatio_wp_booking_system_importer_required_plugins', 10, 2 );
	function palatio_wp_booking_system_importer_required_plugins( $not_installed = '', $list = '' ) {
		if ( strpos( $list, 'wp-booking-system' ) !== false && ! palatio_exists_wp_booking_system() ) {
			$not_installed .= '<br>' . esc_html__( 'WP Booking System', 'palatio' );
		}
		
		return $not_installed;
	}
}

// // Set plugin's specific importer options
if ( ! function_exists( 'palatio_wp_booking_system_importer_set_options' ) ) {
	add_filter( 'trx_addons_filter_importer_options', 'palatio_wp_booking_system_importer_set_options' );
	function palatio_wp_booking_system_importer_set_options( $options = array() ) {
		if ( palatio_exists_wp_booking_system() && in_array( 'wp-booking-system', $options['required_plugins'] ) ) {
			$options['additional_options'][] = 'wpbs_%';        // Add slugs to export options for this plugin
			if ( is_array( $options['files'] ) && count( $options['files'] ) > 0 ) {
				foreach ( $options['files'] as $k => $v ) {
					$options['files'][ $k ]['file_with_wp-booking-system'] = str_replace( 'name.ext', 'wp-booking-system.txt', $v['file_with_'] );
					
				}
			}
		}
		
		return $options;
	}
}

// Prevent import plugin's specific options if plugin is not installed
if ( ! function_exists( 'palatio_wp_booking_system_importer_check_options' ) ) {
	add_filter( 'trx_addons_filter_import_theme_options', 'palatio_wp_booking_system_importer_check_options', 10, 4 );
	function palatio_wp_booking_system_importer_check_options( $allow, $k, $v, $options ) {
		if ( $allow && $k == 'wpbs_' ) {
			$allow = palatio_exists_wp_booking_system() && in_array( 'wp-booking-system', $options['required_plugins'] );
		}
		
		return $allow;
	}
}

// Add checkbox to the one-click importer
if ( ! function_exists( 'palatio_wp_booking_system_importer_show_params' ) ) {
	add_action( 'trx_addons_action_importer_params', 'palatio_wp_booking_system_importer_show_params', 10, 1 );
	function palatio_wp_booking_system_importer_show_params( $importer ) {
		if ( palatio_exists_wp_booking_system() && in_array( 'wp-booking-system', $importer->options['required_plugins'] ) ) {
			$importer->show_importer_params( array(
				'slug'  => 'wp-booking-system',
				'title' => esc_html__( 'Import WP Booking System', 'palatio' ),
				'part'  => 1
			) );
		}
	}
}

// Import posts
if ( ! function_exists( 'palatio_wp_booking_system_importer_import' ) ) {
	add_action( 'trx_addons_action_importer_import', 'palatio_wp_booking_system_importer_import', 10, 2 );
	function palatio_wp_booking_system_importer_import( $importer, $action ) {
		if ( palatio_exists_wp_booking_system() && in_array( 'wp-booking-system', $importer->options['required_plugins'] ) ) {
			if ( $action == 'import_wp-booking-system' ) {
				$importer->response['start_from_id'] = 0;
				$importer->import_dump( 'wp-booking-system', esc_html__( 'WP Booking System', 'palatio' ) );
			}
		}
	}
}

// Display import progress
if ( ! function_exists( 'palatio_wp_booking_system_importer_import_fields' ) ) {
	add_action( 'trx_addons_action_importer_import_fields', 'palatio_wp_booking_system_importer_import_fields', 10, 1 );
	function palatio_wp_booking_system_importer_import_fields( $importer ) {
		if ( palatio_exists_wp_booking_system() && in_array( 'wp-booking-system', $importer->options['required_plugins'] ) ) {
			$importer->show_importer_fields( array(
				'slug'  => 'wp-booking-system',
				'title' => esc_html__( 'WP Booking System', 'palatio' )
			) );
		}
	}
}

//Export posts
if ( ! function_exists( 'palatio_wp_booking_system_importer_export' ) ) {
	add_action( 'trx_addons_action_importer_export', 'palatio_wp_booking_system_importer_export', 10, 1 );
	function palatio_wp_booking_system_importer_export( $importer ) {
		if ( palatio_exists_wp_booking_system() && in_array( 'wp-booking-system', $importer->options['required_plugins'] ) ) {
			palatio_fpc( $importer->export_file_dir( 'wp-booking-system.txt' ), serialize( array(
				"wpbs_calendars"        => $importer->export_dump( "wpbs_calendars" ),
				"wpbs_calendar_meta"    => $importer->export_dump( "wpbs_calendar_meta" ),
				"wpbs_events"           => $importer->export_dump( "wpbs_events" ),
				"wpbs_event_meta"       => $importer->export_dump( "wpbs_event_meta" ),
				"wpbs_forms"            => $importer->export_dump( "wpbs_forms" ),
				"wpbs_form_meta"        => $importer->export_dump( "wpbs_form_meta" ),
				"wpbs_legend_items"     => $importer->export_dump( "wpbs_legend_items" ),
				"wpbs_legend_item_meta" => $importer->export_dump( "wpbs_legend_item_meta" )
			) ) );
		}
	}
}

// Display exported data in the fields
if ( ! function_exists( 'palatio_wp_booking_system_importer_export_fields' ) ) {
	add_action( 'trx_addons_action_importer_export_fields', 'palatio_wp_booking_system_importer_export_fields', 10, 1 );
	function palatio_wp_booking_system_importer_export_fields( $importer ) {
		if ( palatio_exists_wp_booking_system() && in_array( 'wp-booking-system', $importer->options['required_plugins'] ) ) {
			$importer->show_exporter_fields( array(
				'slug'  => 'wp-booking-system',
				'title' => esc_html__( 'WP Booking System', 'palatio' )
			) );
		}
	}
}