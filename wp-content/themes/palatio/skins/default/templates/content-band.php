<?php
/**
 * 'Band' template to display the content
 *
 * Used for index/archive/search.
 *
 * @package PALATIO
 * @since PALATIO 1.71.0
 */

$palatio_template_args = get_query_var( 'palatio_template_args' );
if ( ! is_array( $palatio_template_args ) ) {
	$palatio_template_args = array(
								'type'    => 'band',
								'columns' => 1
								);
}

$palatio_columns       = 1;

$palatio_expanded      = ! palatio_sidebar_present() && palatio_get_theme_option( 'expand_content' ) == 'expand';

$palatio_post_format   = get_post_format();
$palatio_post_format   = empty( $palatio_post_format ) ? 'standard' : str_replace( 'post-format-', '', $palatio_post_format );

if ( is_array( $palatio_template_args ) ) {
	$palatio_columns    = empty( $palatio_template_args['columns'] ) ? 1 : max( 1, $palatio_template_args['columns'] );
	$palatio_blog_style = array( $palatio_template_args['type'], $palatio_columns );
	if ( ! empty( $palatio_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $palatio_columns > 1 ) {
	    $palatio_columns_class = palatio_get_column_class( 1, $palatio_columns, ! empty( $palatio_template_args['columns_tablet']) ? $palatio_template_args['columns_tablet'] : '', ! empty($palatio_template_args['columns_mobile']) ? $palatio_template_args['columns_mobile'] : '' );
				?><div class="<?php echo esc_attr( $palatio_columns_class ); ?>"><?php
	}
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_item_container post_layout_band post_format_' . esc_attr( $palatio_post_format ) );
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
								: array_map( 'trim', explode( ',', $palatio_template_args['meta_parts'] ) )
								)
							: palatio_array_get_keys_by_value( palatio_get_theme_option( 'meta_parts' ) );
	palatio_show_post_featured( apply_filters( 'palatio_filter_args_featured',
		array(
			'no_links'   => ! empty( $palatio_template_args['no_links'] ),
			'hover'      => $palatio_hover,
			'meta_parts' => $palatio_components,
			'thumb_bg'   => true,
			'thumb_ratio'   => '1:1',
			'thumb_size' => ! empty( $palatio_template_args['thumb_size'] )
								? $palatio_template_args['thumb_size']
								: palatio_get_thumb_size( 
								in_array( $palatio_post_format, array( 'gallery', 'audio', 'video' ) )
									? ( strpos( palatio_get_theme_option( 'body_style' ), 'full' ) !== false
										? 'full'
										: ( $palatio_expanded 
											? 'big' 
											: 'medium-square'
											)
										)
									: 'masonry-big'
								)
		),
		'content-band',
		$palatio_template_args
	) );

	?><div class="post_content_wrap"><?php

		// Title and post meta
		$palatio_show_title = get_the_title() != '';
		$palatio_show_meta  = count( $palatio_components ) > 0 && ! in_array( $palatio_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );
		if ( $palatio_show_title ) {
			?>
			<div class="post_header entry-header">
				<?php
				// Categories
				if ( apply_filters( 'palatio_filter_show_blog_categories', $palatio_show_meta && in_array( 'categories', $palatio_components ), array( 'categories' ), 'band' ) ) {
					do_action( 'palatio_action_before_post_category' );
					?>
					<div class="post_category">
						<?php
						palatio_show_post_meta( apply_filters(
															'palatio_filter_post_meta_args',
															array(
																'components' => 'categories',
																'seo'        => false,
																'echo'       => true,
																'cat_sep'    => false,
																),
															'hover_' . $palatio_hover, 1
															)
											);
						?>
					</div>
					<?php
					$palatio_components = palatio_array_delete_by_value( $palatio_components, 'categories' );
					do_action( 'palatio_action_after_post_category' );
				}
				// Post title
				if ( apply_filters( 'palatio_filter_show_blog_title', true, 'band' ) ) {
					do_action( 'palatio_action_before_post_title' );
					if ( empty( $palatio_template_args['no_links'] ) ) {
						the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
					} else {
						the_title( '<h4 class="post_title entry-title">', '</h4>' );
					}
					do_action( 'palatio_action_after_post_title' );
				}
				?>
			</div><!-- .post_header -->
			<?php
		}

		// Post content
		if ( ! isset( $palatio_template_args['excerpt_length'] ) && ! in_array( $palatio_post_format, array( 'gallery', 'audio', 'video' ) ) ) {
			$palatio_template_args['excerpt_length'] = 13;
		}
		if ( apply_filters( 'palatio_filter_show_blog_excerpt', empty( $palatio_template_args['hide_excerpt'] ) && palatio_get_theme_option( 'excerpt_length' ) > 0, 'band' ) ) {
			?>
			<div class="post_content entry-content">
				<?php
				// Post content area
				palatio_show_post_content( $palatio_template_args, '<div class="post_content_inner">', '</div>' );
				?>
			</div><!-- .entry-content -->
			<?php
		}
		// Post meta
		if ( apply_filters( 'palatio_filter_show_blog_meta', $palatio_show_meta, $palatio_components, 'band' ) ) {
			if ( count( $palatio_components ) > 0 ) {
				do_action( 'palatio_action_before_post_meta' );
				palatio_show_post_meta(
					apply_filters(
						'palatio_filter_post_meta_args', array(
							'components' => join( ',', $palatio_components ),
							'seo'        => false,
							'echo'       => true,
						), 'band', 1
					)
				);
				do_action( 'palatio_action_after_post_meta' );
			}
		}
		// More button
		if ( apply_filters( 'palatio_filter_show_blog_readmore', ! $palatio_show_title || ! empty( $palatio_template_args['more_button'] ), 'band' ) ) {
			if ( empty( $palatio_template_args['no_links'] ) ) {
				do_action( 'palatio_action_before_post_readmore' );
				palatio_show_post_more_link( $palatio_template_args, '<div class="more-wrap">', '</div>' );
				do_action( 'palatio_action_after_post_readmore' );
			}
		}
		?>
	</div>
</article>
<?php

if ( is_array( $palatio_template_args ) ) {
	if ( ! empty( $palatio_template_args['slider'] ) || $palatio_columns > 1 ) {
		?>
		</div>
		<?php
	}
}
