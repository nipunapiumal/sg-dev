<?php
/**
 * The template to display the widgets area in the header
 *
 * @package PALATIO
 * @since PALATIO 1.0
 */

// Header sidebar
$palatio_header_name    = palatio_get_theme_option( 'header_widgets' );
$palatio_header_present = ! palatio_is_off( $palatio_header_name ) && is_active_sidebar( $palatio_header_name );
if ( $palatio_header_present ) {
	palatio_storage_set( 'current_sidebar', 'header' );
	$palatio_header_wide = palatio_get_theme_option( 'header_wide' );
	ob_start();
	if ( is_active_sidebar( $palatio_header_name ) ) {
		dynamic_sidebar( $palatio_header_name );
	}
	$palatio_widgets_output = ob_get_contents();
	ob_end_clean();
	if ( ! empty( $palatio_widgets_output ) ) {
		$palatio_widgets_output = preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $palatio_widgets_output );
		$palatio_need_columns   = strpos( $palatio_widgets_output, 'columns_wrap' ) === false;
		if ( $palatio_need_columns ) {
			$palatio_columns = max( 0, (int) palatio_get_theme_option( 'header_columns' ) );
			if ( 0 == $palatio_columns ) {
				$palatio_columns = min( 6, max( 1, palatio_tags_count( $palatio_widgets_output, 'aside' ) ) );
			}
			if ( $palatio_columns > 1 ) {
				$palatio_widgets_output = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $palatio_columns ) . ' widget', $palatio_widgets_output );
			} else {
				$palatio_need_columns = false;
			}
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo ! empty( $palatio_header_wide ) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<?php do_action( 'palatio_action_before_sidebar_wrap', 'header' ); ?>
			<div class="header_widgets_inner widget_area_inner">
				<?php
				if ( ! $palatio_header_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $palatio_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'palatio_action_before_sidebar', 'header' );
				palatio_show_layout( $palatio_widgets_output );
				do_action( 'palatio_action_after_sidebar', 'header' );
				if ( $palatio_need_columns ) {
					?>
					</div>	<!-- /.columns_wrap -->
					<?php
				}
				if ( ! $palatio_header_wide ) {
					?>
					</div>	<!-- /.content_wrap -->
					<?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
			<?php do_action( 'palatio_action_after_sidebar_wrap', 'header' ); ?>
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
