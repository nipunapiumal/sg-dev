<?php
/**
 * The Header: Logo and main menu
 *
 * @package PALATIO
 * @since PALATIO 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js<?php
	// Class scheme_xxx need in the <html> as context for the <body>!
	echo ' scheme_' . esc_attr( palatio_get_theme_option( 'color_scheme' ) );
?>">

<head>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else {
		do_action( 'wp_body_open' );
	}
	do_action( 'palatio_action_before_body' );
	?>

	<div class="<?php echo esc_attr( apply_filters( 'palatio_filter_body_wrap_class', 'body_wrap' ) ); ?>" <?php do_action('palatio_action_body_wrap_attributes'); ?>>

		<?php do_action( 'palatio_action_before_page_wrap' ); ?>

		<div class="<?php echo esc_attr( apply_filters( 'palatio_filter_page_wrap_class', 'page_wrap' ) ); ?>" <?php do_action('palatio_action_page_wrap_attributes'); ?>>

			<?php do_action( 'palatio_action_page_wrap_start' ); ?>

			<?php
			$palatio_full_post_loading = ( palatio_is_singular( 'post' ) || palatio_is_singular( 'attachment' ) ) && palatio_get_value_gp( 'action' ) == 'full_post_loading';
			$palatio_prev_post_loading = ( palatio_is_singular( 'post' ) || palatio_is_singular( 'attachment' ) ) && palatio_get_value_gp( 'action' ) == 'prev_post_loading';

			// Don't display the header elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ! $palatio_full_post_loading && ! $palatio_prev_post_loading ) {

				// Short links to fast access to the content, sidebar and footer from the keyboard
				?>
				<a class="palatio_skip_link skip_to_content_link" href="#content_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'palatio_filter_skip_links_tabindex', 0 ) ); ?>"><?php esc_html_e( "Skip to content", 'palatio' ); ?></a>
				<?php if ( palatio_sidebar_present() ) { ?>
				<a class="palatio_skip_link skip_to_sidebar_link" href="#sidebar_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'palatio_filter_skip_links_tabindex', 0 ) ); ?>"><?php esc_html_e( "Skip to sidebar", 'palatio' ); ?></a>
				<?php } ?>
				<a class="palatio_skip_link skip_to_footer_link" href="#footer_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'palatio_filter_skip_links_tabindex', 0 ) ); ?>"><?php esc_html_e( "Skip to footer", 'palatio' ); ?></a>

				<?php
				do_action( 'palatio_action_before_header' );

				// Header
				$palatio_header_type = palatio_get_theme_option( 'header_type' );
				if ( 'custom' == $palatio_header_type && ! palatio_is_layouts_available() ) {
					$palatio_header_type = 'default';
				}
				get_template_part( apply_filters( 'palatio_filter_get_template_part', "templates/header-" . sanitize_file_name( $palatio_header_type ) ) );

				// Side menu
				if ( in_array( palatio_get_theme_option( 'menu_side', 'none' ), array( 'left', 'right' ) ) ) {
					get_template_part( apply_filters( 'palatio_filter_get_template_part', 'templates/header-navi-side' ) );
				}

				// Mobile menu
				if ( apply_filters( 'palatio_filter_use_navi_mobile', palatio_sc_layouts_showed( 'menu_button' ) || $palatio_header_type == 'default' ) ) {
					get_template_part( apply_filters( 'palatio_filter_get_template_part', 'templates/header-navi-mobile' ) );
				}

				do_action( 'palatio_action_after_header' );

			}
			?>

			<?php do_action( 'palatio_action_before_page_content_wrap' ); ?>

			<div class="page_content_wrap<?php
				if ( palatio_is_off( palatio_get_theme_option( 'remove_margins' ) ) ) {
					if ( empty( $palatio_header_type ) ) {
						$palatio_header_type = palatio_get_theme_option( 'header_type' );
					}
					if ( 'custom' == $palatio_header_type && palatio_is_layouts_available() ) {
						$palatio_header_id = palatio_get_custom_header_id();
						if ( $palatio_header_id > 0 ) {
							$palatio_header_meta = palatio_get_custom_layout_meta( $palatio_header_id );
							if ( ! empty( $palatio_header_meta['margin'] ) ) {
								?> page_content_wrap_custom_header_margin<?php
							}
						}
					}
					$palatio_footer_type = palatio_get_theme_option( 'footer_type' );
					if ( 'custom' == $palatio_footer_type && palatio_is_layouts_available() ) {
						$palatio_footer_id = palatio_get_custom_footer_id();
						if ( $palatio_footer_id ) {
							$palatio_footer_meta = palatio_get_custom_layout_meta( $palatio_footer_id );
							if ( ! empty( $palatio_footer_meta['margin'] ) ) {
								?> page_content_wrap_custom_footer_margin<?php
							}
						}
					}
				}
				do_action( 'palatio_action_page_content_wrap_class', $palatio_prev_post_loading );
				?>"<?php
				if ( apply_filters( 'palatio_filter_is_prev_post_loading', $palatio_prev_post_loading ) ) {
					?> data-single-style="<?php echo esc_attr( palatio_get_theme_option( 'single_style' ) ); ?>"<?php
				}
				do_action( 'palatio_action_page_content_wrap_data', $palatio_prev_post_loading );
			?>>
				<?php
				do_action( 'palatio_action_page_content_wrap', $palatio_full_post_loading || $palatio_prev_post_loading );

				// Single posts banner
				if ( apply_filters( 'palatio_filter_single_post_header', palatio_is_singular( 'post' ) || palatio_is_singular( 'attachment' ) ) ) {
					if ( $palatio_prev_post_loading ) {
						if ( palatio_get_theme_option( 'posts_navigation_scroll_which_block', 'article' ) != 'article' ) {
							do_action( 'palatio_action_between_posts' );
						}
					}
					// Single post thumbnail and title
					$palatio_path = apply_filters( 'palatio_filter_get_template_part', 'templates/single-styles/' . palatio_get_theme_option( 'single_style' ) );
					if ( palatio_get_file_dir( $palatio_path . '.php' ) != '' ) {
						get_template_part( $palatio_path );
					}
				}

				// Widgets area above page
				$palatio_body_style   = palatio_get_theme_option( 'body_style' );
				$palatio_widgets_name = palatio_get_theme_option( 'widgets_above_page', 'hide' );
				$palatio_show_widgets = ! palatio_is_off( $palatio_widgets_name ) && is_active_sidebar( $palatio_widgets_name );
				if ( $palatio_show_widgets ) {
					if ( 'fullscreen' != $palatio_body_style ) {
						?>
						<div class="content_wrap">
							<?php
					}
					palatio_create_widgets_area( 'widgets_above_page' );
					if ( 'fullscreen' != $palatio_body_style ) {
						?>
						</div>
						<?php
					}
				}

				// Content area
				do_action( 'palatio_action_before_content_wrap' );
				?>
				<div class="content_wrap<?php echo 'fullscreen' == $palatio_body_style ? '_fullscreen' : ''; ?>">

					<?php do_action( 'palatio_action_content_wrap_start' ); ?>

					<div class="content">
						<?php
						do_action( 'palatio_action_page_content_start' );

						// Skip link anchor to fast access to the content from keyboard
						?>
						<span id="content_skip_link_anchor" class="palatio_skip_link_anchor"></span>
						<?php
						// Single posts banner between prev/next posts
						if ( ( palatio_is_singular( 'post' ) || palatio_is_singular( 'attachment' ) )
							&& $palatio_prev_post_loading 
							&& palatio_get_theme_option( 'posts_navigation_scroll_which_block', 'article' ) == 'article'
						) {
							do_action( 'palatio_action_between_posts' );
						}

						// Widgets area above content
						palatio_create_widgets_area( 'widgets_above_content' );

						do_action( 'palatio_action_page_content_start_text' );
