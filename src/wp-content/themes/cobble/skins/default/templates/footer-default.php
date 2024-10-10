<?php
/**
 * The template to display default site footer
 *
 * @package COBBLE
 * @since COBBLE 1.0.10
 */

?>
<footer class="footer_wrap footer_default
<?php
$cobble_footer_scheme = cobble_get_theme_option( 'footer_scheme' );
if ( ! empty( $cobble_footer_scheme ) && ! cobble_is_inherit( $cobble_footer_scheme  ) ) {
	echo ' scheme_' . esc_attr( $cobble_footer_scheme );
}
?>
				">
	<?php

	// Footer widgets area
	get_template_part( apply_filters( 'cobble_filter_get_template_part', 'templates/footer-widgets' ) );

	// Logo
	get_template_part( apply_filters( 'cobble_filter_get_template_part', 'templates/footer-logo' ) );

	// Socials
	get_template_part( apply_filters( 'cobble_filter_get_template_part', 'templates/footer-socials' ) );

	// Copyright area
	get_template_part( apply_filters( 'cobble_filter_get_template_part', 'templates/footer-copyright' ) );

	?>
</footer><!-- /.footer_wrap -->
