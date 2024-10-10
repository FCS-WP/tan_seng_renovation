<?php
/**
 * The Header: Logo and main menu
 *
 * @package COBBLE
 * @since COBBLE 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js<?php
	// Class scheme_xxx need in the <html> as context for the <body>!
	echo ' scheme_' . esc_attr( cobble_get_theme_option( 'color_scheme' ) );
?>">

<head>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else {
		do_action( 'wp_body_open' );
	}
	do_action( 'cobble_action_before_body' );
	?>

	<div class="<?php echo esc_attr( apply_filters( 'cobble_filter_body_wrap_class', 'body_wrap' ) ); ?>" <?php do_action('cobble_action_body_wrap_attributes'); ?>>

		<?php do_action( 'cobble_action_before_page_wrap' ); ?>

		<div class="<?php echo esc_attr( apply_filters( 'cobble_filter_page_wrap_class', 'page_wrap' ) ); ?>" <?php do_action('cobble_action_page_wrap_attributes'); ?>>

			<?php do_action( 'cobble_action_page_wrap_start' ); ?>

			<?php
			$cobble_full_post_loading = ( cobble_is_singular( 'post' ) || cobble_is_singular( 'attachment' ) ) && cobble_get_value_gp( 'action' ) == 'full_post_loading';
			$cobble_prev_post_loading = ( cobble_is_singular( 'post' ) || cobble_is_singular( 'attachment' ) ) && cobble_get_value_gp( 'action' ) == 'prev_post_loading';

			// Don't display the header elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ! $cobble_full_post_loading && ! $cobble_prev_post_loading ) {

				// Short links to fast access to the content, sidebar and footer from the keyboard
				?>
				<a class="cobble_skip_link skip_to_content_link" href="#content_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'cobble_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to content", 'cobble' ); ?></a>
				<?php if ( cobble_sidebar_present() ) { ?>
				<a class="cobble_skip_link skip_to_sidebar_link" href="#sidebar_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'cobble_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to sidebar", 'cobble' ); ?></a>
				<?php } ?>
				<a class="cobble_skip_link skip_to_footer_link" href="#footer_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'cobble_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to footer", 'cobble' ); ?></a>

				<?php
				do_action( 'cobble_action_before_header' );

				// Header
				$cobble_header_type = cobble_get_theme_option( 'header_type' );
				if ( 'custom' == $cobble_header_type && ! cobble_is_layouts_available() ) {
					$cobble_header_type = 'default';
				}
				get_template_part( apply_filters( 'cobble_filter_get_template_part', "templates/header-" . sanitize_file_name( $cobble_header_type ) ) );

				// Side menu
				if ( in_array( cobble_get_theme_option( 'menu_side' ), array( 'left', 'right' ) ) ) {
					get_template_part( apply_filters( 'cobble_filter_get_template_part', 'templates/header-navi-side' ) );
				}

				// Mobile menu
				get_template_part( apply_filters( 'cobble_filter_get_template_part', 'templates/header-navi-mobile' ) );

				do_action( 'cobble_action_after_header' );

			}
			?>

			<?php do_action( 'cobble_action_before_page_content_wrap' ); ?>

			<div class="page_content_wrap<?php
				if ( cobble_is_off( cobble_get_theme_option( 'remove_margins' ) ) ) {
					if ( empty( $cobble_header_type ) ) {
						$cobble_header_type = cobble_get_theme_option( 'header_type' );
					}
					if ( 'custom' == $cobble_header_type && cobble_is_layouts_available() ) {
						$cobble_header_id = cobble_get_custom_header_id();
						if ( $cobble_header_id > 0 ) {
							$cobble_header_meta = cobble_get_custom_layout_meta( $cobble_header_id );
							if ( ! empty( $cobble_header_meta['margin'] ) ) {
								?> page_content_wrap_custom_header_margin<?php
							}
						}
					}
					$cobble_footer_type = cobble_get_theme_option( 'footer_type' );
					if ( 'custom' == $cobble_footer_type && cobble_is_layouts_available() ) {
						$cobble_footer_id = cobble_get_custom_footer_id();
						if ( $cobble_footer_id ) {
							$cobble_footer_meta = cobble_get_custom_layout_meta( $cobble_footer_id );
							if ( ! empty( $cobble_footer_meta['margin'] ) ) {
								?> page_content_wrap_custom_footer_margin<?php
							}
						}
					}
				}
				do_action( 'cobble_action_page_content_wrap_class', $cobble_prev_post_loading );
				?>"<?php
				if ( apply_filters( 'cobble_filter_is_prev_post_loading', $cobble_prev_post_loading ) ) {
					?> data-single-style="<?php echo esc_attr( cobble_get_theme_option( 'single_style' ) ); ?>"<?php
				}
				do_action( 'cobble_action_page_content_wrap_data', $cobble_prev_post_loading );
			?>>
				<?php
				do_action( 'cobble_action_page_content_wrap', $cobble_full_post_loading || $cobble_prev_post_loading );

				// Single posts banner
				if ( apply_filters( 'cobble_filter_single_post_header', cobble_is_singular( 'post' ) || cobble_is_singular( 'attachment' ) ) ) {
					if ( $cobble_prev_post_loading ) {
						if ( cobble_get_theme_option( 'posts_navigation_scroll_which_block' ) != 'article' ) {
							do_action( 'cobble_action_between_posts' );
						}
					}
					// Single post thumbnail and title
					$cobble_path = apply_filters( 'cobble_filter_get_template_part', 'templates/single-styles/' . cobble_get_theme_option( 'single_style' ) );
					if ( cobble_get_file_dir( $cobble_path . '.php' ) != '' ) {
						get_template_part( $cobble_path );
					}
				}

				// Widgets area above page
				$cobble_body_style   = cobble_get_theme_option( 'body_style' );
				$cobble_widgets_name = cobble_get_theme_option( 'widgets_above_page' );
				$cobble_show_widgets = ! cobble_is_off( $cobble_widgets_name ) && is_active_sidebar( $cobble_widgets_name );
				if ( $cobble_show_widgets ) {
					if ( 'fullscreen' != $cobble_body_style ) {
						?>
						<div class="content_wrap">
							<?php
					}
					cobble_create_widgets_area( 'widgets_above_page' );
					if ( 'fullscreen' != $cobble_body_style ) {
						?>
						</div>
						<?php
					}
				}

				// Content area
				do_action( 'cobble_action_before_content_wrap' );
				?>
				<div class="content_wrap<?php echo 'fullscreen' == $cobble_body_style ? '_fullscreen' : ''; ?>">

					<?php do_action( 'cobble_action_content_wrap_start' ); ?>

					<div class="content">
						<?php
						do_action( 'cobble_action_page_content_start' );

						// Skip link anchor to fast access to the content from keyboard
						?>
						<a id="content_skip_link_anchor" class="cobble_skip_link_anchor" href="#"></a>
						<?php
						// Single posts banner between prev/next posts
						if ( ( cobble_is_singular( 'post' ) || cobble_is_singular( 'attachment' ) )
							&& $cobble_prev_post_loading 
							&& cobble_get_theme_option( 'posts_navigation_scroll_which_block' ) == 'article'
						) {
							do_action( 'cobble_action_between_posts' );
						}

						// Widgets area above content
						cobble_create_widgets_area( 'widgets_above_content' );

						do_action( 'cobble_action_page_content_start_text' );
