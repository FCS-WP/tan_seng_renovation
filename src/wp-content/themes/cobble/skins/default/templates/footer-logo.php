<?php
/**
 * The template to display the site logo in the footer
 *
 * @package COBBLE
 * @since COBBLE 1.0.10
 */

// Logo
if ( cobble_is_on( cobble_get_theme_option( 'logo_in_footer' ) ) ) {
	$cobble_logo_image = cobble_get_logo_image( 'footer' );
	$cobble_logo_text  = get_bloginfo( 'name' );
	if ( ! empty( $cobble_logo_image['logo'] ) || ! empty( $cobble_logo_text ) ) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if ( ! empty( $cobble_logo_image['logo'] ) ) {
					$cobble_attr = cobble_getimagesize( $cobble_logo_image['logo'] );
					echo '<a href="' . esc_url( home_url( '/' ) ) . '">'
							. '<img src="' . esc_url( $cobble_logo_image['logo'] ) . '"'
								. ( ! empty( $cobble_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $cobble_logo_image['logo_retina'] ) . ' 2x"' : '' )
								. ' class="logo_footer_image"'
								. ' alt="' . esc_attr__( 'Site logo', 'cobble' ) . '"'
								. ( ! empty( $cobble_attr[3] ) ? ' ' . wp_kses_data( $cobble_attr[3] ) : '' )
							. '>'
						. '</a>';
				} elseif ( ! empty( $cobble_logo_text ) ) {
					echo '<h1 class="logo_footer_text">'
							. '<a href="' . esc_url( home_url( '/' ) ) . '">'
								. esc_html( $cobble_logo_text )
							. '</a>'
						. '</h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
