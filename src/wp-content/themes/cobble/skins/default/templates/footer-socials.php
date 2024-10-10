<?php
/**
 * The template to display the socials in the footer
 *
 * @package COBBLE
 * @since COBBLE 1.0.10
 */


// Socials
if ( cobble_is_on( cobble_get_theme_option( 'socials_in_footer' ) ) ) {
	$cobble_output = cobble_get_socials_links();
	if ( '' != $cobble_output ) {
		?>
		<div class="footer_socials_wrap socials_wrap">
			<div class="footer_socials_inner">
				<?php cobble_show_layout( $cobble_output ); ?>
			</div>
		</div>
		<?php
	}
}
