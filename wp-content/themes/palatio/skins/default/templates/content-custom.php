<?php
/**
 * The custom template to display the content
 *
 * Used for index/archive/search.
 *
 * @package PALATIO
 * @since PALATIO 1.0.50
 */

$palatio_template_args = get_query_var( 'palatio_template_args' );
if ( is_array( $palatio_template_args ) ) {
	$palatio_columns    = empty( $palatio_template_args['columns'] ) ? 2 : max( 1, $palatio_template_args['columns'] );
	$palatio_blog_style = array( $palatio_template_args['type'], $palatio_columns );
} else {
	$palatio_template_args = array();
	$palatio_blog_style = explode( '_', palatio_get_theme_option( 'blog_style' ) );
	$palatio_columns    = empty( $palatio_blog_style[1] ) ? 2 : max( 1, $palatio_blog_style[1] );
}
$palatio_blog_id       = palatio_get_custom_blog_id( join( '_', $palatio_blog_style ) );
$palatio_blog_style[0] = str_replace( 'blog-custom-', '', $palatio_blog_style[0] );
$palatio_expanded      = ! palatio_sidebar_present() && palatio_get_theme_option( 'expand_content' ) == 'expand';
$palatio_components    = ! empty( $palatio_template_args['meta_parts'] )
							? ( is_array( $palatio_template_args['meta_parts'] )
								? join( ',', $palatio_template_args['meta_parts'] )
								: $palatio_template_args['meta_parts']
								)
							: palatio_array_get_keys_by_value( palatio_get_theme_option( 'meta_parts' ) );
$palatio_post_format   = get_post_format();
$palatio_post_format   = empty( $palatio_post_format ) ? 'standard' : str_replace( 'post-format-', '', $palatio_post_format );

$palatio_blog_meta     = palatio_get_custom_layout_meta( $palatio_blog_id );
$palatio_custom_style  = ! empty( $palatio_blog_meta['scripts_required'] ) ? $palatio_blog_meta['scripts_required'] : 'none';

if ( ! empty( $palatio_template_args['slider'] ) || $palatio_columns > 1 || ! palatio_is_off( $palatio_custom_style ) ) {
	?><div class="
		<?php
		if ( ! empty( $palatio_template_args['slider'] ) ) {
			echo 'slider-slide swiper-slide';
		} else {
			echo esc_attr( ( palatio_is_off( $palatio_custom_style ) ? 'column' : sprintf( '%1$s_item %1$s_item', $palatio_custom_style ) ) . "-1_{$palatio_columns}" );
		}
		?>
	">
	<?php
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
			'post_item post_item_container post_format_' . esc_attr( $palatio_post_format )
					. ' post_layout_custom post_layout_custom_' . esc_attr( $palatio_columns )
					. ' post_layout_' . esc_attr( $palatio_blog_style[0] )
					. ' post_layout_' . esc_attr( $palatio_blog_style[0] ) . '_' . esc_attr( $palatio_columns )
					. ( ! palatio_is_off( $palatio_custom_style )
						? ' post_layout_' . esc_attr( $palatio_custom_style )
							. ' post_layout_' . esc_attr( $palatio_custom_style ) . '_' . esc_attr( $palatio_columns )
						: ''
						)
		);
	palatio_add_blog_animation( $palatio_template_args );
	?>
>
	<?php
	// Sticky label
	if ( is_sticky() && ! is_paged() ) {
		?>
		<span class="post_label label_sticky"></span>
		<?php
	}
	// Custom layout
	do_action( 'palatio_action_show_layout', $palatio_blog_id, get_the_ID() );
	?>
</article><?php
if ( ! empty( $palatio_template_args['slider'] ) || $palatio_columns > 1 || ! palatio_is_off( $palatio_custom_style ) ) {
	?></div><?php
	// Need opening PHP-tag above just after </div>, because <div> is a inline-block element (used as column)!
}
