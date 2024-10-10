<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package COBBLE
 * @since COBBLE 1.0.10
 */

// Footer sidebar
$cobble_footer_name    = cobble_get_theme_option( 'footer_widgets' );
$cobble_footer_present = ! cobble_is_off( $cobble_footer_name ) && is_active_sidebar( $cobble_footer_name );
if ( $cobble_footer_present ) {
	cobble_storage_set( 'current_sidebar', 'footer' );
	$cobble_footer_wide = cobble_get_theme_option( 'footer_wide' );
	ob_start();
	if ( is_active_sidebar( $cobble_footer_name ) ) {
		dynamic_sidebar( $cobble_footer_name );
	}
	$cobble_out = trim( ob_get_contents() );
	ob_end_clean();
	if ( ! empty( $cobble_out ) ) {
		$cobble_out          = preg_replace( "/<\\/aside>[\r\n\s]*<aside/", '</aside><aside', $cobble_out );
		$cobble_need_columns = true;   //or check: strpos($cobble_out, 'columns_wrap')===false;
		if ( $cobble_need_columns ) {
			$cobble_columns = max( 0, (int) cobble_get_theme_option( 'footer_columns' ) );			
			if ( 0 == $cobble_columns ) {
				$cobble_columns = min( 4, max( 1, cobble_tags_count( $cobble_out, 'aside' ) ) );
			}
			if ( $cobble_columns > 1 ) {
				$cobble_out = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $cobble_columns ) . ' widget', $cobble_out );
			} else {
				$cobble_need_columns = false;
			}
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo ! empty( $cobble_footer_wide ) ? ' footer_fullwidth' : ''; ?> sc_layouts_row sc_layouts_row_type_normal">
			<?php do_action( 'cobble_action_before_sidebar_wrap', 'footer' ); ?>
			<div class="footer_widgets_inner widget_area_inner">
				<?php
				if ( ! $cobble_footer_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $cobble_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'cobble_action_before_sidebar', 'footer' );
				cobble_show_layout( $cobble_out );
				do_action( 'cobble_action_after_sidebar', 'footer' );
				if ( $cobble_need_columns ) {
					?>
					</div><!-- /.columns_wrap -->
					<?php
				}
				if ( ! $cobble_footer_wide ) {
					?>
					</div><!-- /.content_wrap -->
					<?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
			<?php do_action( 'cobble_action_after_sidebar_wrap', 'footer' ); ?>
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
