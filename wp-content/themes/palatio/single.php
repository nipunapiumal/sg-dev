<?php
/**
 * The template to display single post
 *
 * @package PALATIO
 * @since PALATIO 1.0
 */

// Full post loading
$full_post_loading          = palatio_get_value_gp( 'action' ) == 'full_post_loading';

// Prev post loading
$prev_post_loading          = palatio_get_value_gp( 'action' ) == 'prev_post_loading';
$prev_post_loading_type     = palatio_get_theme_option( 'posts_navigation_scroll_which_block', 'article' );

// Position of the related posts
$palatio_related_position   = palatio_get_theme_option( 'related_position', 'below_content' );

// Type of the prev/next post navigation
$palatio_posts_navigation   = palatio_get_theme_option( 'posts_navigation' );
$palatio_prev_post          = false;
$palatio_prev_post_same_cat = (int)palatio_get_theme_option( 'posts_navigation_scroll_same_cat', 1 );

// Rewrite style of the single post if current post loading via AJAX and featured image and title is not in the content
if ( ( $full_post_loading 
		|| 
		( $prev_post_loading && 'article' == $prev_post_loading_type )
	) 
	&& 
	! in_array( palatio_get_theme_option( 'single_style' ), array( 'style-6' ) )
) {
	palatio_storage_set_array( 'options_meta', 'single_style', 'style-6' );
}

do_action( 'palatio_action_prev_post_loading', $prev_post_loading, $prev_post_loading_type );

get_header();

while ( have_posts() ) {

	the_post();

	// Type of the prev/next post navigation
	if ( 'scroll' == $palatio_posts_navigation ) {
		$palatio_prev_post = get_previous_post( $palatio_prev_post_same_cat );  // Get post from same category
		if ( ! $palatio_prev_post && $palatio_prev_post_same_cat ) {
			$palatio_prev_post = get_previous_post( false );                    // Get post from any category
		}
		if ( ! $palatio_prev_post ) {
			$palatio_posts_navigation = 'links';
		}
	}

	// Override some theme options to display featured image, title and post meta in the dynamic loaded posts
	if ( $full_post_loading || ( $prev_post_loading && $palatio_prev_post ) ) {
		palatio_sc_layouts_showed( 'featured', false );
		palatio_sc_layouts_showed( 'title', false );
		palatio_sc_layouts_showed( 'postmeta', false );
	}

	// If related posts should be inside the content
	if ( strpos( $palatio_related_position, 'inside' ) === 0 ) {
		ob_start();
	}

	// Display post's content
	get_template_part( apply_filters( 'palatio_filter_get_template_part', 'templates/content', 'single-' . palatio_get_theme_option( 'single_style' ) ), 'single-' . palatio_get_theme_option( 'single_style' ) );

	// If related posts should be inside the content
	if ( strpos( $palatio_related_position, 'inside' ) === 0 ) {
		$palatio_content = ob_get_contents();
		ob_end_clean();

		ob_start();
		do_action( 'palatio_action_related_posts' );
		$palatio_related_content = ob_get_contents();
		ob_end_clean();

		if ( ! empty( $palatio_related_content ) ) {
			$palatio_related_position_inside = max( 0, min( 9, palatio_get_theme_option( 'related_position_inside' ) ) );
			if ( 0 == $palatio_related_position_inside ) {
				$palatio_related_position_inside = mt_rand( 1, 9 );
			}

			$palatio_p_number         = 0;
			$palatio_related_inserted = false;
			$palatio_in_block         = false;
			$palatio_content_start    = strpos( $palatio_content, '<div class="post_content' );
			$palatio_content_end      = strrpos( $palatio_content, '</div>' );

			for ( $i = max( 0, $palatio_content_start ); $i < min( strlen( $palatio_content ) - 3, $palatio_content_end ); $i++ ) {
				if ( $palatio_content[ $i ] != '<' ) {
					continue;
				}
				if ( $palatio_in_block ) {
					if ( strtolower( substr( $palatio_content, $i + 1, 12 ) ) == '/blockquote>' ) {
						$palatio_in_block = false;
						$i += 12;
					}
					continue;
				} else if ( strtolower( substr( $palatio_content, $i + 1, 10 ) ) == 'blockquote' && in_array( $palatio_content[ $i + 11 ], array( '>', ' ' ) ) ) {
					$palatio_in_block = true;
					$i += 11;
					continue;
				} else if ( 'p' == $palatio_content[ $i + 1 ] && in_array( $palatio_content[ $i + 2 ], array( '>', ' ' ) ) ) {
					$palatio_p_number++;
					if ( $palatio_related_position_inside == $palatio_p_number ) {
						$palatio_related_inserted = true;
						$palatio_content = ( $i > 0 ? substr( $palatio_content, 0, $i ) : '' )
											. $palatio_related_content
											. substr( $palatio_content, $i );
					}
				}
			}
			if ( ! $palatio_related_inserted ) {
				if ( $palatio_content_end > 0 ) {
					$palatio_content = substr( $palatio_content, 0, $palatio_content_end ) . $palatio_related_content . substr( $palatio_content, $palatio_content_end );
				} else {
					$palatio_content .= $palatio_related_content;
				}
			}
		}

		palatio_show_layout( $palatio_content );
	}

	// Comments
	do_action( 'palatio_action_before_comments' );
	comments_template();
	do_action( 'palatio_action_after_comments' );

	// Related posts
	if ( 'below_content' == $palatio_related_position
		&& ( 'scroll' != $palatio_posts_navigation || (int)palatio_get_theme_option( 'posts_navigation_scroll_hide_related', 0 ) == 0 )
		&& ( ! $full_post_loading || (int)palatio_get_theme_option( 'open_full_post_hide_related', 1 ) == 0 )
	) {
		do_action( 'palatio_action_related_posts' );
	}

	// Post navigation: type 'scroll'
	if ( 'scroll' == $palatio_posts_navigation && ! $full_post_loading ) {
		?>
		<div class="nav-links-single-scroll"
			data-post-id="<?php echo esc_attr( get_the_ID( $palatio_prev_post ) ); ?>"
			data-post-link="<?php echo esc_attr( get_permalink( $palatio_prev_post ) ); ?>"
			data-post-title="<?php the_title_attribute( array( 'post' => $palatio_prev_post ) ); ?>"
			data-cur-post-link="<?php echo esc_attr( get_permalink() ); ?>"
			data-cur-post-title="<?php the_title_attribute(); ?>"
			<?php do_action( 'palatio_action_nav_links_single_scroll_data', $palatio_prev_post ); ?>
		></div>
		<?php
	}
}

get_footer();
