<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package COBBLE
 * @since COBBLE 1.0
 */

							do_action( 'cobble_action_page_content_end_text' );
							
							// Widgets area below the content
							cobble_create_widgets_area( 'widgets_below_content' );
						
							do_action( 'cobble_action_page_content_end' );
							?>
						</div>
						<?php
						
						do_action( 'cobble_action_after_page_content' );

						// Show main sidebar
						get_sidebar();

						do_action( 'cobble_action_content_wrap_end' );
						?>
					</div>
					<?php

					do_action( 'cobble_action_after_content_wrap' );

					// Widgets area below the page and related posts below the page
					$cobble_body_style = cobble_get_theme_option( 'body_style' );
					$cobble_widgets_name = cobble_get_theme_option( 'widgets_below_page' );
					$cobble_show_widgets = ! cobble_is_off( $cobble_widgets_name ) && is_active_sidebar( $cobble_widgets_name );
					$cobble_show_related = cobble_is_single() && cobble_get_theme_option( 'related_position' ) == 'below_page';
					if ( $cobble_show_widgets || $cobble_show_related ) {
						if ( 'fullscreen' != $cobble_body_style ) {
							?>
							<div class="content_wrap">
							<?php
						}
						// Show related posts before footer
						if ( $cobble_show_related ) {
							do_action( 'cobble_action_related_posts' );
						}

						// Widgets area below page content
						if ( $cobble_show_widgets ) {
							cobble_create_widgets_area( 'widgets_below_page' );
						}
						if ( 'fullscreen' != $cobble_body_style ) {
							?>
							</div>
							<?php
						}
					}
					do_action( 'cobble_action_page_content_wrap_end' );
					?>
			</div>
			<?php
			do_action( 'cobble_action_after_page_content_wrap' );

			// Don't display the footer elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ( ! cobble_is_singular( 'post' ) && ! cobble_is_singular( 'attachment' ) ) || ! in_array ( cobble_get_value_gp( 'action' ), array( 'full_post_loading', 'prev_post_loading' ) ) ) {
				
				// Skip link anchor to fast access to the footer from keyboard
				?>
				<a id="footer_skip_link_anchor" class="cobble_skip_link_anchor" href="#"></a>
				<?php

				do_action( 'cobble_action_before_footer' );

				// Footer
				$cobble_footer_type = cobble_get_theme_option( 'footer_type' );
				if ( 'custom' == $cobble_footer_type && ! cobble_is_layouts_available() ) {
					$cobble_footer_type = 'default';
				}
				get_template_part( apply_filters( 'cobble_filter_get_template_part', "templates/footer-" . sanitize_file_name( $cobble_footer_type ) ) );

				do_action( 'cobble_action_after_footer' );

			}
			?>

			<?php do_action( 'cobble_action_page_wrap_end' ); ?>

		</div>

		<?php do_action( 'cobble_action_after_page_wrap' ); ?>

	</div>

	<?php do_action( 'cobble_action_after_body' ); ?>

	<?php wp_footer(); ?>

</body>
</html>