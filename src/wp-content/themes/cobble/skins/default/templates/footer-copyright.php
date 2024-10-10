<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package COBBLE
 * @since COBBLE 1.0.10
 */

// Copyright area
?> 
<div class="footer_copyright_wrap
<?php
$cobble_copyright_scheme = cobble_get_theme_option( 'copyright_scheme' );
if ( ! empty( $cobble_copyright_scheme ) && ! cobble_is_inherit( $cobble_copyright_scheme  ) ) {
	echo ' scheme_' . esc_attr( $cobble_copyright_scheme );
}
?>
				">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text">
			<?php
				$cobble_copyright = cobble_get_theme_option( 'copyright' );
			if ( ! empty( $cobble_copyright ) ) {
				// Replace {{Y}} or {Y} with the current year
				$cobble_copyright = str_replace( array( '{{Y}}', '{Y}' ), date( 'Y' ), $cobble_copyright );
				// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
				$cobble_copyright = cobble_prepare_macros( $cobble_copyright );
				// Display copyright
				echo wp_kses( nl2br( $cobble_copyright ), 'cobble_kses_content' );
			}
			?>
			</div>
		</div>
	</div>
</div>
