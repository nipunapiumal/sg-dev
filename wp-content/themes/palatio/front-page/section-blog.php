<div class="front_page_section front_page_section_blog<?php
	$palatio_scheme = palatio_get_theme_option( 'front_page_blog_scheme' );
	if ( ! empty( $palatio_scheme ) && ! palatio_is_inherit( $palatio_scheme ) ) {
		echo ' scheme_' . esc_attr( $palatio_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( palatio_get_theme_option( 'front_page_blog_paddings' ) );
	if ( palatio_get_theme_option( 'front_page_blog_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$palatio_css      = '';
		$palatio_bg_image = palatio_get_theme_option( 'front_page_blog_bg_image' );
		if ( ! empty( $palatio_bg_image ) ) {
			$palatio_css .= 'background-image: url(' . esc_url( palatio_get_attachment_url( $palatio_bg_image ) ) . ');';
		}
		if ( ! empty( $palatio_css ) ) {
			echo ' style="' . esc_attr( $palatio_css ) . '"';
		}
		?>
>
<?php
	// Add anchor
	$palatio_anchor_icon = palatio_get_theme_option( 'front_page_blog_anchor_icon' );
	$palatio_anchor_text = palatio_get_theme_option( 'front_page_blog_anchor_text' );
if ( ( ! empty( $palatio_anchor_icon ) || ! empty( $palatio_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_blog"'
									. ( ! empty( $palatio_anchor_icon ) ? ' icon="' . esc_attr( $palatio_anchor_icon ) . '"' : '' )
									. ( ! empty( $palatio_anchor_text ) ? ' title="' . esc_attr( $palatio_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_blog_inner
	<?php
	if ( palatio_get_theme_option( 'front_page_blog_fullheight' ) ) {
		echo ' palatio-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$palatio_css      = '';
			$palatio_bg_mask  = palatio_get_theme_option( 'front_page_blog_bg_mask' );
			$palatio_bg_color_type = palatio_get_theme_option( 'front_page_blog_bg_color_type' );
			if ( 'custom' == $palatio_bg_color_type ) {
				$palatio_bg_color = palatio_get_theme_option( 'front_page_blog_bg_color' );
			} elseif ( 'scheme_bg_color' == $palatio_bg_color_type ) {
				$palatio_bg_color = palatio_get_scheme_color( 'bg_color', $palatio_scheme );
			} else {
				$palatio_bg_color = '';
			}
			if ( ! empty( $palatio_bg_color ) && $palatio_bg_mask > 0 ) {
				$palatio_css .= 'background-color: ' . esc_attr(
					1 == $palatio_bg_mask ? $palatio_bg_color : palatio_hex2rgba( $palatio_bg_color, $palatio_bg_mask )
				) . ';';
			}
			if ( ! empty( $palatio_css ) ) {
				echo ' style="' . esc_attr( $palatio_css ) . '"';
			}
			?>
	>
		<div class="front_page_section_content_wrap front_page_section_blog_content_wrap content_wrap">
			<?php
			// Caption
			$palatio_caption = palatio_get_theme_option( 'front_page_blog_caption' );
			if ( ! empty( $palatio_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<h2 class="front_page_section_caption front_page_section_blog_caption front_page_block_<?php echo ! empty( $palatio_caption ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( $palatio_caption, 'palatio_kses_content' ); ?></h2>
				<?php
			}

			// Description (text)
			$palatio_description = palatio_get_theme_option( 'front_page_blog_description' );
			if ( ! empty( $palatio_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_description front_page_section_blog_description front_page_block_<?php echo ! empty( $palatio_description ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( wpautop( $palatio_description ), 'palatio_kses_content' ); ?></div>
				<?php
			}

			// Content (widgets)
			?>
			<div class="front_page_section_output front_page_section_blog_output">
				<?php
				if ( is_active_sidebar( 'front_page_blog_widgets' ) ) {
					dynamic_sidebar( 'front_page_blog_widgets' );
				} elseif ( current_user_can( 'edit_theme_options' ) ) {
					if ( ! palatio_exists_trx_addons() ) {
						palatio_customizer_need_trx_addons_message();
					} else {
						palatio_customizer_need_widgets_message( 'front_page_blog_caption', 'ThemeREX Addons - Blogger' );
					}
				}
				?>
			</div>
		</div>
	</div>
</div>
