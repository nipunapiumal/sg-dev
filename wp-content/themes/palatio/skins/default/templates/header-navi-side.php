<?php
/**
 * The template to display the side menu
 *
 * @package PALATIO
 * @since PALATIO 1.0
 */
?>
<div class="menu_side_wrap
<?php
echo ' menu_side_' . esc_attr( palatio_get_theme_option( 'menu_side_icons' ) > 0 ? 'icons' : 'dots' );
$palatio_menu_scheme = palatio_get_theme_option( 'menu_scheme' );
$palatio_header_scheme = palatio_get_theme_option( 'header_scheme' );
if ( ! empty( $palatio_menu_scheme ) && ! palatio_is_inherit( $palatio_menu_scheme  ) ) {
	echo ' scheme_' . esc_attr( $palatio_menu_scheme );
} elseif ( ! empty( $palatio_header_scheme ) && ! palatio_is_inherit( $palatio_header_scheme ) ) {
	echo ' scheme_' . esc_attr( $palatio_header_scheme );
}
?>
				">
	<span class="menu_side_button icon-menu-2"></span>

	<div class="menu_side_inner">
		<?php
		// Logo
		set_query_var( 'palatio_logo_args', array( 'type' => 'side' ) );
		get_template_part( apply_filters( 'palatio_filter_get_template_part', 'templates/header-logo' ) );
		set_query_var( 'palatio_logo_args', array() );
		// Main menu button
		?>
		<div class="toc_menu_item"
			<?php
			if ( palatio_mouse_helper_enabled() ) {
				echo ' data-mouse-helper="click" data-mouse-helper-axis="y" data-mouse-helper-text="' . esc_attr__( 'Open main menu', 'palatio' ) . '"';
			}
			?>
		>
			<a href="#" role="button" class="toc_menu_description menu_mobile_description"><span class="toc_menu_description_title"><?php esc_html_e( 'Main menu', 'palatio' ); ?></span></a>
			<a class="menu_mobile_button toc_menu_icon icon-menu-2" href="#" role="button"></a>
		</div>		
	</div>

</div>