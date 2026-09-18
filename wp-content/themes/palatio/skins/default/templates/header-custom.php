<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package PALATIO
 * @since PALATIO 1.0.06
 */

$palatio_header_css   = '';
$palatio_header_image = get_header_image();
$palatio_header_video = palatio_get_header_video();
if ( ! empty( $palatio_header_image ) && palatio_trx_addons_featured_image_override( is_singular() || palatio_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$palatio_header_image = palatio_get_current_mode_image( $palatio_header_image );
}

$palatio_header_id = palatio_get_custom_header_id();
$palatio_header_meta = get_post_meta( $palatio_header_id, 'trx_addons_options', true );
if ( ! empty( $palatio_header_meta['margin'] ) ) {
	palatio_add_inline_css( sprintf( '.page_content_wrap{padding-top:%s}', esc_attr( palatio_prepare_css_value( $palatio_header_meta['margin'] ) ) ) );
}

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr( $palatio_header_id ); ?> top_panel_custom_<?php echo esc_attr( sanitize_title( get_the_title( $palatio_header_id ) ) ); ?>
				<?php
				echo ! empty( $palatio_header_image ) || ! empty( $palatio_header_video )
					? ' with_bg_image'
					: ' without_bg_image';
				if ( '' != $palatio_header_video ) {
					echo ' with_bg_video';
				}
				if ( '' != $palatio_header_image ) {
					echo ' ' . esc_attr( palatio_add_inline_css_class( 'background-image: url(' . esc_url( $palatio_header_image ) . ');' ) );
				}
				if ( is_single() && has_post_thumbnail() ) {
					echo ' with_featured_image';
				}
				if ( palatio_is_on( palatio_get_theme_option( 'header_fullheight' ) ) ) {
					echo ' header_fullheight palatio-full-height';
				}
				$palatio_header_scheme = palatio_get_theme_option( 'header_scheme' );
				if ( ! empty( $palatio_header_scheme ) && ! palatio_is_inherit( $palatio_header_scheme  ) ) {
					echo ' scheme_' . esc_attr( $palatio_header_scheme );
				}
				?>
">
	<?php

	// Background video
	if ( ! empty( $palatio_header_video ) ) {
		get_template_part( apply_filters( 'palatio_filter_get_template_part', 'templates/header-video' ) );
	}

	// Custom header's layout
	do_action( 'palatio_action_show_layout', $palatio_header_id );

	// Header widgets area
	get_template_part( apply_filters( 'palatio_filter_get_template_part', 'templates/header-widgets' ) );

	?>
</header>
