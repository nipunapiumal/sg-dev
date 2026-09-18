<?php
/**
 * The template to display the socials in the footer
 *
 * @package PALATIO
 * @since PALATIO 1.0.10
 */


// Socials
if ( palatio_is_on( palatio_get_theme_option( 'socials_in_footer' ) ) ) {
	$palatio_output = palatio_get_socials_links();
	if ( '' != $palatio_output ) {
		?>
		<div class="footer_socials_wrap socials_wrap">
			<div class="footer_socials_inner">
				<?php palatio_show_layout( $palatio_output ); ?>
			</div>
		</div>
		<?php
	}
}
