<?php
/**
 * The template to display default site footer
 *
 * @package PALATIO
 * @since PALATIO 1.0.10
 */

?>
<footer class="footer_wrap footer_default
<?php
$palatio_footer_scheme = palatio_get_theme_option( 'footer_scheme' );
if ( ! empty( $palatio_footer_scheme ) && ! palatio_is_inherit( $palatio_footer_scheme  ) ) {
	echo ' scheme_' . esc_attr( $palatio_footer_scheme );
}
?>
				">
	<?php

	// Footer widgets area
	get_template_part( apply_filters( 'palatio_filter_get_template_part', 'templates/footer-widgets' ) );

	// Logo
	get_template_part( apply_filters( 'palatio_filter_get_template_part', 'templates/footer-logo' ) );

	// Socials
	get_template_part( apply_filters( 'palatio_filter_get_template_part', 'templates/footer-socials' ) );

	// Copyright area
	get_template_part( apply_filters( 'palatio_filter_get_template_part', 'templates/footer-copyright' ) );

	?>
</footer><!-- /.footer_wrap -->
