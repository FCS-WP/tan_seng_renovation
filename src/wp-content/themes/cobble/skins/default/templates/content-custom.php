<?php
/**
 * The custom template to display the content
 *
 * Used for index/archive/search.
 *
 * @package COBBLE
 * @since COBBLE 1.0.50
 */

$cobble_template_args = get_query_var( 'cobble_template_args' );
if ( is_array( $cobble_template_args ) ) {
	$cobble_columns    = empty( $cobble_template_args['columns'] ) ? 2 : max( 1, $cobble_template_args['columns'] );
	$cobble_blog_style = array( $cobble_template_args['type'], $cobble_columns );
} else {
	$cobble_template_args = array();
	$cobble_blog_style = explode( '_', cobble_get_theme_option( 'blog_style' ) );
	$cobble_columns    = empty( $cobble_blog_style[1] ) ? 2 : max( 1, $cobble_blog_style[1] );
}
$cobble_blog_id       = cobble_get_custom_blog_id( join( '_', $cobble_blog_style ) );
$cobble_blog_style[0] = str_replace( 'blog-custom-', '', $cobble_blog_style[0] );
$cobble_expanded      = ! cobble_sidebar_present() && cobble_get_theme_option( 'expand_content' ) == 'expand';
$cobble_components    = ! empty( $cobble_template_args['meta_parts'] )
							? ( is_array( $cobble_template_args['meta_parts'] )
								? join( ',', $cobble_template_args['meta_parts'] )
								: $cobble_template_args['meta_parts']
								)
							: cobble_array_get_keys_by_value( cobble_get_theme_option( 'meta_parts' ) );
$cobble_post_format   = get_post_format();
$cobble_post_format   = empty( $cobble_post_format ) ? 'standard' : str_replace( 'post-format-', '', $cobble_post_format );

$cobble_blog_meta     = cobble_get_custom_layout_meta( $cobble_blog_id );
$cobble_custom_style  = ! empty( $cobble_blog_meta['scripts_required'] ) ? $cobble_blog_meta['scripts_required'] : 'none';

if ( ! empty( $cobble_template_args['slider'] ) || $cobble_columns > 1 || ! cobble_is_off( $cobble_custom_style ) ) {
	?><div class="
		<?php
		if ( ! empty( $cobble_template_args['slider'] ) ) {
			echo 'slider-slide swiper-slide';
		} else {
			echo esc_attr( ( cobble_is_off( $cobble_custom_style ) ? 'column' : sprintf( '%1$s_item %1$s_item', $cobble_custom_style ) ) . "-1_{$cobble_columns}" );
		}
		?>
	">
	<?php
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
			'post_item post_item_container post_format_' . esc_attr( $cobble_post_format )
					. ' post_layout_custom post_layout_custom_' . esc_attr( $cobble_columns )
					. ' post_layout_' . esc_attr( $cobble_blog_style[0] )
					. ' post_layout_' . esc_attr( $cobble_blog_style[0] ) . '_' . esc_attr( $cobble_columns )
					. ( ! cobble_is_off( $cobble_custom_style )
						? ' post_layout_' . esc_attr( $cobble_custom_style )
							. ' post_layout_' . esc_attr( $cobble_custom_style ) . '_' . esc_attr( $cobble_columns )
						: ''
						)
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
	// Custom layout
	do_action( 'cobble_action_show_layout', $cobble_blog_id, get_the_ID() );
	?>
</article><?php
if ( ! empty( $cobble_template_args['slider'] ) || $cobble_columns > 1 || ! cobble_is_off( $cobble_custom_style ) ) {
	?></div><?php
	// Need opening PHP-tag above just after </div>, because <div> is a inline-block element (used as column)!
}
