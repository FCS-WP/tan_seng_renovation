<?php
/**
 * The template to display the widgets area in the header
 *
 * @package COBBLE
 * @since COBBLE 1.0
 */

// Header sidebar
$cobble_header_name    = cobble_get_theme_option( 'header_widgets' );
$cobble_header_present = ! cobble_is_off( $cobble_header_name ) && is_active_sidebar( $cobble_header_name );
if ( $cobble_header_present ) {
	cobble_storage_set( 'current_sidebar', 'header' );
	$cobble_header_wide = cobble_get_theme_option( 'header_wide' );
	ob_start();
	if ( is_active_sidebar( $cobble_header_name ) ) {
		dynamic_sidebar( $cobble_header_name );
	}
	$cobble_widgets_output = ob_get_contents();
	ob_end_clean();
	if ( ! empty( $cobble_widgets_output ) ) {
		$cobble_widgets_output = preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $cobble_widgets_output );
		$cobble_need_columns   = strpos( $cobble_widgets_output, 'columns_wrap' ) === false;
		if ( $cobble_need_columns ) {
			$cobble_columns = max( 0, (int) cobble_get_theme_option( 'header_columns' ) );
			if ( 0 == $cobble_columns ) {
				$cobble_columns = min( 6, max( 1, cobble_tags_count( $cobble_widgets_output, 'aside' ) ) );
			}
			if ( $cobble_columns > 1 ) {
				$cobble_widgets_output = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $cobble_columns ) . ' widget', $cobble_widgets_output );
			} else {
				$cobble_need_columns = false;
			}
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo ! empty( $cobble_header_wide ) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<?php do_action( 'cobble_action_before_sidebar_wrap', 'header' ); ?>
			<div class="header_widgets_inner widget_area_inner">
				<?php
				if ( ! $cobble_header_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $cobble_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'cobble_action_before_sidebar', 'header' );
				cobble_show_layout( $cobble_widgets_output );
				do_action( 'cobble_action_after_sidebar', 'header' );
				if ( $cobble_need_columns ) {
					?>
					</div>	<!-- /.columns_wrap -->
					<?php
				}
				if ( ! $cobble_header_wide ) {
					?>
					</div>	<!-- /.content_wrap -->
					<?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
			<?php do_action( 'cobble_action_after_sidebar_wrap', 'header' ); ?>
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
