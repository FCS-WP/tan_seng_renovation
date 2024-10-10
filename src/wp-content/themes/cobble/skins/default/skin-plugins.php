<?php
/**
 * Required plugins
 *
 * @package COBBLE
 * @since COBBLE 1.76.0
 */

// THEME-SUPPORTED PLUGINS
// If plugin not need - remove its settings from next array
//----------------------------------------------------------
$cobble_theme_required_plugins_groups = array(
	'core'          => esc_html__( 'Core', 'cobble' ),
	'page_builders' => esc_html__( 'Page Builders', 'cobble' ),
	'ecommerce'     => esc_html__( 'E-Commerce & Donations', 'cobble' ),
	'socials'       => esc_html__( 'Socials and Communities', 'cobble' ),
	'events'        => esc_html__( 'Events and Appointments', 'cobble' ),
	'content'       => esc_html__( 'Content', 'cobble' ),
	'other'         => esc_html__( 'Other', 'cobble' ),
);
$cobble_theme_required_plugins        = array(
	'trx_addons'                 => array(
		'title'       => esc_html__( 'ThemeREX Addons', 'cobble' ),
		'description' => esc_html__( "Will allow you to install recommended plugins, demo content, and improve the theme's functionality overall with multiple theme options", 'cobble' ),
		'required'    => true,
		'logo'        => 'trx_addons.png',
		'group'       => $cobble_theme_required_plugins_groups['core'],
	),
	'elementor'                  => array(
		'title'       => esc_html__( 'Elementor', 'cobble' ),
		'description' => esc_html__( "Is a beautiful PageBuilder, even the free version of which allows you to create great pages using a variety of modules.", 'cobble' ),
		'required'    => false,
		'logo'        => 'elementor.png',
		'group'       => $cobble_theme_required_plugins_groups['page_builders'],
	),
	'gutenberg'                  => array(
		'title'       => esc_html__( 'Gutenberg', 'cobble' ),
		'description' => esc_html__( "It's a posts editor coming in place of the classic TinyMCE. Can be installed and used in parallel with Elementor", 'cobble' ),
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'gutenberg.png',
		'group'       => $cobble_theme_required_plugins_groups['page_builders'],
	),
	'js_composer'                => array(
		'title'       => esc_html__( 'WPBakery PageBuilder', 'cobble' ),
		'description' => esc_html__( "Popular PageBuilder which allows you to create excellent pages", 'cobble' ),
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'js_composer.jpg',
		'group'       => $cobble_theme_required_plugins_groups['page_builders'],
	),
	'woocommerce'                => array(
		'title'       => esc_html__( 'WooCommerce', 'cobble' ),
		'description' => esc_html__( "Connect the store to your website and start selling now", 'cobble' ),
		'required'    => false,
		'logo'        => 'woocommerce.png',
		'group'       => $cobble_theme_required_plugins_groups['ecommerce'],
	),
	'elegro-payment'             => array(
		'title'       => esc_html__( 'Elegro Crypto Payment', 'cobble' ),
		'description' => esc_html__( "Extends WooCommerce Payment Gateways with an elegro Crypto Payment", 'cobble' ),
		'required'    => false,
		'logo'        => 'elegro-payment.png',
		'group'       => $cobble_theme_required_plugins_groups['ecommerce'],
	),
	'instagram-feed'             => array(
		'title'       => esc_html__( 'Instagram Feed', 'cobble' ),
		'description' => esc_html__( "Displays the latest photos from your profile on Instagram", 'cobble' ),
		'required'    => false,
		'logo'        => 'instagram-feed.png',
		'group'       => $cobble_theme_required_plugins_groups['socials'],
	),
	'mailchimp-for-wp'           => array(
		'title'       => esc_html__( 'MailChimp for WP', 'cobble' ),
		'description' => esc_html__( "Allows visitors to subscribe to newsletters", 'cobble' ),
		'required'    => false,
		'logo'        => 'mailchimp-for-wp.png',
		'group'       => $cobble_theme_required_plugins_groups['socials'],
	),
	'booked'                     => array(
		'title'       => esc_html__( 'Booked Appointments', 'cobble' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => 'booked.png',
		'group'       => $cobble_theme_required_plugins_groups['events'],
	),
	'the-events-calendar'        => array(
		'title'       => esc_html__( 'The Events Calendar', 'cobble' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => 'the-events-calendar.png',
		'group'       => $cobble_theme_required_plugins_groups['events'],
	),
	'contact-form-7'             => array(
		'title'       => esc_html__( 'Contact Form 7', 'cobble' ),
		'description' => esc_html__( "CF7 allows you to create an unlimited number of contact forms", 'cobble' ),
		'required'    => false,
		'logo'        => 'contact-form-7.png',
		'group'       => $cobble_theme_required_plugins_groups['content'],
	),

	'latepoint'                  => array(
		'title'       => esc_html__( 'LatePoint', 'cobble' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => cobble_get_file_url( 'plugins/latepoint/latepoint.png' ),
		'group'       => $cobble_theme_required_plugins_groups['events'],
	),
	'advanced-popups'                  => array(
		'title'       => esc_html__( 'Advanced Popups', 'cobble' ),
		'description' => '',
		'required'    => false,
		'logo'        => cobble_get_file_url( 'plugins/advanced-popups/advanced-popups.jpg' ),
		'group'       => $cobble_theme_required_plugins_groups['content'],
	),
	'devvn-image-hotspot'                  => array(
		'title'       => esc_html__( 'Image Hotspot by DevVN', 'cobble' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => cobble_get_file_url( 'plugins/devvn-image-hotspot/devvn-image-hotspot.png' ),
		'group'       => $cobble_theme_required_plugins_groups['content'],
	),
	'ti-woocommerce-wishlist'                  => array(
		'title'       => esc_html__( 'TI WooCommerce Wishlist', 'cobble' ),
		'description' => '',
		'required'    => false,
		'logo'        => cobble_get_file_url( 'plugins/ti-woocommerce-wishlist/ti-woocommerce-wishlist.png' ),
		'group'       => $cobble_theme_required_plugins_groups['ecommerce'],
	),
	'woo-smart-quick-view'                  => array(
		'title'       => esc_html__( 'WPC Smart Quick View for WooCommerce', 'cobble' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => cobble_get_file_url( 'plugins/woo-smart-quick-view/woo-smart-quick-view.png' ),
		'group'       => $cobble_theme_required_plugins_groups['ecommerce'],
	),
	'twenty20'                  => array(
		'title'       => esc_html__( 'Twenty20 Image Before-After', 'cobble' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => cobble_get_file_url( 'plugins/twenty20/twenty20.png' ),
		'group'       => $cobble_theme_required_plugins_groups['content'],
	),
	'essential-grid'             => array(
		'title'       => esc_html__( 'Essential Grid', 'cobble' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => 'essential-grid.png',
		'group'       => $cobble_theme_required_plugins_groups['content'],
	),
	'revslider'                  => array(
		'title'       => esc_html__( 'Revolution Slider', 'cobble' ),
		'description' => '',
		'required'    => false,
		'logo'        => 'revslider.png',
		'group'       => $cobble_theme_required_plugins_groups['content'],
	),
	'sitepress-multilingual-cms' => array(
		'title'       => esc_html__( 'WPML - Sitepress Multilingual CMS', 'cobble' ),
		'description' => esc_html__( "Allows you to make your website multilingual", 'cobble' ),
		'required'    => false,
		'install'     => false,      // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'sitepress-multilingual-cms.png',
		'group'       => $cobble_theme_required_plugins_groups['content'],
	),
	'wp-gdpr-compliance'         => array(
		'title'       => esc_html__( 'Cookie Information', 'cobble' ),
		'description' => esc_html__( "Allow visitors to decide for themselves what personal data they want to store on your site", 'cobble' ),
		'required'    => false,
		'logo'        => 'wp-gdpr-compliance.png',
		'group'       => $cobble_theme_required_plugins_groups['other'],
	),
	'trx_updater'                => array(
		'title'       => esc_html__( 'ThemeREX Updater', 'cobble' ),
		'description' => esc_html__( "Update theme and theme-specific plugins from developer's upgrade server.", 'cobble' ),
		'required'    => false,
		'logo'        => 'trx_updater.png',
		'group'       => $cobble_theme_required_plugins_groups['other'],
	),
);

if ( COBBLE_THEME_FREE ) {
	unset( $cobble_theme_required_plugins['js_composer'] );
	unset( $cobble_theme_required_plugins['booked'] );
	unset( $cobble_theme_required_plugins['the-events-calendar'] );
	unset( $cobble_theme_required_plugins['calculated-fields-form'] );
	unset( $cobble_theme_required_plugins['essential-grid'] );
	unset( $cobble_theme_required_plugins['revslider'] );
	unset( $cobble_theme_required_plugins['sitepress-multilingual-cms'] );
	unset( $cobble_theme_required_plugins['trx_updater'] );
	unset( $cobble_theme_required_plugins['trx_popup'] );
}

// Add plugins list to the global storage
cobble_storage_set( 'required_plugins', $cobble_theme_required_plugins );
