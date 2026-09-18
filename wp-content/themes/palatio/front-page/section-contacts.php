<div class="front_page_section front_page_section_contacts<?php
	$palatio_scheme = palatio_get_theme_option( 'front_page_contacts_scheme' );
	if ( ! empty( $palatio_scheme ) && ! palatio_is_inherit( $palatio_scheme ) ) {
		echo ' scheme_' . esc_attr( $palatio_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( palatio_get_theme_option( 'front_page_contacts_paddings' ) );
	if ( palatio_get_theme_option( 'front_page_contacts_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$palatio_css      = '';
		$palatio_bg_image = palatio_get_theme_option( 'front_page_contacts_bg_image' );
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
	$palatio_anchor_icon = palatio_get_theme_option( 'front_page_contacts_anchor_icon' );
	$palatio_anchor_text = palatio_get_theme_option( 'front_page_contacts_anchor_text' );
if ( ( ! empty( $palatio_anchor_icon ) || ! empty( $palatio_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_contacts"'
									. ( ! empty( $palatio_anchor_icon ) ? ' icon="' . esc_attr( $palatio_anchor_icon ) . '"' : '' )
									. ( ! empty( $palatio_anchor_text ) ? ' title="' . esc_attr( $palatio_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_contacts_inner
	<?php
	if ( palatio_get_theme_option( 'front_page_contacts_fullheight' ) ) {
		echo ' palatio-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$palatio_css      = '';
			$palatio_bg_mask  = palatio_get_theme_option( 'front_page_contacts_bg_mask' );
			$palatio_bg_color_type = palatio_get_theme_option( 'front_page_contacts_bg_color_type' );
			if ( 'custom' == $palatio_bg_color_type ) {
				$palatio_bg_color = palatio_get_theme_option( 'front_page_contacts_bg_color' );
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
		<div class="front_page_section_content_wrap front_page_section_contacts_content_wrap content_wrap">
			<?php

			// Title and description
			$palatio_caption     = palatio_get_theme_option( 'front_page_contacts_caption' );
			$palatio_description = palatio_get_theme_option( 'front_page_contacts_description' );
			if ( ! empty( $palatio_caption ) || ! empty( $palatio_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				// Caption
				if ( ! empty( $palatio_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<h2 class="front_page_section_caption front_page_section_contacts_caption front_page_block_<?php echo ! empty( $palatio_caption ) ? 'filled' : 'empty'; ?>">
					<?php
						echo wp_kses( $palatio_caption, 'palatio_kses_content' );
					?>
					</h2>
					<?php
				}

				// Description
				if ( ! empty( $palatio_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<div class="front_page_section_description front_page_section_contacts_description front_page_block_<?php echo ! empty( $palatio_description ) ? 'filled' : 'empty'; ?>">
					<?php
						echo wp_kses( wpautop( $palatio_description ), 'palatio_kses_content' );
					?>
					</div>
					<?php
				}
			}

			// Content (text)
			$palatio_content = palatio_get_theme_option( 'front_page_contacts_content' );
			$palatio_layout  = palatio_get_theme_option( 'front_page_contacts_layout' );
			if ( 'columns' == $palatio_layout && ( ! empty( $palatio_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				<div class="front_page_section_columns front_page_section_contacts_columns columns_wrap">
					<div class="column-1_3">
				<?php
			}

			if ( ( ! empty( $palatio_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				<div class="front_page_section_content front_page_section_contacts_content front_page_block_<?php echo ! empty( $palatio_content ) ? 'filled' : 'empty'; ?>">
					<?php
					echo wp_kses( $palatio_content, 'palatio_kses_content' );
					?>
				</div>
				<?php
			}

			if ( 'columns' == $palatio_layout && ( ! empty( $palatio_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				</div><div class="column-2_3">
				<?php
			}

			// Shortcode output
			$palatio_sc = palatio_get_theme_option( 'front_page_contacts_shortcode' );
			if ( ! empty( $palatio_sc ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_output front_page_section_contacts_output front_page_block_<?php echo ! empty( $palatio_sc ) ? 'filled' : 'empty'; ?>">
					<?php
					palatio_show_layout( do_shortcode( $palatio_sc ) );
					?>
				</div>
				<?php
			}

			if ( 'columns' == $palatio_layout && ( ! empty( $palatio_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				</div></div>
				<?php
			}
			?>

		</div>
	</div>
</div>
