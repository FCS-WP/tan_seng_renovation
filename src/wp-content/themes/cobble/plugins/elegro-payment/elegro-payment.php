<?php
/* Elegro Crypto Payment support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'cobble_elegro_payment_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'cobble_elegro_payment_theme_setup9', 9 );
	function cobble_elegro_payment_theme_setup9() {
		if ( cobble_exists_elegro_payment() ) {
			add_action( 'wp_enqueue_scripts', 'cobble_elegro_payment_frontend_scripts', 1100 );
			add_action( 'trx_addons_action_load_scripts_front_elegro_payment', 'cobble_elegro_payment_frontend_scripts', 10, 1 );
			add_filter( 'cobble_filter_merge_styles', 'cobble_elegro_payment_merge_styles' );
		}
		if ( is_admin() ) {
			add_filter( 'cobble_filter_tgmpa_required_plugins', 'cobble_elegro_payment_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'cobble_elegro_payment_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('cobble_filter_tgmpa_required_plugins',	'cobble_elegro_payment_tgmpa_required_plugins');
	function cobble_elegro_payment_tgmpa_required_plugins( $list = array() ) {
		if ( cobble_storage_isset( 'required_plugins', 'woocommerce' ) && cobble_storage_isset( 'required_plugins', 'elegro-payment' ) && cobble_storage_get_array( 'required_plugins', 'elegro-payment', 'install' ) !== false ) {
			$list[] = array(
				'name'     => cobble_storage_get_array( 'required_plugins', 'elegro-payment', 'title' ),
				'slug'     => 'elegro-payment',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if this plugin installed and activated
if ( ! function_exists( 'cobble_exists_elegro_payment' ) ) {
	function cobble_exists_elegro_payment() {
		return class_exists( 'WC_Elegro_Payment' );
	}
}


// Enqueue styles for frontend
if ( ! function_exists( 'cobble_elegro_payment_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'cobble_elegro_payment_frontend_scripts', 1100 );
	//Handler of the add_action( 'trx_addons_action_load_scripts_front_elegro_payment', 'cobble_elegro_payment_frontend_scripts', 10, 1 );
	function cobble_elegro_payment_frontend_scripts( $force = false ) {
		cobble_enqueue_optimized( 'elegro_payment', $force, array(
			'css' => array(
				'cobble-elegro-payment' => array( 'src' => 'plugins/elegro-payment/elegro-payment.css' ),
			)
		) );
	}
}

// Merge custom styles
if ( ! function_exists( 'cobble_elegro_payment_merge_styles' ) ) {
	//Handler of the add_filter('cobble_filter_merge_styles', 'cobble_elegro_payment_merge_styles');
	function cobble_elegro_payment_merge_styles( $list ) {
		$list[ 'plugins/elegro-payment/elegro-payment.css' ] = false;
		return $list;
	}
}
