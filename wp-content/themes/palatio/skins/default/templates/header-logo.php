<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package PALATIO
 * @since PALATIO 1.0
 */

$palatio_args = get_query_var( 'palatio_logo_args' );

// Site logo
$palatio_logo_type   = isset( $palatio_args['type'] ) ? $palatio_args['type'] : '';
$palatio_logo_image  = palatio_get_logo_image( $palatio_logo_type );
$palatio_logo_text   = palatio_is_on( palatio_get_theme_option( 'logo_text' ) ) ? get_bloginfo( 'name' ) : '';
$palatio_logo_slogan = get_bloginfo( 'description', 'display' );
if ( ! empty( $palatio_logo_image['logo'] ) || ! empty( $palatio_logo_text ) ) {
	?><a class="sc_layouts_logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php
		if ( ! empty( $palatio_logo_image['logo'] ) ) {
			if ( empty( $palatio_logo_type ) && function_exists( 'the_custom_logo' ) && is_numeric($palatio_logo_image['logo']) && (int) $palatio_logo_image['logo'] > 0 ) {
				the_custom_logo();
			} else {
				$palatio_attr = palatio_getimagesize( $palatio_logo_image['logo'] );
				echo '<img src="' . esc_url( $palatio_logo_image['logo'] ) . '"'
						. ( ! empty( $palatio_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $palatio_logo_image['logo_retina'] ) . ' 2x"' : '' )
						. ' alt="' . esc_attr( $palatio_logo_text ) . '"'
						. ( ! empty( $palatio_attr[3] ) ? ' ' . wp_kses_data( $palatio_attr[3] ) : '' )
						. '>';
			}
		} else {
			palatio_show_layout( palatio_prepare_macros( $palatio_logo_text ), '<span class="logo_text">', '</span>' );
			palatio_show_layout( palatio_prepare_macros( $palatio_logo_slogan ), '<span class="logo_slogan">', '</span>' );
		}
		?>
	</a>
	<?php
}
