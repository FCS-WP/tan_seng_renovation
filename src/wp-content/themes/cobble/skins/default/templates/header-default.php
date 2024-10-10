<?php
/**
 * The template to display default site header
 *
 * @package COBBLE
 * @since COBBLE 1.0
 */

$cobble_header_css   = '';
$cobble_header_image = get_header_image();
$cobble_header_video = cobble_get_header_video();
if ( ! empty( $cobble_header_image ) && cobble_trx_addons_featured_image_override( is_singular() || cobble_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$cobble_header_image = cobble_get_current_mode_image( $cobble_header_image );
}

?><header class="top_panel top_panel_default
	<?php
	echo ! empty( $cobble_header_image ) || ! empty( $cobble_header_video ) ? ' with_bg_image' : ' without_bg_image';
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

	// Main menu
	get_template_part( apply_filters( 'cobble_filter_get_template_part', 'templates/header-navi' ) );

	// Mobile header
	if ( cobble_is_on( cobble_get_theme_option( 'header_mobile_enabled' ) ) ) {
		get_template_part( apply_filters( 'cobble_filter_get_template_part', 'templates/header-mobile' ) );
	}

	// Page title and breadcrumbs area
	if ( ! is_single() ) {
		get_template_part( apply_filters( 'cobble_filter_get_template_part', 'templates/header-title' ) );
	}

	// Header widgets area
	get_template_part( apply_filters( 'cobble_filter_get_template_part', 'templates/header-widgets' ) );
	?>
</header>
