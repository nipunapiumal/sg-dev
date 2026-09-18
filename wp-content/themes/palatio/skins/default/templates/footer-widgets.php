<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package PALATIO
 * @since PALATIO 1.0.10
 */

// Footer sidebar
$palatio_footer_name    = palatio_get_theme_option( 'footer_widgets' );
$palatio_footer_present = ! palatio_is_off( $palatio_footer_name ) && is_active_sidebar( $palatio_footer_name );
if ( $palatio_footer_present ) {
	palatio_storage_set( 'current_sidebar', 'footer' );
	$palatio_footer_wide = palatio_get_theme_option( 'footer_wide' );
	ob_start();
	if ( is_active_sidebar( $palatio_footer_name ) ) {
		dynamic_sidebar( $palatio_footer_name );
	}
	$palatio_out = trim( ob_get_contents() );
	ob_end_clean();
	if ( ! empty( $palatio_out ) ) {
		$palatio_out          = preg_replace( "/<\\/aside>[\r\n\s]*<aside/", '</aside><aside', $palatio_out );
		$palatio_need_columns = true;   //or check: strpos($palatio_out, 'columns_wrap')===false;
		if ( $palatio_need_columns ) {
			$palatio_columns = max( 0, (int) palatio_get_theme_option( 'footer_columns' ) );			
			if ( 0 == $palatio_columns ) {
				$palatio_columns = min( 4, max( 1, palatio_tags_count( $palatio_out, 'aside' ) ) );
			}
			if ( $palatio_columns > 1 ) {
				$palatio_out = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $palatio_columns ) . ' widget', $palatio_out );
			} else {
				$palatio_need_columns = false;
			}
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo ! empty( $palatio_footer_wide ) ? ' footer_fullwidth' : ''; ?> sc_layouts_row sc_layouts_row_type_normal">
			<?php do_action( 'palatio_action_before_sidebar_wrap', 'footer' ); ?>
			<div class="footer_widgets_inner widget_area_inner">
				<?php
				if ( ! $palatio_footer_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $palatio_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'palatio_action_before_sidebar', 'footer' );
				palatio_show_layout( $palatio_out );
				do_action( 'palatio_action_after_sidebar', 'footer' );
				if ( $palatio_need_columns ) {
					?>
					</div><!-- /.columns_wrap -->
					<?php
				}
				if ( ! $palatio_footer_wide ) {
					?>
					</div><!-- /.content_wrap -->
					<?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
			<?php do_action( 'palatio_action_after_sidebar_wrap', 'footer' ); ?>
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
