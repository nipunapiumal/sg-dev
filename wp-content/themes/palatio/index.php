<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: //codex.wordpress.org/Template_Hierarchy
 *
 * @package PALATIO
 * @since PALATIO 1.0
 */

$palatio_template = apply_filters( 'palatio_filter_get_template_part', palatio_blog_archive_get_template() );

if ( ! empty( $palatio_template ) && 'index' != $palatio_template ) {

	get_template_part( $palatio_template );

} else {

	palatio_storage_set( 'blog_archive', true );

	get_header();

	if ( have_posts() ) {

		// Query params
		$palatio_stickies   = is_home()
								|| ( in_array( palatio_get_theme_option( 'post_type' ), array( '', 'post' ) )
									&& (int) palatio_get_theme_option( 'parent_cat' ) == 0
									)
										? get_option( 'sticky_posts' )
										: false;
		$palatio_post_type  = palatio_get_theme_option( 'post_type' );
		$palatio_args       = array(
								'blog_style'     => palatio_get_theme_option( 'blog_style' ),
								'post_type'      => $palatio_post_type,
								'taxonomy'       => palatio_get_post_type_taxonomy( $palatio_post_type ),
								'parent_cat'     => palatio_get_theme_option( 'parent_cat' ),
								'posts_per_page' => palatio_get_theme_option( 'posts_per_page' ),
								'sticky'         => palatio_get_theme_option( 'sticky_style', 'inherit' ) == 'columns'
															&& is_array( $palatio_stickies )
															&& count( $palatio_stickies ) > 0
															&& get_query_var( 'paged' ) < 1
								);

		palatio_blog_archive_start();

		do_action( 'palatio_action_blog_archive_start' );

		if ( is_author() ) {
			do_action( 'palatio_action_before_page_author' );
			get_template_part( apply_filters( 'palatio_filter_get_template_part', 'templates/author-page' ) );
			do_action( 'palatio_action_after_page_author' );
		}

		if ( palatio_get_theme_option( 'show_filters', 0 ) ) {
			do_action( 'palatio_action_before_page_filters' );
			palatio_show_filters( $palatio_args );
			do_action( 'palatio_action_after_page_filters' );
		} else {
			do_action( 'palatio_action_before_page_posts' );
			palatio_show_posts( array_merge( $palatio_args, array( 'cat' => $palatio_args['parent_cat'] ) ) );
			do_action( 'palatio_action_after_page_posts' );
		}

		do_action( 'palatio_action_blog_archive_end' );

		palatio_blog_archive_end();

	} else {

		if ( is_search() ) {
			get_template_part( apply_filters( 'palatio_filter_get_template_part', 'templates/content', 'none-search' ), 'none-search' );
		} else {
			get_template_part( apply_filters( 'palatio_filter_get_template_part', 'templates/content', 'none-archive' ), 'none-archive' );
		}
	}

	get_footer();
}
