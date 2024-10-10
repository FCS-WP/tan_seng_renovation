<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package COBBLE
 * @since COBBLE 1.0
 */

if ( cobble_sidebar_present() ) {
	
	$cobble_sidebar_type = cobble_get_theme_option( 'sidebar_type' );
	if ( 'custom' == $cobble_sidebar_type && ! cobble_is_layouts_available() ) {
		$cobble_sidebar_type = 'default';
	}
	
	// Catch output to the buffer
	ob_start();
	if ( 'default' == $cobble_sidebar_type ) {
		// Default sidebar with widgets
		$cobble_sidebar_name = cobble_get_theme_option( 'sidebar_widgets' );
		cobble_storage_set( 'current_sidebar', 'sidebar' );
		if ( is_active_sidebar( $cobble_sidebar_name ) ) {
			dynamic_sidebar( $cobble_sidebar_name );
		}
	} else {
		// Custom sidebar from Layouts Builder
		$cobble_sidebar_id = cobble_get_custom_sidebar_id();
		do_action( 'cobble_action_show_layout', $cobble_sidebar_id );
	}
	$cobble_out = trim( ob_get_contents() );
	ob_end_clean();
	
	// If any html is present - display it
	if ( ! empty( $cobble_out ) ) {
		$cobble_sidebar_position    = cobble_get_theme_option( 'sidebar_position' );
		$cobble_sidebar_position_ss = cobble_get_theme_option( 'sidebar_position_ss' );
		?>
		<div class="sidebar widget_area
			<?php
			echo ' ' . esc_attr( $cobble_sidebar_position );
			echo ' sidebar_' . esc_attr( $cobble_sidebar_position_ss );
			echo ' sidebar_' . esc_attr( $cobble_sidebar_type );

			$cobble_sidebar_scheme = apply_filters( 'cobble_filter_sidebar_scheme', cobble_get_theme_option( 'sidebar_scheme' ) );
			if ( ! empty( $cobble_sidebar_scheme ) && ! cobble_is_inherit( $cobble_sidebar_scheme ) && 'custom' != $cobble_sidebar_type ) {
				echo ' scheme_' . esc_attr( $cobble_sidebar_scheme );
			}
			?>
		" role="complementary">
			<?php

			// Skip link anchor to fast access to the sidebar from keyboard
			?>
			<a id="sidebar_skip_link_anchor" class="cobble_skip_link_anchor" href="#"></a>
			<?php

			do_action( 'cobble_action_before_sidebar_wrap', 'sidebar' );

			// Button to show/hide sidebar on mobile
			if ( in_array( $cobble_sidebar_position_ss, array( 'above', 'float' ) ) ) {
				$cobble_title = apply_filters( 'cobble_filter_sidebar_control_title', 'float' == $cobble_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'cobble' ) : '' );
				$cobble_text  = apply_filters( 'cobble_filter_sidebar_control_text', 'above' == $cobble_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'cobble' ) : '' );
				?>
				<a href="#" class="sidebar_control" title="<?php echo esc_attr( $cobble_title ); ?>"><?php echo esc_html( $cobble_text ); ?></a>
				<?php
			}
			?>
			<div class="sidebar_inner">
				<?php
				do_action( 'cobble_action_before_sidebar', 'sidebar' );
				cobble_show_layout( preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $cobble_out ) );
				do_action( 'cobble_action_after_sidebar', 'sidebar' );
				?>
			</div>
			<?php

			do_action( 'cobble_action_after_sidebar_wrap', 'sidebar' );

			?>
		</div>
		<div class="clearfix"></div>
		<?php
	}
}
