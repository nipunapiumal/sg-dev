<?php
/**
 * The template to display the attachment
 *
 * @package PALATIO
 * @since PALATIO 1.0
 */


get_header();

while ( have_posts() ) {
	the_post();

	// Display post's content
	get_template_part( apply_filters( 'palatio_filter_get_template_part', 'templates/content', 'single-' . palatio_get_theme_option( 'single_style' ) ), 'single-' . palatio_get_theme_option( 'single_style' ) );

	// Parent post navigation.
	$palatio_posts_navigation = palatio_get_theme_option( 'posts_navigation' );
	if ( 'links' == $palatio_posts_navigation ) {
		?>
		<div class="nav-links-single<?php
			if ( ! palatio_is_off( palatio_get_theme_option( 'posts_navigation_fixed', 0 ) ) ) {
				echo ' nav-links-fixed fixed';
			}
		?>">
			<?php
			the_post_navigation( apply_filters( 'palatio_filter_post_navigation_args', array(
					'prev_text' => '<span class="nav-arrow"></span>'
						. '<span class="meta-nav" aria-hidden="true">' . esc_html__( 'Published in', 'palatio' ) . '</span> '
						. '<span class="screen-reader-text">' . esc_html__( 'Previous post:', 'palatio' ) . '</span> '
						. '<h5 class="post-title">%title</h5>'
						. '<span class="post_date">%date</span>',
			), 'image' ) );
			?>
		</div>
		<?php
	}

	// Comments
	do_action( 'palatio_action_before_comments' );
	comments_template();
	do_action( 'palatio_action_after_comments' );
}

get_footer();
