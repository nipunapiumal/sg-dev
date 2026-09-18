<?php
/**
 * The template to display the background video in the header
 *
 * @package PALATIO
 * @since PALATIO 1.0.14
 */
$palatio_header_video = palatio_get_header_video();
$palatio_embed_video  = '';
if ( ! empty( $palatio_header_video ) && ! palatio_is_from_uploads( $palatio_header_video ) ) {
	if ( palatio_is_youtube_url( $palatio_header_video ) && preg_match( '/[=\/]([^=\/]*)$/', $palatio_header_video, $matches ) && ! empty( $matches[1] ) ) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr( $matches[1] ); ?>"></div>
		<?php
	} else {
		?>
		<div id="background_video"><?php palatio_show_layout( palatio_get_embed_video( $palatio_header_video ) ); ?></div>
		<?php
	}
}
