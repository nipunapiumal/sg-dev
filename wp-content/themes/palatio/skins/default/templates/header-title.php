<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package PALATIO
 * @since PALATIO 1.0
 */

// Page (category, tag, archive, author) title

if ( palatio_need_page_title() ) {
	palatio_sc_layouts_showed( 'title', true );
	palatio_sc_layouts_showed( 'postmeta', true );
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php
						// Post meta on the single post
						if ( is_single() ) {
							?>
							<div class="sc_layouts_title_meta">
							<?php
								palatio_show_post_meta(
									apply_filters(
										'palatio_filter_post_meta_args', array(
											'components' => join( ',', palatio_array_get_keys_by_value( palatio_get_theme_option( 'meta_parts' ) ) ),
											'counters'   => join( ',', palatio_array_get_keys_by_value( palatio_get_theme_option( 'counters' ) ) ),
											'seo'        => palatio_is_on( palatio_get_theme_option( 'seo_snippets' ) ),
										), 'header', 1
									)
								);
							?>
							</div>
							<?php
						}

						// Blog/Post title
						?>
						<div class="sc_layouts_title_title">
							<?php
							$palatio_blog_title           = palatio_get_blog_title();
							$palatio_blog_title_text      = '';
							$palatio_blog_title_class     = '';
							$palatio_blog_title_link      = '';
							$palatio_blog_title_link_text = '';
							if ( is_array( $palatio_blog_title ) ) {
								$palatio_blog_title_text      = $palatio_blog_title['text'];
								$palatio_blog_title_class     = ! empty( $palatio_blog_title['class'] ) ? ' ' . $palatio_blog_title['class'] : '';
								$palatio_blog_title_link      = ! empty( $palatio_blog_title['link'] ) ? $palatio_blog_title['link'] : '';
								$palatio_blog_title_link_text = ! empty( $palatio_blog_title['link_text'] ) ? $palatio_blog_title['link_text'] : '';
							} else {
								$palatio_blog_title_text = $palatio_blog_title;
							}
							?>
							<h1 class="sc_layouts_title_caption<?php echo esc_attr( $palatio_blog_title_class ); ?>"<?php
								if ( palatio_is_on( palatio_get_theme_option( 'seo_snippets' ) ) ) {
									?> itemprop="headline"<?php
								}
							?>>
								<?php
								$palatio_top_icon = palatio_get_term_image_small();
								if ( ! empty( $palatio_top_icon ) ) {
									$palatio_attr = palatio_getimagesize( $palatio_top_icon );
									?>
									<img src="<?php echo esc_url( $palatio_top_icon ); ?>" alt="<?php esc_attr_e( 'Site icon', 'palatio' ); ?>"
										<?php
										if ( ! empty( $palatio_attr[3] ) ) {
											palatio_show_layout( $palatio_attr[3] );
										}
										?>
									>
									<?php
								}
								echo wp_kses_data( $palatio_blog_title_text );
								?>
							</h1>
							<?php
							if ( ! empty( $palatio_blog_title_link ) && ! empty( $palatio_blog_title_link_text ) ) {
								?>
								<a href="<?php echo esc_url( $palatio_blog_title_link ); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html( $palatio_blog_title_link_text ); ?></a>
								<?php
							}

							// Category/Tag description
							if ( ! is_paged() && ( is_category() || is_tag() || is_tax() ) ) {
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
							}

							?>
						</div>
						<?php

						// Breadcrumbs
						ob_start();
						do_action( 'palatio_action_breadcrumbs' );
						$palatio_breadcrumbs = ob_get_contents();
						ob_end_clean();
						palatio_show_layout( $palatio_breadcrumbs, '<div class="sc_layouts_title_breadcrumbs">', '</div>' );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
