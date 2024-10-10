<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package COBBLE
 * @since COBBLE 1.0
 */

// Page (category, tag, archive, author) title

if ( cobble_need_page_title() ) {
	cobble_sc_layouts_showed( 'title', true );
	cobble_sc_layouts_showed( 'postmeta', true );
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php
						// Post meta on the single post
						if ( is_single() ) {
							?>
							<div class="sc_layouts_title_meta">
							<?php
								cobble_show_post_meta(
									apply_filters(
										'cobble_filter_post_meta_args', array(
											'components' => join( ',', cobble_array_get_keys_by_value( cobble_get_theme_option( 'meta_parts' ) ) ),
											'counters'   => join( ',', cobble_array_get_keys_by_value( cobble_get_theme_option( 'counters' ) ) ),
											'seo'        => cobble_is_on( cobble_get_theme_option( 'seo_snippets' ) ),
										), 'header', 1
									)
								);
							?>
							</div>
							<?php
						}

						// Blog/Post title
						?>
						<div class="sc_layouts_title_title">
							<?php
							$cobble_blog_title           = cobble_get_blog_title();
							$cobble_blog_title_text      = '';
							$cobble_blog_title_class     = '';
							$cobble_blog_title_link      = '';
							$cobble_blog_title_link_text = '';
							if ( is_array( $cobble_blog_title ) ) {
								$cobble_blog_title_text      = $cobble_blog_title['text'];
								$cobble_blog_title_class     = ! empty( $cobble_blog_title['class'] ) ? ' ' . $cobble_blog_title['class'] : '';
								$cobble_blog_title_link      = ! empty( $cobble_blog_title['link'] ) ? $cobble_blog_title['link'] : '';
								$cobble_blog_title_link_text = ! empty( $cobble_blog_title['link_text'] ) ? $cobble_blog_title['link_text'] : '';
							} else {
								$cobble_blog_title_text = $cobble_blog_title;
							}
							?>
							<h1 itemprop="headline" class="sc_layouts_title_caption<?php echo esc_attr( $cobble_blog_title_class ); ?>">
								<?php
								$cobble_top_icon = cobble_get_term_image_small();
								if ( ! empty( $cobble_top_icon ) ) {
									$cobble_attr = cobble_getimagesize( $cobble_top_icon );
									?>
									<img src="<?php echo esc_url( $cobble_top_icon ); ?>" alt="<?php esc_attr_e( 'Site icon', 'cobble' ); ?>"
										<?php
										if ( ! empty( $cobble_attr[3] ) ) {
											cobble_show_layout( $cobble_attr[3] );
										}
										?>
									>
									<?php
								}
								echo wp_kses_data( $cobble_blog_title_text );
								?>
							</h1>
							<?php
							if ( ! empty( $cobble_blog_title_link ) && ! empty( $cobble_blog_title_link_text ) ) {
								?>
								<a href="<?php echo esc_url( $cobble_blog_title_link ); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html( $cobble_blog_title_link_text ); ?></a>
								<?php
							}

							// Category/Tag description
							if ( ! is_paged() && ( is_category() || is_tag() || is_tax() ) ) {
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
							}

							?>
						</div>
						<?php

						// Breadcrumbs
						ob_start();
						do_action( 'cobble_action_breadcrumbs' );
						$cobble_breadcrumbs = ob_get_contents();
						ob_end_clean();
						cobble_show_layout( $cobble_breadcrumbs, '<div class="sc_layouts_title_breadcrumbs">', '</div>' );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
