<?php
/**
 * The Portfolio template to display the content
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

$cobble_post_format = get_post_format();
$cobble_post_format = empty( $cobble_post_format ) ? 'standard' : str_replace( 'post-format-', '', $cobble_post_format );

?><div class="
<?php
if ( ! empty( $cobble_template_args['slider'] ) ) {
	echo ' slider-slide swiper-slide';
} else {
	echo ( cobble_is_blog_style_use_masonry( $cobble_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $cobble_columns ) : esc_attr( $cobble_columns_class ));
}
?>
"><article id="post-<?php the_ID(); ?>" 
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $cobble_post_format )
		. ' post_layout_portfolio'
		. ' post_layout_portfolio_' . esc_attr( $cobble_columns )
		. ( 'portfolio' != $cobble_blog_style[0] ? ' ' . esc_attr( $cobble_blog_style[0] )  . '_' . esc_attr( $cobble_columns ) : '' )
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

	$cobble_hover   = ! empty( $cobble_template_args['hover'] ) && ! cobble_is_inherit( $cobble_template_args['hover'] )
								? $cobble_template_args['hover']
								: cobble_get_theme_option( 'image_hover' );

	if ( 'dots' == $cobble_hover ) {
		$cobble_post_link = empty( $cobble_template_args['no_links'] )
								? ( ! empty( $cobble_template_args['link'] )
									? $cobble_template_args['link']
									: get_permalink()
									)
								: '';
		$cobble_target    = ! empty( $cobble_post_link ) && false === strpos( $cobble_post_link, home_url() )
								? ' target="_blank" rel="nofollow"'
								: '';
	}
	
	// Meta parts
	$cobble_components = ! empty( $cobble_template_args['meta_parts'] )
							? ( is_array( $cobble_template_args['meta_parts'] )
								? $cobble_template_args['meta_parts']
								: explode( ',', $cobble_template_args['meta_parts'] )
								)
							: cobble_array_get_keys_by_value( cobble_get_theme_option( 'meta_parts' ) );

	// Featured image
	cobble_show_post_featured( apply_filters( 'cobble_filter_args_featured',
        array(
			'hover'         => $cobble_hover,
			'no_links'      => ! empty( $cobble_template_args['no_links'] ),
			'thumb_size'    => ! empty( $cobble_template_args['thumb_size'] )
								? $cobble_template_args['thumb_size']
								: cobble_get_thumb_size(
									cobble_is_blog_style_use_masonry( $cobble_blog_style[0] )
										? (	strpos( cobble_get_theme_option( 'body_style' ), 'full' ) !== false || $cobble_columns < 3
											? 'masonry-big'
											: 'masonry'
											)
										: (	strpos( cobble_get_theme_option( 'body_style' ), 'full' ) !== false || $cobble_columns < 3
											? 'square'
											: 'square'
											)
								),
			'thumb_bg' => cobble_is_blog_style_use_masonry( $cobble_blog_style[0] ) ? false : true,
			'show_no_image' => true,
			'meta_parts'    => $cobble_components,
			'class'         => 'dots' == $cobble_hover ? 'hover_with_info' : '',
			'post_info'     => 'dots' == $cobble_hover
										? '<div class="post_info"><h5 class="post_title">'
											. ( ! empty( $cobble_post_link )
												? '<a href="' . esc_url( $cobble_post_link ) . '"' . ( ! empty( $target ) ? $target : '' ) . '>'
												: ''
												)
												. esc_html( get_the_title() ) 
											. ( ! empty( $cobble_post_link )
												? '</a>'
												: ''
												)
											. '</h5></div>'
										: '',
            'thumb_ratio'   => 'info' == $cobble_hover ?  '100:102' : '',
        ),
        'content-portfolio',
        $cobble_template_args
    ) );
	?>
</article></div><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!