<?php
/**
 * The template to display Admin notices
 *
 * @package PALATIO
 * @since PALATIO 1.0.64
 */

$palatio_skins_url  = get_admin_url( null, 'admin.php?page=trx_addons_theme_panel#trx_addons_theme_panel_section_skins' );
$palatio_skins_args = get_query_var( 'palatio_skins_notice_args' );
?>
<div class="palatio_admin_notice palatio_skins_notice notice notice-info is-dismissible" data-notice="skins">
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
		<?php esc_html_e( 'New skins are available', 'palatio' ); ?>
	</h3>
	<?php

	// Description
	$palatio_total      = $palatio_skins_args['update'];	// Store value to the separate variable to avoid warnings from ThemeCheck plugin!
	$palatio_skins_msg  = $palatio_total > 0
							// Translators: Add new skins number
							? '<strong>' . sprintf( _n( '%d new version', '%d new versions', $palatio_total, 'palatio' ), $palatio_total ) . '</strong>'
							: '';
	$palatio_total      = $palatio_skins_args['free'];
	$palatio_skins_msg .= $palatio_total > 0
							? ( ! empty( $palatio_skins_msg ) ? ' ' . esc_html__( 'and', 'palatio' ) . ' ' : '' )
								// Translators: Add new skins number
								. '<strong>' . sprintf( _n( '%d free skin', '%d free skins', $palatio_total, 'palatio' ), $palatio_total ) . '</strong>'
							: '';
	$palatio_total      = $palatio_skins_args['pay'];
	$palatio_skins_msg .= $palatio_skins_args['pay'] > 0
							? ( ! empty( $palatio_skins_msg ) ? ' ' . esc_html__( 'and', 'palatio' ) . ' ' : '' )
								// Translators: Add new skins number
								. '<strong>' . sprintf( _n( '%d paid skin', '%d paid skins', $palatio_total, 'palatio' ), $palatio_total ) . '</strong>'
							: '';
	?>
	<div class="palatio_notice_text">
		<p>
			<?php
			// Translators: Add new skins info
			echo wp_kses_data( sprintf( __( "We are pleased to announce that %s are available for your theme", 'palatio' ), $palatio_skins_msg ) );
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
			esc_html_e( 'Go to Skins manager', 'palatio' );
			?>
		</a>
		<?php
		// Dismiss notice for 7 days
		?>
		<a href="#" role="button" class="button button-secondary palatio_notice_button_dismiss" data-notice="skins"><i class="dashicons dashicons-no-alt"></i> 
			<?php
			esc_html_e( 'Dismiss', 'palatio' );
			?>
		</a>
		<?php
		// Hide notice forever
		?>
		<a href="#" role="button" class="button button-secondary palatio_notice_button_hide" data-notice="skins"><i class="dashicons dashicons-no-alt"></i> 
			<?php
			esc_html_e( 'Never show again', 'palatio' );
			?>
		</a>
	</div>
</div>
