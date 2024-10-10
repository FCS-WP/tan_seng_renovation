<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package COBBLE
 * @since COBBLE 1.0.06
 */

$cobble_header_css   = '';
$cobble_header_image = get_header_image();
$cobble_header_video = cobble_get_header_video();
if ( ! empty( $cobble_header_image ) && cobble_trx_addons_featured_image_override( is_singular() || cobble_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$cobble_header_image = cobble_get_current_mode_image( $cobble_header_image );
}

$cobble_header_id = cobble_get_custom_header_id();
$cobble_header_meta = get_post_meta( $cobble_header_id, 'trx_addons_options', true );
if ( ! empty( $cobble_header_meta['margin'] ) ) {
	cobble_add_inline_css( sprintf( '.page_content_wrap{padding-top:%s}', esc_attr( cobble_prepare_css_value( $cobble_header_meta['margin'] ) ) ) );
}

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr( $cobble_header_id ); ?> top_panel_custom_<?php echo esc_attr( sanitize_title( get_the_title( $cobble_header_id ) ) ); ?>
				<?php
				echo ! empty( $cobble_header_image ) || ! empty( $cobble_header_video )
					? ' with_bg_image'
					: ' without_bg_image';
				if ( '' != $cobble_header_video ) {
					echo ' with_bg_video';
				}
				if ( '' != $cobble_header_image ) {
					echo ' ' . esc_attr( cobble_add_inline_css_class( 'background-image: url(' . esc_url( $cobble_header_image ) . ');' ) );
				}
				if ( is_single() && has_post_thumbnail() ) {
					echo ' with_featured_image';
				}
				if ( cobble_is_on( cobble_get_theme_option( 'header_fullheight' ) ) ) {
					echo ' header_fullheight cobble-full-height';
				}
				$cobble_header_scheme = cobble_get_theme_option( 'header_scheme' );
				if ( ! empty( $cobble_header_scheme ) && ! cobble_is_inherit( $cobble_header_scheme  ) ) {
					echo ' scheme_' . esc_attr( $cobble_header_scheme );
				}
				?>
">
	<?php

	// Background video
	if ( ! empty( $cobble_header_video ) ) {
		get_template_part( apply_filters( 'cobble_filter_get_template_part', 'templates/header-video' ) );
	}

	// Custom header's layout
	do_action( 'cobble_action_show_layout', $cobble_header_id );

	// Header widgets area
	get_template_part( apply_filters( 'cobble_filter_get_template_part', 'templates/header-widgets' ) );

	?>
</header>
