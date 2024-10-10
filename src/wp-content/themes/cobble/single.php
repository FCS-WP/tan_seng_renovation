<?php
/**
 * The template to display single post
 *
 * @package COBBLE
 * @since COBBLE 1.0
 */

// Full post loading
$full_post_loading          = cobble_get_value_gp( 'action' ) == 'full_post_loading';

// Prev post loading
$prev_post_loading          = cobble_get_value_gp( 'action' ) == 'prev_post_loading';
$prev_post_loading_type     = cobble_get_theme_option( 'posts_navigation_scroll_which_block' );

// Position of the related posts
$cobble_related_position   = cobble_get_theme_option( 'related_position' );

// Type of the prev/next post navigation
$cobble_posts_navigation   = cobble_get_theme_option( 'posts_navigation' );
$cobble_prev_post          = false;
$cobble_prev_post_same_cat = cobble_get_theme_option( 'posts_navigation_scroll_same_cat' );

// Rewrite style of the single post if current post loading via AJAX and featured image and title is not in the content
if ( ( $full_post_loading 
		|| 
		( $prev_post_loading && 'article' == $prev_post_loading_type )
	) 
	&& 
	! in_array( cobble_get_theme_option( 'single_style' ), array( 'style-6' ) )
) {
	cobble_storage_set_array( 'options_meta', 'single_style', 'style-6' );
}

do_action( 'cobble_action_prev_post_loading', $prev_post_loading, $prev_post_loading_type );

get_header();

while ( have_posts() ) {

	the_post();

	// Type of the prev/next post navigation
	if ( 'scroll' == $cobble_posts_navigation ) {
		$cobble_prev_post = get_previous_post( $cobble_prev_post_same_cat );  // Get post from same category
		if ( ! $cobble_prev_post && $cobble_prev_post_same_cat ) {
			$cobble_prev_post = get_previous_post( false );                    // Get post from any category
		}
		if ( ! $cobble_prev_post ) {
			$cobble_posts_navigation = 'links';
		}
	}

	// Override some theme options to display featured image, title and post meta in the dynamic loaded posts
	if ( $full_post_loading || ( $prev_post_loading && $cobble_prev_post ) ) {
		cobble_sc_layouts_showed( 'featured', false );
		cobble_sc_layouts_showed( 'title', false );
		cobble_sc_layouts_showed( 'postmeta', false );
	}

	// If related posts should be inside the content
	if ( strpos( $cobble_related_position, 'inside' ) === 0 ) {
		ob_start();
	}

	// Display post's content
	get_template_part( apply_filters( 'cobble_filter_get_template_part', 'templates/content', 'single-' . cobble_get_theme_option( 'single_style' ) ), 'single-' . cobble_get_theme_option( 'single_style' ) );

	// If related posts should be inside the content
	if ( strpos( $cobble_related_position, 'inside' ) === 0 ) {
		$cobble_content = ob_get_contents();
		ob_end_clean();

		ob_start();
		do_action( 'cobble_action_related_posts' );
		$cobble_related_content = ob_get_contents();
		ob_end_clean();

		if ( ! empty( $cobble_related_content ) ) {
			$cobble_related_position_inside = max( 0, min( 9, cobble_get_theme_option( 'related_position_inside' ) ) );
			if ( 0 == $cobble_related_position_inside ) {
				$cobble_related_position_inside = mt_rand( 1, 9 );
			}

			$cobble_p_number         = 0;
			$cobble_related_inserted = false;
			$cobble_in_block         = false;
			$cobble_content_start    = strpos( $cobble_content, '<div class="post_content' );
			$cobble_content_end      = strrpos( $cobble_content, '</div>' );

			for ( $i = max( 0, $cobble_content_start ); $i < min( strlen( $cobble_content ) - 3, $cobble_content_end ); $i++ ) {
				if ( $cobble_content[ $i ] != '<' ) {
					continue;
				}
				if ( $cobble_in_block ) {
					if ( strtolower( substr( $cobble_content, $i + 1, 12 ) ) == '/blockquote>' ) {
						$cobble_in_block = false;
						$i += 12;
					}
					continue;
				} else if ( strtolower( substr( $cobble_content, $i + 1, 10 ) ) == 'blockquote' && in_array( $cobble_content[ $i + 11 ], array( '>', ' ' ) ) ) {
					$cobble_in_block = true;
					$i += 11;
					continue;
				} else if ( 'p' == $cobble_content[ $i + 1 ] && in_array( $cobble_content[ $i + 2 ], array( '>', ' ' ) ) ) {
					$cobble_p_number++;
					if ( $cobble_related_position_inside == $cobble_p_number ) {
						$cobble_related_inserted = true;
						$cobble_content = ( $i > 0 ? substr( $cobble_content, 0, $i ) : '' )
											. $cobble_related_content
											. substr( $cobble_content, $i );
					}
				}
			}
			if ( ! $cobble_related_inserted ) {
				if ( $cobble_content_end > 0 ) {
					$cobble_content = substr( $cobble_content, 0, $cobble_content_end ) . $cobble_related_content . substr( $cobble_content, $cobble_content_end );
				} else {
					$cobble_content .= $cobble_related_content;
				}
			}
		}

		cobble_show_layout( $cobble_content );
	}

	// Comments
	do_action( 'cobble_action_before_comments' );
	comments_template();
	do_action( 'cobble_action_after_comments' );

	// Related posts
	if ( 'below_content' == $cobble_related_position
		&& ( 'scroll' != $cobble_posts_navigation || cobble_get_theme_option( 'posts_navigation_scroll_hide_related' ) == 0 )
		&& ( ! $full_post_loading || cobble_get_theme_option( 'open_full_post_hide_related' ) == 0 )
	) {
		do_action( 'cobble_action_related_posts' );
	}

	// Post navigation: type 'scroll'
	if ( 'scroll' == $cobble_posts_navigation && ! $full_post_loading ) {
		?>
		<div class="nav-links-single-scroll"
			data-post-id="<?php echo esc_attr( get_the_ID( $cobble_prev_post ) ); ?>"
			data-post-link="<?php echo esc_attr( get_permalink( $cobble_prev_post ) ); ?>"
			data-post-title="<?php the_title_attribute( array( 'post' => $cobble_prev_post ) ); ?>"
			<?php do_action( 'cobble_action_nav_links_single_scroll_data', $cobble_prev_post ); ?>
		></div>
		<?php
	}
}

get_footer();
