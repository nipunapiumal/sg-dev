<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package PALATIO
 * @since PALATIO 1.0
 */

if ( palatio_sidebar_present() ) {
	
	$palatio_sidebar_type = palatio_get_theme_option( 'sidebar_type' );
	if ( 'custom' == $palatio_sidebar_type && ! palatio_is_layouts_available() ) {
		$palatio_sidebar_type = 'default';
	}
	
	// Catch output to the buffer
	ob_start();
	if ( 'default' == $palatio_sidebar_type ) {
		// Default sidebar with widgets
		$palatio_sidebar_name = palatio_get_theme_option( 'sidebar_widgets' );
		palatio_storage_set( 'current_sidebar', 'sidebar' );
		if ( is_active_sidebar( $palatio_sidebar_name ) ) {
			dynamic_sidebar( $palatio_sidebar_name );
		}
	} else {
		// Custom sidebar from Layouts Builder
		$palatio_sidebar_id = palatio_get_custom_sidebar_id();
		do_action( 'palatio_action_show_layout', $palatio_sidebar_id );
	}
	$palatio_out = trim( ob_get_contents() );
	ob_end_clean();
	
	// If any html is present - display it
	if ( ! empty( $palatio_out ) ) {
		$palatio_sidebar_position    = palatio_get_theme_option( 'sidebar_position' );
		$palatio_sidebar_position_ss = palatio_get_theme_option( 'sidebar_position_ss', 'below' );
		?>
		<div class="sidebar widget_area
			<?php
			echo ' ' . esc_attr( $palatio_sidebar_position );
			echo ' sidebar_' . esc_attr( $palatio_sidebar_position_ss );
			echo ' sidebar_' . esc_attr( $palatio_sidebar_type );

			$palatio_sidebar_scheme = apply_filters( 'palatio_filter_sidebar_scheme', palatio_get_theme_option( 'sidebar_scheme', 'inherit' ) );
			if ( ! empty( $palatio_sidebar_scheme ) && ! palatio_is_inherit( $palatio_sidebar_scheme ) && 'custom' != $palatio_sidebar_type ) {
				echo ' scheme_' . esc_attr( $palatio_sidebar_scheme );
			}
			?>
		" role="complementary">
			<?php

			// Skip link anchor to fast access to the sidebar from keyboard
			?>
			<span id="sidebar_skip_link_anchor" class="palatio_skip_link_anchor"></span>
			<?php

			do_action( 'palatio_action_before_sidebar_wrap', 'sidebar' );

			// Button to show/hide sidebar on mobile
			if ( in_array( $palatio_sidebar_position_ss, array( 'above', 'float' ) ) ) {
				$palatio_title = apply_filters( 'palatio_filter_sidebar_control_title', 'float' == $palatio_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'palatio' ) : '' );
				$palatio_text  = apply_filters( 'palatio_filter_sidebar_control_text', 'above' == $palatio_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'palatio' ) : '' );
				?>
				<a href="#" role="button" class="sidebar_control" title="<?php echo esc_attr( $palatio_title ); ?>"><?php echo esc_html( $palatio_text ); ?></a>
				<?php
			}
			?>
			<div class="sidebar_inner">
				<?php
				do_action( 'palatio_action_before_sidebar', 'sidebar' );
				palatio_show_layout( preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $palatio_out ) );
				do_action( 'palatio_action_after_sidebar', 'sidebar' );
				?>
			</div>
			<?php

			do_action( 'palatio_action_after_sidebar_wrap', 'sidebar' );

			?>
		</div>
		<div class="clearfix"></div>
		<?php
	}
}
