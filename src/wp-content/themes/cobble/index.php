<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: //codex.wordpress.org/Template_Hierarchy
 *
 * @package COBBLE
 * @since COBBLE 1.0
 */

$cobble_template = apply_filters( 'cobble_filter_get_template_part', cobble_blog_archive_get_template() );

if ( ! empty( $cobble_template ) && 'index' != $cobble_template ) {

	get_template_part( $cobble_template );

} else {

	cobble_storage_set( 'blog_archive', true );

	get_header();

	if ( have_posts() ) {

		// Query params
		$cobble_stickies   = is_home()
								|| ( in_array( cobble_get_theme_option( 'post_type' ), array( '', 'post' ) )
									&& (int) cobble_get_theme_option( 'parent_cat' ) == 0
									)
										? get_option( 'sticky_posts' )
										: false;
		$cobble_post_type  = cobble_get_theme_option( 'post_type' );
		$cobble_args       = array(
								'blog_style'     => cobble_get_theme_option( 'blog_style' ),
								'post_type'      => $cobble_post_type,
								'taxonomy'       => cobble_get_post_type_taxonomy( $cobble_post_type ),
								'parent_cat'     => cobble_get_theme_option( 'parent_cat' ),
								'posts_per_page' => cobble_get_theme_option( 'posts_per_page' ),
								'sticky'         => cobble_get_theme_option( 'sticky_style' ) == 'columns'
															&& is_array( $cobble_stickies )
															&& count( $cobble_stickies ) > 0
															&& get_query_var( 'paged' ) < 1
								);

		cobble_blog_archive_start();

		do_action( 'cobble_action_blog_archive_start' );

		if ( is_author() ) {
			do_action( 'cobble_action_before_page_author' );
			get_template_part( apply_filters( 'cobble_filter_get_template_part', 'templates/author-page' ) );
			do_action( 'cobble_action_after_page_author' );
		}

		if ( cobble_get_theme_option( 'show_filters' ) ) {
			do_action( 'cobble_action_before_page_filters' );
			cobble_show_filters( $cobble_args );
			do_action( 'cobble_action_after_page_filters' );
		} else {
			do_action( 'cobble_action_before_page_posts' );
			cobble_show_posts( array_merge( $cobble_args, array( 'cat' => $cobble_args['parent_cat'] ) ) );
			do_action( 'cobble_action_after_page_posts' );
		}

		do_action( 'cobble_action_blog_archive_end' );

		cobble_blog_archive_end();

	} else {

		if ( is_search() ) {
			get_template_part( apply_filters( 'cobble_filter_get_template_part', 'templates/content', 'none-search' ), 'none-search' );
		} else {
			get_template_part( apply_filters( 'cobble_filter_get_template_part', 'templates/content', 'none-archive' ), 'none-archive' );
		}
	}

	get_footer();
}
