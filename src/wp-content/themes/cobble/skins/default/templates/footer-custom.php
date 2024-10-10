<?php
/**
 * The template to display default site footer
 *
 * @package COBBLE
 * @since COBBLE 1.0.10
 */

$cobble_footer_id = cobble_get_custom_footer_id();
$cobble_footer_meta = get_post_meta( $cobble_footer_id, 'trx_addons_options', true );
if ( ! empty( $cobble_footer_meta['margin'] ) ) {
	cobble_add_inline_css( sprintf( '.page_content_wrap{padding-bottom:%s}', esc_attr( cobble_prepare_css_value( $cobble_footer_meta['margin'] ) ) ) );
}
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr( $cobble_footer_id ); ?> footer_custom_<?php echo esc_attr( sanitize_title( get_the_title( $cobble_footer_id ) ) ); ?>
						<?php
						$cobble_footer_scheme = cobble_get_theme_option( 'footer_scheme' );
						if ( ! empty( $cobble_footer_scheme ) && ! cobble_is_inherit( $cobble_footer_scheme  ) ) {
							echo ' scheme_' . esc_attr( $cobble_footer_scheme );
						}
						?>
						">
	<?php
	// Custom footer's layout
	do_action( 'cobble_action_show_layout', $cobble_footer_id );
	?>
</footer><!-- /.footer_wrap -->
