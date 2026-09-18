<?php
/**
 * The template to display default site footer
 *
 * @package PALATIO
 * @since PALATIO 1.0.10
 */

$palatio_footer_id = palatio_get_custom_footer_id();
$palatio_footer_meta = get_post_meta( $palatio_footer_id, 'trx_addons_options', true );
if ( ! empty( $palatio_footer_meta['margin'] ) ) {
	palatio_add_inline_css( sprintf( '.page_content_wrap{padding-bottom:%s}', esc_attr( palatio_prepare_css_value( $palatio_footer_meta['margin'] ) ) ) );
}
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr( $palatio_footer_id ); ?> footer_custom_<?php echo esc_attr( sanitize_title( get_the_title( $palatio_footer_id ) ) ); ?>
						<?php
						$palatio_footer_scheme = palatio_get_theme_option( 'footer_scheme' );
						if ( ! empty( $palatio_footer_scheme ) && ! palatio_is_inherit( $palatio_footer_scheme  ) ) {
							echo ' scheme_' . esc_attr( $palatio_footer_scheme );
						}
						?>
						">
	<?php
	// Custom footer's layout
	do_action( 'palatio_action_show_layout', $palatio_footer_id );
	?>
</footer><!-- /.footer_wrap -->
