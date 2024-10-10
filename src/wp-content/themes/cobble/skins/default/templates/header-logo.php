<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package COBBLE
 * @since COBBLE 1.0
 */

$cobble_args = get_query_var( 'cobble_logo_args' );

// Site logo
$cobble_logo_type   = isset( $cobble_args['type'] ) ? $cobble_args['type'] : '';
$cobble_logo_image  = cobble_get_logo_image( $cobble_logo_type );
$cobble_logo_text   = cobble_is_on( cobble_get_theme_option( 'logo_text' ) ) ? get_bloginfo( 'name' ) : '';
$cobble_logo_slogan = get_bloginfo( 'description', 'display' );
if ( ! empty( $cobble_logo_image['logo'] ) || ! empty( $cobble_logo_text ) ) {
	?><a class="sc_layouts_logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php
		if ( ! empty( $cobble_logo_image['logo'] ) ) {
			if ( empty( $cobble_logo_type ) && function_exists( 'the_custom_logo' ) && is_numeric($cobble_logo_image['logo']) && (int) $cobble_logo_image['logo'] > 0 ) {
				the_custom_logo();
			} else {
				$cobble_attr = cobble_getimagesize( $cobble_logo_image['logo'] );
				echo '<img src="' . esc_url( $cobble_logo_image['logo'] ) . '"'
						. ( ! empty( $cobble_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $cobble_logo_image['logo_retina'] ) . ' 2x"' : '' )
						. ' alt="' . esc_attr( $cobble_logo_text ) . '"'
						. ( ! empty( $cobble_attr[3] ) ? ' ' . wp_kses_data( $cobble_attr[3] ) : '' )
						. '>';
			}
		} else {
			cobble_show_layout( cobble_prepare_macros( $cobble_logo_text ), '<span class="logo_text">', '</span>' );
			cobble_show_layout( cobble_prepare_macros( $cobble_logo_slogan ), '<span class="logo_slogan">', '</span>' );
		}
		?>
	</a>
	<?php
}
