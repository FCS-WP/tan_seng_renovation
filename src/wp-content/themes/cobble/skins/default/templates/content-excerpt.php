<?php
/**
 * The default template to display the content
 *
 * Used for index/archive/search.
 *
 * @package COBBLE
 * @since COBBLE 1.0
 */

$cobble_template_args = get_query_var( 'cobble_template_args' );
$cobble_columns = 1;
if ( is_array( $cobble_template_args ) ) {
	$cobble_columns    = empty( $cobble_template_args['columns'] ) ? 1 : max( 1, $cobble_template_args['columns'] );
	$cobble_blog_style = array( $cobble_template_args['type'], $cobble_columns );
	if ( ! empty( $cobble_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $cobble_columns > 1 ) {
	    $cobble_columns_class = cobble_get_column_class( 1, $cobble_columns, ! empty( $cobble_template_args['columns_tablet']) ? $cobble_template_args['columns_tablet'] : '', ! empty($cobble_template_args['columns_mobile']) ? $cobble_template_args['columns_mobile'] : '' );
		?>
		<div class="<?php echo esc_attr( $cobble_columns_class ); ?>">
		<?php
	}
} else {
	$cobble_template_args = array();
}
$cobble_expanded    = ! cobble_sidebar_present() && cobble_get_theme_option( 'expand_content' ) == 'expand';
$cobble_post_format = get_post_format();
$cobble_post_format = empty( $cobble_post_format ) ? 'standard' : str_replace( 'post-format-', '', $cobble_post_format );
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_item_container post_layout_excerpt post_format_' . esc_attr( $cobble_post_format ) );
	cobble_add_blog_animation( $cobble_template_args );
	?>
>
	<?php

	// Sticky label
	if ( is_sticky() && ! is_paged() ) {
		?>
		<span class="post_label label_sticky"></span>
		<?php
	}

	// Featured image
	$cobble_hover      = ! empty( $cobble_template_args['hover'] ) && ! cobble_is_inherit( $cobble_template_args['hover'] )
							? $cobble_template_args['hover']
							: cobble_get_theme_option( 'image_hover' );
	$cobble_components = ! empty( $cobble_template_args['meta_parts'] )
							? ( is_array( $cobble_template_args['meta_parts'] )
								? $cobble_template_args['meta_parts']
								: array_map( 'trim', explode( ',', $cobble_template_args['meta_parts'] ) )
								)
							: cobble_array_get_keys_by_value( cobble_get_theme_option( 'meta_parts' ) );
	cobble_show_post_featured( apply_filters( 'cobble_filter_args_featured',
		array(
			'no_links'   => ! empty( $cobble_template_args['no_links'] ),
			'hover'      => $cobble_hover,
			'meta_parts' => $cobble_components,
			'thumb_size' => ! empty( $cobble_template_args['thumb_size'] )
							? $cobble_template_args['thumb_size']
							: cobble_get_thumb_size( strpos( cobble_get_theme_option( 'body_style' ), 'full' ) !== false
								? 'full'
								: ( $cobble_expanded 
									? 'huge' 
									: 'big' 
									)
								),
		),
		'content-excerpt',
		$cobble_template_args
	) );

	// Title and post meta
	$cobble_show_title = get_the_title() != '';
	$cobble_show_meta  = count( $cobble_components ) > 0 && ! in_array( $cobble_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );

	if ( $cobble_show_title ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			if ( apply_filters( 'cobble_filter_show_blog_title', true, 'excerpt' ) ) {
				do_action( 'cobble_action_before_post_title' );
				if ( empty( $cobble_template_args['no_links'] ) ) {
					the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
				} else {
					the_title( '<h3 class="post_title entry-title">', '</h3>' );
				}
				do_action( 'cobble_action_after_post_title' );
			}
			?>
		</div><!-- .post_header -->
		<?php
	}

	// Post content
	if ( apply_filters( 'cobble_filter_show_blog_excerpt', empty( $cobble_template_args['hide_excerpt'] ) && cobble_get_theme_option( 'excerpt_length' ) > 0, 'excerpt' ) ) {
		?>
		<div class="post_content entry-content">
			<?php

			// Post meta
			if ( apply_filters( 'cobble_filter_show_blog_meta', $cobble_show_meta, $cobble_components, 'excerpt' ) ) {
				if ( count( $cobble_components ) > 0 ) {
					do_action( 'cobble_action_before_post_meta' );
					cobble_show_post_meta(
						apply_filters(
							'cobble_filter_post_meta_args', array(
								'components' => join( ',', $cobble_components ),
								'seo'        => false,
								'echo'       => true,
							), 'excerpt', 1
						)
					);
					do_action( 'cobble_action_after_post_meta' );
				}
			}

			if ( cobble_get_theme_option( 'blog_content' ) == 'fullpost' ) {
				// Post content area
				?>
				<div class="post_content_inner">
					<?php
					do_action( 'cobble_action_before_full_post_content' );
					the_content( '' );
					do_action( 'cobble_action_after_full_post_content' );
					?>
				</div>
				<?php
				// Inner pages
				wp_link_pages(
					array(
						'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'cobble' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
						'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'cobble' ) . ' </span>%',
						'separator'   => '<span class="screen-reader-text">, </span>',
					)
				);
			} else {
				// Post content area
				cobble_show_post_content( $cobble_template_args, '<div class="post_content_inner">', '</div>' );
			}

			// More button
			if ( apply_filters( 'cobble_filter_show_blog_readmore',  ! isset( $cobble_template_args['more_button'] ) || ! empty( $cobble_template_args['more_button'] ), 'excerpt' ) ) {
				if ( empty( $cobble_template_args['no_links'] ) ) {
					do_action( 'cobble_action_before_post_readmore' );
					if ( cobble_get_theme_option( 'blog_content' ) != 'fullpost' ) {
						cobble_show_post_more_link( $cobble_template_args, '<p>', '</p>' );
					} else {
						cobble_show_post_comments_link( $cobble_template_args, '<p>', '</p>' );
					}
					do_action( 'cobble_action_after_post_readmore' );
				}
			}

			?>
		</div><!-- .entry-content -->
		<?php
	}
	?>
</article>
<?php

if ( is_array( $cobble_template_args ) ) {
	if ( ! empty( $cobble_template_args['slider'] ) || $cobble_columns > 1 ) {
		?>
		</div>
		<?php
	}
}
