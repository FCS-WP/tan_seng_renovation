<?php
/**
 * The template to display Admin notices
 *
 * @package COBBLE
 * @since COBBLE 1.0.1
 */

$cobble_theme_slug = get_option( 'template' );
$cobble_theme_obj  = wp_get_theme( $cobble_theme_slug );
?>
<div class="cobble_admin_notice cobble_welcome_notice notice notice-info is-dismissible" data-notice="admin">
	<?php
	// Theme image
	$cobble_theme_img = cobble_get_file_url( 'screenshot.jpg' );
	if ( '' != $cobble_theme_img ) {
		?>
		<div class="cobble_notice_image"><img src="<?php echo esc_url( $cobble_theme_img ); ?>" alt="<?php esc_attr_e( 'Theme screenshot', 'cobble' ); ?>"></div>
		<?php
	}

	// Title
	?>
	<h3 class="cobble_notice_title">
		<?php
		echo esc_html(
			sprintf(
				// Translators: Add theme name and version to the 'Welcome' message
				__( 'Welcome to %1$s v.%2$s', 'cobble' ),
				$cobble_theme_obj->get( 'Name' ) . ( COBBLE_THEME_FREE ? ' ' . __( 'Free', 'cobble' ) : '' ),
				$cobble_theme_obj->get( 'Version' )
			)
		);
		?>
	</h3>
	<?php

	// Description
	?>
	<div class="cobble_notice_text">
		<p class="cobble_notice_text_description">
			<?php
			echo str_replace( '. ', '.<br>', wp_kses_data( $cobble_theme_obj->description ) );
			?>
		</p>
		<p class="cobble_notice_text_info">
			<?php
			echo wp_kses_data( __( 'Attention! Plugin "ThemeREX Addons" is required! Please, install and activate it!', 'cobble' ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="cobble_notice_buttons">
		<?php
		// Link to the page 'About Theme'
		?>
		<a href="<?php echo esc_url( admin_url() . 'themes.php?page=cobble_about' ); ?>" class="button button-primary"><i class="dashicons dashicons-nametag"></i> 
			<?php
			echo esc_html__( 'Install plugin "ThemeREX Addons"', 'cobble' );
			?>
		</a>
	</div>
</div>
