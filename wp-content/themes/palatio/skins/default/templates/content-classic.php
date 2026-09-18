<?php
/**
 * The Classic template to display the content
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
$palatio_expanded   = ! palatio_sidebar_present() && palatio_get_theme_option( 'expand_content' ) == 'expand';

$palatio_post_format = get_post_format();
$palatio_post_format = empty( $palatio_post_format ) ? 'standard' : str_replace( 'post-format-', '', $palatio_post_format );

?><div class="<?php
	if ( ! empty( $palatio_template_args['slider'] ) ) {
		echo ' slider-slide swiper-slide';
	} else {
		echo ( palatio_is_blog_style_use_masonry( $palatio_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $palatio_columns ) : esc_attr( $palatio_columns_class ) );
	}
?>"><article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $palatio_post_format )
				. ' post_layout_classic post_layout_classic_' . esc_attr( $palatio_columns )
				. ' post_layout_' . esc_attr( $palatio_blog_style[0] )
				. ' post_layout_' . esc_attr( $palatio_blog_style[0] ) . '_' . esc_attr( $palatio_columns )
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

	// Featured image
	$palatio_hover      = ! empty( $palatio_template_args['hover'] ) && ! palatio_is_inherit( $palatio_template_args['hover'] )
							? $palatio_template_args['hover']
							: palatio_get_theme_option( 'image_hover' );

	$palatio_components = ! empty( $palatio_template_args['meta_parts'] )
							? ( is_array( $palatio_template_args['meta_parts'] )
								? $palatio_template_args['meta_parts']
								: explode( ',', $palatio_template_args['meta_parts'] )
								)
							: palatio_array_get_keys_by_value( palatio_get_theme_option( 'meta_parts' ) );

	palatio_show_post_featured( apply_filters( 'palatio_filter_args_featured',
		array(
			'thumb_size' => ! empty( $palatio_template_args['thumb_size'] )
				? $palatio_template_args['thumb_size']
				: palatio_get_thumb_size(
					'classic' == $palatio_blog_style[0]
						? ( strpos( palatio_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $palatio_columns > 2 ? 'big' : 'huge' )
								: ( $palatio_columns > 2
									? ( $palatio_expanded ? 'square' : 'square' )
									: ($palatio_columns > 1 ? 'square' : ( $palatio_expanded ? 'huge' : 'big' ))
									)
							)
						: ( strpos( palatio_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $palatio_columns > 2 ? 'masonry-big' : 'full' )
								: ($palatio_columns === 1 ? ( $palatio_expanded ? 'huge' : 'big' ) : ( $palatio_columns <= 2 && $palatio_expanded ? 'masonry-big' : 'masonry' ))
							)
			),
			'hover'      => $palatio_hover,
			'meta_parts' => $palatio_components,
			'no_links'   => ! empty( $palatio_template_args['no_links'] ),
        ),
        'content-classic',
        $palatio_template_args
    ) );

	// Title and post meta
	$palatio_show_title = get_the_title() != '';
	$palatio_show_meta  = count( $palatio_components ) > 0 && ! in_array( $palatio_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );

	if ( $palatio_show_title ) {
		?>
		<div class="post_header entry-header">
			<?php

			// Post meta
			if ( apply_filters( 'palatio_filter_show_blog_meta', $palatio_show_meta, $palatio_components, 'classic' ) ) {
				if ( count( $palatio_components ) > 0 ) {
					do_action( 'palatio_action_before_post_meta' );
					palatio_show_post_meta(
						apply_filters(
							'palatio_filter_post_meta_args', array(
							'components' => join( ',', $palatio_components ),
							'seo'        => false,
							'echo'       => true,
						), $palatio_blog_style[0], $palatio_columns
						)
					);
					do_action( 'palatio_action_after_post_meta' );
				}
			}

			// Post title
			if ( apply_filters( 'palatio_filter_show_blog_title', true, 'classic' ) ) {
				do_action( 'palatio_action_before_post_title' );
				if ( empty( $palatio_template_args['no_links'] ) ) {
					the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
				} else {
					the_title( '<h4 class="post_title entry-title">', '</h4>' );
				}
				do_action( 'palatio_action_after_post_title' );
			}

			if( !in_array( $palatio_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
				// More button
				if ( apply_filters( 'palatio_filter_show_blog_readmore', ! $palatio_show_title || ! empty( $palatio_template_args['more_button'] ), 'classic' ) ) {
					if ( empty( $palatio_template_args['no_links'] ) ) {
						do_action( 'palatio_action_before_post_readmore' );
						palatio_show_post_more_link( $palatio_template_args, '<div class="more-wrap">', '</div>' );
						do_action( 'palatio_action_after_post_readmore' );
					}
				}
			}
			?>
		</div><!-- .entry-header -->
		<?php
	}

	// Post content
	if( in_array( $palatio_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
		ob_start();
		if (apply_filters('palatio_filter_show_blog_excerpt', empty($palatio_template_args['hide_excerpt']) && palatio_get_theme_option('excerpt_length') > 0, 'classic')) {
			palatio_show_post_content($palatio_template_args, '<div class="post_content_inner">', '</div>');
		}
		// More button
		if(! empty( $palatio_template_args['more_button'] )) {
			if ( empty( $palatio_template_args['no_links'] ) ) {
				do_action( 'palatio_action_before_post_readmore' );
				palatio_show_post_more_link( $palatio_template_args, '<div class="more-wrap">', '</div>' );
				do_action( 'palatio_action_after_post_readmore' );
			}
		}
		$palatio_content = ob_get_contents();
		ob_end_clean();
		palatio_show_layout($palatio_content, '<div class="post_content entry-content">', '</div><!-- .entry-content -->');
	}
	?>

</article></div><?php
// Need opening PHP-tag above, because <div> is a inline-block element (used as column)!
