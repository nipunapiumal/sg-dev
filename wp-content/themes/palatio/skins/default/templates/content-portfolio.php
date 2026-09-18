<?php
/**
 * The Portfolio template to display the content
 *
 * Used for index/archive/search.
 *
 * @package PALATIO
 * @since PALATIO 1.0
 */

$palatio_template_args = get_query_var( 'palatio_template_args' );
if ( is_array( $palatio_template_args ) ) {
	$palatio_columns    = empty( $palatio_template_args['columns'] ) ? 2 : max( 1, $palatio_template_args['columns'] );
	$palatio_blog_style = array( $palatio_template_args['type'], $palatio_columns );
    $palatio_columns_class = palatio_get_column_class( 1, $palatio_columns, ! empty( $palatio_template_args['columns_tablet']) ? $palatio_template_args['columns_tablet'] : '', ! empty($palatio_template_args['columns_mobile']) ? $palatio_template_args['columns_mobile'] : '' );
} else {
	$palatio_template_args = array();
	$palatio_blog_style = explode( '_', palatio_get_theme_option( 'blog_style' ) );
	$palatio_columns    = empty( $palatio_blog_style[1] ) ? 2 : max( 1, $palatio_blog_style[1] );
    $palatio_columns_class = palatio_get_column_class( 1, $palatio_columns );
}

$palatio_post_format = get_post_format();
$palatio_post_format = empty( $palatio_post_format ) ? 'standard' : str_replace( 'post-format-', '', $palatio_post_format );

?><div class="
<?php
if ( ! empty( $palatio_template_args['slider'] ) ) {
	echo ' slider-slide swiper-slide';
} else {
	echo ( palatio_is_blog_style_use_masonry( $palatio_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $palatio_columns ) : esc_attr( $palatio_columns_class ));
}
?>
"><article id="post-<?php the_ID(); ?>" 
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $palatio_post_format )
		. ' post_layout_portfolio'
		. ' post_layout_portfolio_' . esc_attr( $palatio_columns )
		. ( 'portfolio' != $palatio_blog_style[0] ? ' ' . esc_attr( $palatio_blog_style[0] )  . '_' . esc_attr( $palatio_columns ) : '' )
	);
	palatio_add_blog_animation( $palatio_template_args );
	?>
>
<?php

	// Sticky label
	if ( is_sticky() && ! is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	$palatio_hover   = ! empty( $palatio_template_args['hover'] ) && ! palatio_is_inherit( $palatio_template_args['hover'] )
								? $palatio_template_args['hover']
								: palatio_get_theme_option( 'image_hover' );

	if ( 'dots' == $palatio_hover ) {
		$palatio_post_link = empty( $palatio_template_args['no_links'] )
								? ( ! empty( $palatio_template_args['link'] )
									? $palatio_template_args['link']
									: get_permalink()
									)
								: '';
		$palatio_target    = ! empty( $palatio_post_link ) && palatio_is_external_url( $palatio_post_link ) && function_exists( 'palatio_external_links_target' )
								? palatio_external_links_target()
								: '';
	}
	
	// Meta parts
	$palatio_components = ! empty( $palatio_template_args['meta_parts'] )
							? ( is_array( $palatio_template_args['meta_parts'] )
								? $palatio_template_args['meta_parts']
								: explode( ',', $palatio_template_args['meta_parts'] )
								)
							: palatio_array_get_keys_by_value( palatio_get_theme_option( 'meta_parts' ) );

	// Featured image
	palatio_show_post_featured( apply_filters( 'palatio_filter_args_featured', 
        array(
			'hover'         => $palatio_hover,
			'no_links'      => ! empty( $palatio_template_args['no_links'] ),
			'thumb_size'    => ! empty( $palatio_template_args['thumb_size'] )
								? $palatio_template_args['thumb_size']
								: palatio_get_thumb_size(
									palatio_is_blog_style_use_masonry( $palatio_blog_style[0] )
										? (	strpos( palatio_get_theme_option( 'body_style' ), 'full' ) !== false || $palatio_columns < 3
											? 'masonry-big'
											: 'masonry'
											)
										: (	strpos( palatio_get_theme_option( 'body_style' ), 'full' ) !== false || $palatio_columns < 3
											? 'square'
											: 'square'
											)
								),
			'thumb_bg' => palatio_is_blog_style_use_masonry( $palatio_blog_style[0] ) ? false : true,
			'show_no_image' => true,
			'meta_parts'    => $palatio_components,
			'class'         => 'dots' == $palatio_hover ? 'hover_with_info' : '',
			'post_info'     => 'dots' == $palatio_hover
										? '<div class="post_info"><h5 class="post_title">'
											. ( ! empty( $palatio_post_link )
												? '<a href="' . esc_url( $palatio_post_link ) . '"' . ( ! empty( $target ) ? $target : '' ) . '>'
												: ''
												)
												. esc_html( get_the_title() ) 
											. ( ! empty( $palatio_post_link )
												? '</a>'
												: ''
												)
											. '</h5></div>'
										: '',
            'thumb_ratio'   => 'info' == $palatio_hover ?  '100:102' : '',
        ),
        'content-portfolio',
        $palatio_template_args
    ) );
	?>
</article></div><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!