<?php
/* QuickCal support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'cobble_quickcal_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'cobble_quickcal_theme_setup9', 9 );
	function cobble_quickcal_theme_setup9() {
		if ( cobble_exists_quickcal() ) {
			add_action( 'wp_enqueue_scripts', 'cobble_quickcal_frontend_scripts', 1100 );
			add_action( 'trx_addons_action_load_scripts_front_quickcal', 'cobble_quickcal_frontend_scripts', 10, 1 );
			add_action( 'wp_enqueue_scripts', 'cobble_quickcal_frontend_scripts_responsive', 2000 );
			add_action( 'trx_addons_action_load_scripts_front_quickcal', 'cobble_quickcal_frontend_scripts_responsive', 10, 1 );
			add_filter( 'cobble_filter_merge_styles', 'cobble_quickcal_merge_styles' );
			add_filter( 'cobble_filter_merge_styles_responsive', 'cobble_quickcal_merge_styles_responsive' );
		}
		if ( is_admin() ) {
			add_filter( 'cobble_filter_tgmpa_required_plugins', 'cobble_quickcal_tgmpa_required_plugins' );
			add_filter( 'cobble_filter_theme_plugins', 'cobble_quickcal_theme_plugins' );
		}
	}
}


// Filter to add in the required plugins list
if ( ! function_exists( 'cobble_quickcal_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('cobble_filter_tgmpa_required_plugins',	'cobble_quickcal_tgmpa_required_plugins');
	function cobble_quickcal_tgmpa_required_plugins( $list = array() ) {
		if ( cobble_storage_isset( 'required_plugins', 'quickcal' ) && cobble_storage_get_array( 'required_plugins', 'quickcal', 'install' ) !== false && cobble_is_theme_activated() ) {
			$path = cobble_get_plugin_source_path( 'plugins/quickcal/quickcal.zip' );
			if ( ! empty( $path ) || cobble_get_theme_setting( 'tgmpa_upload' ) ) {
				$list[] = array(
					'name'     => cobble_storage_get_array( 'required_plugins', 'quickcal', 'title' ),
					'slug'     => 'quickcal',
					'source'   => ! empty( $path ) ? $path : 'upload://quickcal.zip',
					'version'  => '1.0.6',
					'required' => false,
				);
			}
		}
		return $list;
	}
}


// Filter theme-supported plugins list
if ( ! function_exists( 'cobble_quickcal_theme_plugins' ) ) {
	//Handler of the add_filter( 'cobble_filter_theme_plugins', 'cobble_quickcal_theme_plugins' );
	function cobble_quickcal_theme_plugins( $list = array() ) {
		return cobble_add_group_and_logo_to_slave( $list, 'quickcal', 'quickcal-' );
	}
}


// Check if plugin installed and activated
if ( ! function_exists( 'cobble_exists_quickcal' ) ) {
	function cobble_exists_quickcal() {
		return class_exists( 'quickcal_plugin' );
	}
}

// Enqueue styles for frontend
if ( ! function_exists( 'cobble_quickcal_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'cobble_quickcal_frontend_scripts', 1100 );
	//Handler of the add_action( 'trx_addons_action_load_scripts_front_quickcal', 'cobble_quickcal_frontend_scripts', 10, 1 );
	function cobble_quickcal_frontend_scripts( $force = false ) {
		cobble_enqueue_optimized( 'quickcal', $force, array(
			'css' => array(
				'cobble-quickcal' => array( 'src' => 'plugins/quickcal/quickcal.css' ),
			)
		) );
	}
}


// Enqueue responsive styles for frontend
if ( ! function_exists( 'cobble_quickcal_frontend_scripts_responsive' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'cobble_quickcal_frontend_scripts_responsive', 2000 );
	//Handler of the add_action( 'trx_addons_action_load_scripts_front_quickcal', 'cobble_quickcal_frontend_scripts_responsive', 10, 1 );
	function cobble_quickcal_frontend_scripts_responsive( $force = false ) {
		cobble_enqueue_optimized_responsive( 'quickcal', $force, array(
			'css' => array(
				'cobble-quickcal-responsive' => array( 'src' => 'plugins/quickcal/quickcal-responsive.css', 'media' => 'all' ),
			)
		) );
	}
}


// Merge custom styles
if ( ! function_exists( 'cobble_quickcal_merge_styles' ) ) {
	//Handler of the add_filter('cobble_filter_merge_styles', 'cobble_quickcal_merge_styles');
	function cobble_quickcal_merge_styles( $list ) {
		$list[ 'plugins/quickcal/quickcal.css' ] = false;
		return $list;
	}
}


// Merge responsive styles
if ( ! function_exists( 'cobble_quickcal_merge_styles_responsive' ) ) {
	//Handler of the add_filter('cobble_filter_merge_styles_responsive', 'cobble_quickcal_merge_styles_responsive');
	function cobble_quickcal_merge_styles_responsive( $list ) {
		$list[ 'plugins/quickcal/quickcal-responsive.css' ] = false;
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if ( cobble_exists_quickcal() ) {
	$cobble_fdir = cobble_get_file_dir( 'plugins/quickcal/quickcal-style.php' );
	if ( ! empty( $cobble_fdir ) ) {
		require_once $cobble_fdir;
	}
}
