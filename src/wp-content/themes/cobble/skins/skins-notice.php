<?php
/**
 * The template to display Admin notices
 *
 * @package COBBLE
 * @since COBBLE 1.0.64
 */

$cobble_skins_url  = get_admin_url( null, 'admin.php?page=trx_addons_theme_panel#trx_addons_theme_panel_section_skins' );
$cobble_skins_args = get_query_var( 'cobble_skins_notice_args' );
?>
<div class="cobble_admin_notice cobble_skins_notice notice notice-info is-dismissible" data-notice="skins">
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
		<?php esc_html_e( 'New skins are available', 'cobble' ); ?>
	</h3>
	<?php

	// Description
	$cobble_total      = $cobble_skins_args['update'];	// Store value to the separate variable to avoid warnings from ThemeCheck plugin!
	$cobble_skins_msg  = $cobble_total > 0
							// Translators: Add new skins number
							? '<strong>' . sprintf( _n( '%d new version', '%d new versions', $cobble_total, 'cobble' ), $cobble_total ) . '</strong>'
							: '';
	$cobble_total      = $cobble_skins_args['free'];
	$cobble_skins_msg .= $cobble_total > 0
							? ( ! empty( $cobble_skins_msg ) ? ' ' . esc_html__( 'and', 'cobble' ) . ' ' : '' )
								// Translators: Add new skins number
								. '<strong>' . sprintf( _n( '%d free skin', '%d free skins', $cobble_total, 'cobble' ), $cobble_total ) . '</strong>'
							: '';
	$cobble_total      = $cobble_skins_args['pay'];
	$cobble_skins_msg .= $cobble_skins_args['pay'] > 0
							? ( ! empty( $cobble_skins_msg ) ? ' ' . esc_html__( 'and', 'cobble' ) . ' ' : '' )
								// Translators: Add new skins number
								. '<strong>' . sprintf( _n( '%d paid skin', '%d paid skins', $cobble_total, 'cobble' ), $cobble_total ) . '</strong>'
							: '';
	?>
	<div class="cobble_notice_text">
		<p>
			<?php
			// Translators: Add new skins info
			echo wp_kses_data( sprintf( __( "We are pleased to announce that %s are available for your theme", 'cobble' ), $cobble_skins_msg ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="cobble_notice_buttons">
		<?php
		// Link to the theme dashboard page
		?>
		<a href="<?php echo esc_url( $cobble_skins_url ); ?>" class="button button-primary"><i class="dashicons dashicons-update"></i> 
			<?php
			// Translators: Add theme name
			esc_html_e( 'Go to Skins manager', 'cobble' );
			?>
		</a>
	</div>
</div>
