<?php
/* WPC Smart Quick View for WooCommerce support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('cobble_quick_view_theme_setup9')) {
	add_action( 'after_setup_theme', 'cobble_quick_view_theme_setup9', 9 );
	function cobble_quick_view_theme_setup9() {
		if (cobble_exists_quick_view()) {
			add_action( 'wp_enqueue_scripts', 'cobble_quick_view_frontend_scripts', 1100 );
			add_filter( 'cobble_filter_merge_styles', 'cobble_quick_view_merge_styles' );
		}
		if (is_admin()) {
			add_filter( 'cobble_filter_tgmpa_required_plugins',		'cobble_quick_view_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'cobble_quick_view_tgmpa_required_plugins' ) ) {
	function cobble_quick_view_tgmpa_required_plugins($list=array()) {
		if (cobble_storage_isset( 'required_plugins', 'woocommerce' ) && cobble_storage_get_array( 'required_plugins', 'woocommerce', 'install' ) !== false &&
			cobble_storage_isset('required_plugins', 'woo-smart-quick-view') && cobble_storage_get_array( 'required_plugins', 'woo-smart-quick-view', 'install' ) !== false) {
			$list[] = array(
				'name' 		=> cobble_storage_get_array('required_plugins', 'woo-smart-quick-view', 'title'),
				'slug' 		=> 'woo-smart-quick-view',
				'required' 	=> false
			);
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'cobble_exists_quick_view' ) ) {
	function cobble_exists_quick_view() {
		return function_exists('woosq_init');
	}
}

// Enqueue custom scripts
if ( ! function_exists( 'cobble_quick_view_frontend_scripts' ) ) {
	function cobble_quick_view_frontend_scripts() {
		if ( cobble_is_on( cobble_get_theme_option( 'debug_mode' ) ) ) {
			$cobble_url = cobble_get_file_url( 'plugins/woo-smart-quick-view/woo-smart-quick-view.css' );
			if ( '' != $cobble_url ) {
				wp_enqueue_style( 'cobble-woo-smart-quick-view', $cobble_url, array(), null );
			}
		}
	}
}

// Merge custom styles
if ( ! function_exists( 'cobble_quick_view_merge_styles' ) ) {
	function cobble_quick_view_merge_styles( $list ) {
		$list['plugins/woo-smart-quick-view/woo-smart-quick-view.css'] = true;
		return $list;
	}
}

// Add plugin-specific colors and fonts to the custom CSS
if ( cobble_exists_quick_view() ) {
	require_once cobble_get_file_dir( 'plugins/woo-smart-quick-view/woo-smart-quick-view-style.php' );
}


// One-click import support
//------------------------------------------------------------------------

// Check plugin in the required plugins
if ( !function_exists( 'cobble_quick_view_importer_required_plugins' ) ) {
    if (is_admin()) add_filter( 'trx_addons_filter_importer_required_plugins',	'cobble_quick_view_importer_required_plugins', 10, 2 );
    function cobble_quick_view_importer_required_plugins($not_installed='', $list='') {
        if (strpos($list, 'woo-smart-quick-view')!==false && !cobble_exists_quick_view() )
            $not_installed .= '<br>' . esc_html__('WPC Smart Quick View for WooCommerce', 'cobble');
        return $not_installed;
    }
}

// Set plugin's specific importer options
if ( !function_exists( 'cobble_quick_view_importer_set_options' ) ) {
    if (is_admin()) add_filter( 'trx_addons_filter_importer_options',	'cobble_quick_view_importer_set_options' );
    function cobble_quick_view_importer_set_options($options=array()) {
        if ( cobble_exists_quick_view() && in_array('woo-smart-quick-view', $options['required_plugins']) ) {
            $options['additional_options'][] = 'woosq_%';
        }
        return $options;
    }
}