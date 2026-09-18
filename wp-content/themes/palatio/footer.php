<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package PALATIO
 * @since PALATIO 1.0
 */

							do_action( 'palatio_action_page_content_end_text' );
							
							// Widgets area below the content
							palatio_create_widgets_area( 'widgets_below_content' );
						
							do_action( 'palatio_action_page_content_end' );
							?>
						</div>
						<?php
						
						do_action( 'palatio_action_after_page_content' );

						// Show main sidebar
						get_sidebar();

						do_action( 'palatio_action_content_wrap_end' );
						?>
					</div>
					<?php

					do_action( 'palatio_action_after_content_wrap' );

					// Widgets area below the page and related posts below the page
					$palatio_body_style = palatio_get_theme_option( 'body_style' );
					$palatio_widgets_name = palatio_get_theme_option( 'widgets_below_page', 'hide' );
					$palatio_show_widgets = ! palatio_is_off( $palatio_widgets_name ) && is_active_sidebar( $palatio_widgets_name );
					$palatio_show_related = palatio_is_single() && palatio_get_theme_option( 'related_position', 'below_content' ) == 'below_page';
					if ( $palatio_show_widgets || $palatio_show_related ) {
						if ( 'fullscreen' != $palatio_body_style ) {
							?>
							<div class="content_wrap">
							<?php
						}
						// Show related posts before footer
						if ( $palatio_show_related ) {
							do_action( 'palatio_action_related_posts' );
						}

						// Widgets area below page content
						if ( $palatio_show_widgets ) {
							palatio_create_widgets_area( 'widgets_below_page' );
						}
						if ( 'fullscreen' != $palatio_body_style ) {
							?>
							</div>
							<?php
						}
					}
					do_action( 'palatio_action_page_content_wrap_end' );
					?>
			</div>
			<?php
			do_action( 'palatio_action_after_page_content_wrap' );

			// Don't display the footer elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ( ! palatio_is_singular( 'post' ) && ! palatio_is_singular( 'attachment' ) ) || ! in_array ( palatio_get_value_gp( 'action' ), array( 'full_post_loading', 'prev_post_loading' ) ) ) {
				
				// Skip link anchor to fast access to the footer from keyboard
				?>
				<span id="footer_skip_link_anchor" class="palatio_skip_link_anchor"></span>
				<?php

				do_action( 'palatio_action_before_footer' );

				// Footer
				$palatio_footer_type = palatio_get_theme_option( 'footer_type' );
				if ( 'custom' == $palatio_footer_type && ! palatio_is_layouts_available() ) {
					$palatio_footer_type = 'default';
				}
				get_template_part( apply_filters( 'palatio_filter_get_template_part', "templates/footer-" . sanitize_file_name( $palatio_footer_type ) ) );

				do_action( 'palatio_action_after_footer' );

			}
			?>

			<?php do_action( 'palatio_action_page_wrap_end' ); ?>

		</div>

		<?php do_action( 'palatio_action_after_page_wrap' ); ?>

	</div>

	<?php do_action( 'palatio_action_after_body' ); ?>

	<?php wp_footer(); ?>

</body>
</html>