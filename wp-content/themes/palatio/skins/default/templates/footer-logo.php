<?php
/**
 * The template to display the site logo in the footer
 *
 * @package PALATIO
 * @since PALATIO 1.0.10
 */

// Logo
if ( palatio_is_on( palatio_get_theme_option( 'logo_in_footer' ) ) ) {
	$palatio_logo_image = palatio_get_logo_image( 'footer' );
	$palatio_logo_text  = get_bloginfo( 'name' );
	if ( ! empty( $palatio_logo_image['logo'] ) || ! empty( $palatio_logo_text ) ) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if ( ! empty( $palatio_logo_image['logo'] ) ) {
					$palatio_attr = palatio_getimagesize( $palatio_logo_image['logo'] );
					echo '<a href="' . esc_url( home_url( '/' ) ) . '">'
							. '<img src="' . esc_url( $palatio_logo_image['logo'] ) . '"'
								. ( ! empty( $palatio_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $palatio_logo_image['logo_retina'] ) . ' 2x"' : '' )
								. ' class="logo_footer_image"'
								. ' alt="' . esc_attr__( 'Site logo', 'palatio' ) . '"'
								. ( ! empty( $palatio_attr[3] ) ? ' ' . wp_kses_data( $palatio_attr[3] ) : '' )
							. '>'
						. '</a>';
				} elseif ( ! empty( $palatio_logo_text ) ) {
					echo '<h1 class="logo_footer_text">'
							. '<a href="' . esc_url( home_url( '/' ) ) . '">'
								. esc_html( $palatio_logo_text )
							. '</a>'
						. '</h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
