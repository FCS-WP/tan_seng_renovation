<?php
/**
 * The template to display the side menu
 *
 * @package COBBLE
 * @since COBBLE 1.0
 */
?>
<div class="menu_side_wrap
<?php
echo ' menu_side_' . esc_attr( cobble_get_theme_option( 'menu_side_icons' ) > 0 ? 'icons' : 'dots' );
$cobble_menu_scheme = cobble_get_theme_option( 'menu_scheme' );
$cobble_header_scheme = cobble_get_theme_option( 'header_scheme' );
if ( ! empty( $cobble_menu_scheme ) && ! cobble_is_inherit( $cobble_menu_scheme  ) ) {
	echo ' scheme_' . esc_attr( $cobble_menu_scheme );
} elseif ( ! empty( $cobble_header_scheme ) && ! cobble_is_inherit( $cobble_header_scheme ) ) {
	echo ' scheme_' . esc_attr( $cobble_header_scheme );
}
?>
				">
	<span class="menu_side_button icon-menu-2"></span>

	<div class="menu_side_inner">
		<?php
		// Logo
		set_query_var( 'cobble_logo_args', array( 'type' => 'side' ) );
		get_template_part( apply_filters( 'cobble_filter_get_template_part', 'templates/header-logo' ) );
		set_query_var( 'cobble_logo_args', array() );
		// Main menu button
		?>
		<div class="toc_menu_item"
			<?php
			if ( cobble_mouse_helper_enabled() ) {
				echo ' data-mouse-helper="click" data-mouse-helper-axis="y" data-mouse-helper-text="' . esc_attr__( 'Open main menu', 'cobble' ) . '"';
			}
			?>
		>
			<a href="#" class="toc_menu_description menu_mobile_description"><span class="toc_menu_description_title"><?php esc_html_e( 'Main menu', 'cobble' ); ?></span></a>
			<a class="menu_mobile_button toc_menu_icon icon-menu-2" href="#"></a>
		</div>		
	</div>

</div><!-- /.menu_side_wrap -->
