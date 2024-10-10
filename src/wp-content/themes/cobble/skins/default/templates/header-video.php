<?php
/**
 * The template to display the background video in the header
 *
 * @package COBBLE
 * @since COBBLE 1.0.14
 */
$cobble_header_video = cobble_get_header_video();
$cobble_embed_video  = '';
if ( ! empty( $cobble_header_video ) && ! cobble_is_from_uploads( $cobble_header_video ) ) {
	if ( cobble_is_youtube_url( $cobble_header_video ) && preg_match( '/[=\/]([^=\/]*)$/', $cobble_header_video, $matches ) && ! empty( $matches[1] ) ) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr( $matches[1] ); ?>"></div>
		<?php
	} else {
		?>
		<div id="background_video"><?php cobble_show_layout( cobble_get_embed_video( $cobble_header_video ) ); ?></div>
		<?php
	}
}
