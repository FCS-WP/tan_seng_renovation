<?php
/**
 * The Classic template to display the content
 *
 * Used for index/archive/search.
 *
 * @package COBBLE
 * @since COBBLE 1.0
 */

$cobble_template_args = get_query_var( 'cobble_template_args' );

if ( is_array( $cobble_template_args ) ) {
	$cobble_columns    = empty( $cobble_template_args['columns'] ) ? 2 : max( 1, $cobble_template_args['columns'] );
	$cobble_blog_style = array( $cobble_template_args['type'], $cobble_columns );
    $cobble_columns_class = cobble_get_column_class( 1, $cobble_columns, ! empty( $cobble_template_args['columns_tablet']) ? $cobble_template_args['columns_tablet'] : '', ! empty($cobble_template_args['columns_mobile']) ? $cobble_template_args['columns_mobile'] : '' );
} else {
	$cobble_template_args = array();
	$cobble_blog_style = explode( '_', cobble_get_theme_option( 'blog_style' ) );
	$cobble_columns    = empty( $cobble_blog_style[1] ) ? 2 : max( 1, $cobble_blog_style[1] );
    $cobble_columns_class = cobble_get_column_class( 1, $cobble_columns );
}
$cobble_expanded   = ! cobble_sidebar_present() && cobble_get_theme_option( 'expand_content' ) == 'expand';

$cobble_post_format = get_post_format();
$cobble_post_format = empty( $cobble_post_format ) ? 'standard' : str_replace( 'post-format-', '', $cobble_post_format );

?><div class="<?php
	if ( ! empty( $cobble_template_args['slider'] ) ) {
		echo ' slider-slide swiper-slide';
	} else {
		echo ( cobble_is_blog_style_use_masonry( $cobble_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $cobble_columns ) : esc_attr( $cobble_columns_class ) );
	}
?>"><article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $cobble_post_format )
				. ' post_layout_classic post_layout_classic_' . esc_attr( $cobble_columns )
				. ' post_layout_' . esc_attr( $cobble_blog_style[0] )
				. ' post_layout_' . esc_attr( $cobble_blog_style[0] ) . '_' . esc_attr( $cobble_columns )
	);
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
								: explode( ',', $cobble_template_args['meta_parts'] )
								)
							: cobble_array_get_keys_by_value( cobble_get_theme_option( 'meta_parts' ) );

	cobble_show_post_featured( apply_filters( 'cobble_filter_args_featured',
		array(
			'thumb_size' => ! empty( $cobble_template_args['thumb_size'] )
				? $cobble_template_args['thumb_size']
				: cobble_get_thumb_size(
					'classic' == $cobble_blog_style[0]
						? ( strpos( cobble_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $cobble_columns > 2 ? 'big' : 'huge' )
								: ( $cobble_columns > 2
									? ( $cobble_expanded ? 'square' : 'square' )
									: ($cobble_columns > 1 ? 'square' : ( $cobble_expanded ? 'huge' : 'big' ))
									)
							)
						: ( strpos( cobble_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $cobble_columns > 2 ? 'masonry-big' : 'full' )
								: ($cobble_columns === 1 ? ( $cobble_expanded ? 'huge' : 'big' ) : ( $cobble_columns <= 2 && $cobble_expanded ? 'masonry-big' : 'masonry' ))
							)
			),
			'hover'      => $cobble_hover,
			'meta_parts' => $cobble_components,
			'no_links'   => ! empty( $cobble_template_args['no_links'] ),
        ),
        'content-classic',
        $cobble_template_args
    ) );

	// Title and post meta
	$cobble_show_title = get_the_title() != '';
	$cobble_show_meta  = count( $cobble_components ) > 0 && ! in_array( $cobble_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );

	if ( $cobble_show_title ) {
		?>
		<div class="post_header entry-header">
			<?php

			// Post meta
			if ( apply_filters( 'cobble_filter_show_blog_meta', $cobble_show_meta, $cobble_components, 'classic' ) ) {
				if ( count( $cobble_components ) > 0 ) {
					do_action( 'cobble_action_before_post_meta' );
					cobble_show_post_meta(
						apply_filters(
							'cobble_filter_post_meta_args', array(
							'components' => join( ',', $cobble_components ),
							'seo'        => false,
							'echo'       => true,
						), $cobble_blog_style[0], $cobble_columns
						)
					);
					do_action( 'cobble_action_after_post_meta' );
				}
			}

			// Post title
			if ( apply_filters( 'cobble_filter_show_blog_title', true, 'classic' ) ) {
				do_action( 'cobble_action_before_post_title' );
				if ( empty( $cobble_template_args['no_links'] ) ) {
					the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
				} else {
					the_title( '<h4 class="post_title entry-title">', '</h4>' );
				}
				do_action( 'cobble_action_after_post_title' );
			}

			if( !in_array( $cobble_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
				// More button
				if ( apply_filters( 'cobble_filter_show_blog_readmore', ! $cobble_show_title || ! empty( $cobble_template_args['more_button'] ), 'classic' ) ) {
					if ( empty( $cobble_template_args['no_links'] ) ) {
						do_action( 'cobble_action_before_post_readmore' );
						cobble_show_post_more_link( $cobble_template_args, '<div class="more-wrap">', '</div>' );
						do_action( 'cobble_action_after_post_readmore' );
					}
				}
			}
			?>
		</div><!-- .entry-header -->
		<?php
	}

	// Post content
	if( in_array( $cobble_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
		ob_start();
		if (apply_filters('cobble_filter_show_blog_excerpt', empty($cobble_template_args['hide_excerpt']) && cobble_get_theme_option('excerpt_length') > 0, 'classic')) {
			cobble_show_post_content($cobble_template_args, '<div class="post_content_inner">', '</div>');
		}
		// More button
		if(! empty( $cobble_template_args['more_button'] )) {
			if ( empty( $cobble_template_args['no_links'] ) ) {
				do_action( 'cobble_action_before_post_readmore' );
				cobble_show_post_more_link( $cobble_template_args, '<div class="more-wrap">', '</div>' );
				do_action( 'cobble_action_after_post_readmore' );
			}
		}
		$cobble_content = ob_get_contents();
		ob_end_clean();
		cobble_show_layout($cobble_content, '<div class="post_content entry-content">', '</div><!-- .entry-content -->');
	}
	?>

</article></div><?php
// Need opening PHP-tag above, because <div> is a inline-block element (used as column)!
