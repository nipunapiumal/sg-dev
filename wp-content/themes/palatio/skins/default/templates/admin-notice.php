<?php
/**
 * The template to display Admin notices
 *
 * @package PALATIO
 * @since PALATIO 1.0.1
 */

$palatio_theme_slug = get_option( 'template' );
$palatio_theme_obj  = wp_get_theme( $palatio_theme_slug );
?>
<div class="palatio_admin_notice palatio_welcome_notice notice notice-info is-dismissible" data-notice="admin">
	<?php
	// Theme image
	$palatio_theme_img = palatio_get_file_url( 'screenshot.jpg' );
	if ( '' != $palatio_theme_img ) {
		?>
		<div class="palatio_notice_image"><img src="<?php echo esc_url( $palatio_theme_img ); ?>" alt="<?php esc_attr_e( 'Theme screenshot', 'palatio' ); ?>"></div>
		<?php
	}

	// Title
	?>
	<h3 class="palatio_notice_title">
		<?php
		echo esc_html(
			sprintf(
				// Translators: Add theme name and version to the 'Welcome' message
				__( 'Welcome to %1$s v.%2$s', 'palatio' ),
				$palatio_theme_obj->get( 'Name' ) . ( PALATIO_THEME_FREE ? ' ' . __( 'Free', 'palatio' ) : '' ),
				$palatio_theme_obj->get( 'Version' )
			)
		);
		?>
	</h3>
	<?php

	// Description
	?>
	<div class="palatio_notice_text">
		<p class="palatio_notice_text_description">
			<?php
			echo str_replace( '. ', '.<br>', wp_kses_data( $palatio_theme_obj->description ) );
			?>
		</p>
		<p class="palatio_notice_text_info">
			<?php
			echo wp_kses_data( __( 'Attention! Plugin "ThemeREX Addons" is required! Please, install and activate it!', 'palatio' ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="palatio_notice_buttons">
		<?php
		// Link to the page 'About Theme'
		?>
		<a href="<?php echo esc_url( admin_url() . 'themes.php?page=palatio_about' ); ?>" class="button button-primary"><i class="dashicons dashicons-nametag"></i> 
			<?php
			echo esc_html__( 'Install plugin "ThemeREX Addons"', 'palatio' );
			?>
		</a>
	</div>
</div>
