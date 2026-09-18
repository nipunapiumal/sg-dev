<?php
/**
 * The template to display Admin notices
 *
 * @package PALATIO
 * @since PALATIO 1.98.0
 */

$palatio_skins_url   = get_admin_url( null, 'admin.php?page=trx_addons_theme_panel#trx_addons_theme_panel_section_skins' );
$palatio_active_skin = palatio_skins_get_active_skin_name();
?>
<div class="palatio_admin_notice palatio_skins_notice notice notice-error">
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
		<?php esc_html_e( 'Active skin is missing!', 'palatio' ); ?>
	</h3>
	<div class="palatio_notice_text">
		<p>
			<?php
			// Translators: Add a current skin name to the message
			echo wp_kses_data( sprintf( __( "Your active skin <b>'%s'</b> is missing. Usually this happens when the theme is updated directly through the server or FTP.", 'palatio' ), ucfirst( $palatio_active_skin ) ) );
			?>
		</p>
		<p>
			<?php
			echo wp_kses_data( __( "Please use only <b>'ThemeREX Updater v.1.6.0+'</b> plugin for your future updates.", 'palatio' ) );
			?>
		</p>
		<p>
			<?php
			echo wp_kses_data( __( "But no worries! You can re-download the skin via 'Skins Manager' ( Theme Panel - Theme Dashboard - Skins ).", 'palatio' ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="palatio_notice_buttons">
		<?php
		// Link to the theme dashboard page
		?>
		<a href="<?php echo esc_url( $palatio_skins_url ); ?>" class="button button-primary"><i class="dashicons dashicons-update"></i> 
			<?php
			// Translators: Add theme name
			esc_html_e( 'Go to Skins manager', 'palatio' );
			?>
		</a>
	</div>
</div>
