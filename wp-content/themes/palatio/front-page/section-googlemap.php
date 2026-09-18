<div class="front_page_section front_page_section_googlemap<?php
	$palatio_scheme = palatio_get_theme_option( 'front_page_googlemap_scheme' );
	if ( ! empty( $palatio_scheme ) && ! palatio_is_inherit( $palatio_scheme ) ) {
		echo ' scheme_' . esc_attr( $palatio_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( palatio_get_theme_option( 'front_page_googlemap_paddings' ) );
	if ( palatio_get_theme_option( 'front_page_googlemap_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$palatio_css      = '';
		$palatio_bg_image = palatio_get_theme_option( 'front_page_googlemap_bg_image' );
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
	$palatio_anchor_icon = palatio_get_theme_option( 'front_page_googlemap_anchor_icon' );
	$palatio_anchor_text = palatio_get_theme_option( 'front_page_googlemap_anchor_text' );
if ( ( ! empty( $palatio_anchor_icon ) || ! empty( $palatio_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_googlemap"'
									. ( ! empty( $palatio_anchor_icon ) ? ' icon="' . esc_attr( $palatio_anchor_icon ) . '"' : '' )
									. ( ! empty( $palatio_anchor_text ) ? ' title="' . esc_attr( $palatio_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_googlemap_inner
		<?php
		$palatio_layout = palatio_get_theme_option( 'front_page_googlemap_layout' );
		echo ' front_page_section_layout_' . esc_attr( $palatio_layout );
		if ( palatio_get_theme_option( 'front_page_googlemap_fullheight' ) ) {
			echo ' palatio-full-height sc_layouts_flex sc_layouts_columns_middle';
		}
		?>
		"
			<?php
			$palatio_css      = '';
			$palatio_bg_mask  = palatio_get_theme_option( 'front_page_googlemap_bg_mask' );
			$palatio_bg_color_type = palatio_get_theme_option( 'front_page_googlemap_bg_color_type' );
			if ( 'custom' == $palatio_bg_color_type ) {
				$palatio_bg_color = palatio_get_theme_option( 'front_page_googlemap_bg_color' );
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
		<div class="front_page_section_content_wrap front_page_section_googlemap_content_wrap
		<?php
		if ( 'fullwidth' != $palatio_layout ) {
			echo ' content_wrap';
		}
		?>
		">
			<?php
			// Content wrap with title and description
			$palatio_caption     = palatio_get_theme_option( 'front_page_googlemap_caption' );
			$palatio_description = palatio_get_theme_option( 'front_page_googlemap_description' );
			if ( ! empty( $palatio_caption ) || ! empty( $palatio_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				if ( 'fullwidth' == $palatio_layout ) {
					?>
					<div class="content_wrap">
					<?php
				}
					// Caption
				if ( ! empty( $palatio_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<h2 class="front_page_section_caption front_page_section_googlemap_caption front_page_block_<?php echo ! empty( $palatio_caption ) ? 'filled' : 'empty'; ?>">
					<?php
					echo wp_kses( $palatio_caption, 'palatio_kses_content' );
					?>
					</h2>
					<?php
				}

					// Description (text)
				if ( ! empty( $palatio_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<div class="front_page_section_description front_page_section_googlemap_description front_page_block_<?php echo ! empty( $palatio_description ) ? 'filled' : 'empty'; ?>">
					<?php
					echo wp_kses( wpautop( $palatio_description ), 'palatio_kses_content' );
					?>
					</div>
					<?php
				}
				if ( 'fullwidth' == $palatio_layout ) {
					?>
					</div>
					<?php
				}
			}

			// Content (text)
			$palatio_content = palatio_get_theme_option( 'front_page_googlemap_content' );
			if ( ! empty( $palatio_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				if ( 'columns' == $palatio_layout ) {
					?>
					<div class="front_page_section_columns front_page_section_googlemap_columns columns_wrap">
						<div class="column-1_3">
					<?php
				} elseif ( 'fullwidth' == $palatio_layout ) {
					?>
					<div class="content_wrap">
					<?php
				}

				?>
				<div class="front_page_section_content front_page_section_googlemap_content front_page_block_<?php echo ! empty( $palatio_content ) ? 'filled' : 'empty'; ?>">
				<?php
					echo wp_kses( $palatio_content, 'palatio_kses_content' );
				?>
				</div>
				<?php

				if ( 'columns' == $palatio_layout ) {
					?>
					</div><div class="column-2_3">
					<?php
				} elseif ( 'fullwidth' == $palatio_layout ) {
					?>
					</div>
					<?php
				}
			}

			// Widgets output
			?>
			<div class="front_page_section_output front_page_section_googlemap_output">
				<?php
				if ( is_active_sidebar( 'front_page_googlemap_widgets' ) ) {
					dynamic_sidebar( 'front_page_googlemap_widgets' );
				} elseif ( current_user_can( 'edit_theme_options' ) ) {
					if ( ! palatio_exists_trx_addons() ) {
						palatio_customizer_need_trx_addons_message();
					} else {
						palatio_customizer_need_widgets_message( 'front_page_googlemap_caption', 'ThemeREX Addons - Google map' );
					}
				}
				?>
			</div>
			<?php

			if ( 'columns' == $palatio_layout && ( ! empty( $palatio_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				</div></div>
				<?php
			}
			?>
		</div>
	</div>
</div>
