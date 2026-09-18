<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package PALATIO
 * @since PALATIO 1.0.10
 */

// Copyright area
?> 
<div class="footer_copyright_wrap
<?php
$palatio_copyright_scheme = palatio_get_theme_option( 'copyright_scheme' );
if ( ! empty( $palatio_copyright_scheme ) && ! palatio_is_inherit( $palatio_copyright_scheme  ) ) {
	echo ' scheme_' . esc_attr( $palatio_copyright_scheme );
}
?>
				">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text">
			<?php
				$palatio_copyright = palatio_get_theme_option( 'copyright' );
			if ( ! empty( $palatio_copyright ) ) {
				// Replace {{Y}} or {Y} with the current year
				$palatio_copyright = str_replace( array( '{{Y}}', '{Y}' ), date( 'Y' ), $palatio_copyright );
				// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
				$palatio_copyright = palatio_prepare_macros( $palatio_copyright );
				// Display copyright
				echo wp_kses( nl2br( $palatio_copyright ), 'palatio_kses_content' );
			}
			?>
			</div>
		</div>
	</div>
</div>
