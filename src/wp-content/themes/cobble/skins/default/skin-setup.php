<?php
/**
 * Skin Setup
 *
 * @package COBBLE
 * @since COBBLE 1.76.0
 */


//--------------------------------------------
// SKIN DEFAULTS
//--------------------------------------------

// Return theme's (skin's) default value for the specified parameter
if ( ! function_exists( 'cobble_theme_defaults' ) ) {
	function cobble_theme_defaults( $name='', $value='' ) {
		$defaults = array(
			'page_width'          => 1290,
			'page_boxed_extra'  => 60,
			'page_fullwide_max' => 1920,
			'page_fullwide_extra' => 60,
			'sidebar_width'       => 410,
			'sidebar_gap'       => 40,
			'grid_gap'          => 30,
			'rad'               => 0
		);
		if ( empty( $name ) ) {
			return $defaults;
		} else {
			if ( $value === '' && isset( $defaults[ $name ] ) ) {
				$value = $defaults[ $name ];
			}
			return $value;
		}
	}
}


// WOOCOMMERCE SETUP
//--------------------------------------------------

// Allow extended layouts for WooCommerce
if ( ! function_exists( 'cobble_skin_woocommerce_allow_extensions' ) ) {
	add_filter( 'cobble_filter_load_woocommerce_extensions', 'cobble_skin_woocommerce_allow_extensions' );
	function cobble_skin_woocommerce_allow_extensions( $allow ) {
		return false;
	}
}


// Theme init priorities:
// Action 'after_setup_theme'
// 1 - register filters to add/remove lists items in the Theme Options
// 2 - create Theme Options
// 3 - add/remove Theme Options elements
// 5 - load Theme Options. Attention! After this step you can use only basic options (not overriden)
// 9 - register other filters (for installer, etc.)
//10 - standard Theme init procedures (not ordered)
// Action 'wp_loaded'
// 1 - detect override mode. Attention! Only after this step you can use overriden options (separate values for the shop, courses, etc.)


//--------------------------------------------
// SKIN SETTINGS
//--------------------------------------------
if ( ! function_exists( 'cobble_skin_setup' ) ) {
	add_action( 'after_setup_theme', 'cobble_skin_setup', 1 );
	function cobble_skin_setup() {

		$GLOBALS['COBBLE_STORAGE'] = array_merge( $GLOBALS['COBBLE_STORAGE'], array(

			// Key validator: market[env|loc]-vendor[axiom|ancora|themerex]
			'theme_pro_key'       => 'env-themerex',

			'theme_doc_url'       => '//cobble.themerex.net/doc',

			'theme_demofiles_url' => '//demofiles.themerex.net/cobble/',
			
			'theme_rate_url'      => '//themeforest.net/downloads',

			'theme_custom_url'    => '//themerex.net/offers/?utm_source=offers&utm_medium=click&utm_campaign=themeinstall',

			'theme_support_url'   => '//themerex.net/support/',

			'theme_download_url'  => '//1.envato.market/Nkv062',        								// ThemeREX

			'theme_video_url'     => '//www.youtube.com/channel/UCdIjRh7-lPVHqTTKpaf8PLA',   			// ThemeREX

			'theme_privacy_url'   => '//themerex.net/privacy-policy/',                   				// ThemeREX

			'portfolio_url'       => '//themeforest.net/user/themerex/portfolio',        				// ThemeREX

			// Comma separated slugs of theme-specific categories (for get relevant news in the dashboard widget)
			// (i.e. 'children,kindergarten')
			'theme_categories'    => '',
		) );
	}
}


// Add/remove/change Theme Settings
if ( ! function_exists( 'cobble_skin_setup_settings' ) ) {
	add_action( 'after_setup_theme', 'cobble_skin_setup_settings', 1 );
	function cobble_skin_setup_settings() {
		// Example: enable (true) / disable (false) thumbs in the prev/next navigation
		cobble_storage_set_array( 'settings', 'thumbs_in_navigation', false );
	}
}



//--------------------------------------------
// SKIN FONTS
//--------------------------------------------
if ( ! function_exists( 'cobble_skin_setup_fonts' ) ) {
	add_action( 'after_setup_theme', 'cobble_skin_setup_fonts', 1 );
	function cobble_skin_setup_fonts() {
		// Fonts to load when theme start
		// It can be:
		// - Google fonts (specify name, family and styles)
		// - Adobe fonts (specify name, family and link URL)
		// - uploaded fonts (specify name, family), placed in the folder css/font-face/font-name inside the skin folder
		// Attention! Font's folder must have name equal to the font's name, with spaces replaced on the dash '-'
		// example: font name 'TeX Gyre Termes', folder 'TeX-Gyre-Termes'
		cobble_storage_set(
			'load_fonts', array(
				array(
					'name'   => 'Open Sans',
					'family' => 'sans-serif',
					'link'   => '',
					'styles' => 'ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800'
				),
				array(
					'name'   => 'Red Hat Display',
					'family' => 'sans-serif',
					'link'   => '',
					'styles' => 'ital,wght@0,300;0,400;0,500;0,600;0,700;0,900;1,300;1,400;1,500;1,600;1,700;1,900'
				),
				// Google font
				array(

				),
			)
		);

		// Characters subset for the Google fonts. Available values are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese
		cobble_storage_set( 'load_fonts_subset', 'latin,latin-ext' );

		// Settings of the main tags.
		// Default value of 'font-family' may be specified as reference to the array $load_fonts (see above)
		// or as comma-separated string.
		// In the second case (if 'font-family' is specified manually as comma-separated string):
		//    1) Font name with spaces in the parameter 'font-family' will be enclosed in the quotes and no spaces after comma!
		//    2) If font-family inherit a value from the 'Main text' - specify 'inherit' as a value
		// example:
		// Correct:   'font-family' => cobble_get_load_fonts_family_string( $load_fonts[0] )
		// Correct:   'font-family' => 'Roboto,sans-serif'
		// Correct:   'font-family' => '"PT Serif",sans-serif'
		// Incorrect: 'font-family' => 'Roboto, sans-serif'
		// Incorrect: 'font-family' => 'PT Serif,sans-serif'

		$font_description = esc_html__( 'Font settings for the %s of the site. To ensure that the elements scale properly on mobile devices, please use only the following units: "rem", "em" or "ex"', 'cobble' );

		cobble_storage_set(
			'theme_fonts', array(
				'p'       => array(
					'title'           => esc_html__( 'Main text', 'cobble' ),
					'description'     => sprintf( $font_description, esc_html__( 'main text', 'cobble' ) ),
					'font-family'     => '"Open Sans",sans-serif',
					'font-size'       => '1rem',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.62em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0.1px',
					'margin-top'      => '0em',
					'margin-bottom'   => '1.57em',
				),
				'post'    => array(
					'title'           => esc_html__( 'Article text', 'cobble' ),
					'description'     => sprintf( $font_description, esc_html__( 'article text', 'cobble' ) ),
					'font-family'     => '',			// Example: '"PR Serif",serif',
					'font-size'       => '',			// Example: '1.286rem',
					'font-weight'     => '',			// Example: '400',
					'font-style'      => '',			// Example: 'normal',
					'line-height'     => '',			// Example: '1.75em',
					'text-decoration' => '',			// Example: 'none',
					'text-transform'  => '',			// Example: 'none',
					'letter-spacing'  => '',			// Example: '',
					'margin-top'      => '',			// Example: '0em',
					'margin-bottom'   => '',			// Example: '1.4em',
				),
				'h1'      => array(
					'title'           => esc_html__( 'Heading 1', 'cobble' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H1', 'cobble' ) ),
					'font-family'     => '"Red Hat Display",sans-serif',
					'font-size'       => '3.167rem',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '1.04em',
					'margin-bottom'   => '0.46em',
				),
				'h2'      => array(
					'title'           => esc_html__( 'Heading 2', 'cobble' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H2', 'cobble' ) ),
					'font-family'     => '"Red Hat Display",sans-serif',
					'font-size'       => '2.611rem',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.021em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '0.67em',
					'margin-bottom'   => '0.56em',
				),
				'h3'      => array(
					'title'           => esc_html__( 'Heading 3', 'cobble' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H3', 'cobble' ) ),
					'font-family'     => '"Red Hat Display",sans-serif',
					'font-size'       => '1.944rem',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.086em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '0.94em',
					'margin-bottom'   => '0.72em',
				),
				'h4'      => array(
					'title'           => esc_html__( 'Heading 4', 'cobble' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H4', 'cobble' ) ),
					'font-family'     => '"Red Hat Display",sans-serif',
					'font-size'       => '1.556rem',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.214em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '1.15em',
					'margin-bottom'   => '0.83em',
				),
				'h5'      => array(
					'title'           => esc_html__( 'Heading 5', 'cobble' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H5', 'cobble' ) ),
					'font-family'     => '"Red Hat Display",sans-serif',
					'font-size'       => '1.333rem',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.417em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '1.3em',
					'margin-bottom'   => '0.84em',
				),
				'h6'      => array(
					'title'           => esc_html__( 'Heading 6', 'cobble' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H6', 'cobble' ) ),
					'font-family'     => '"Red Hat Display",sans-serif',
					'font-size'       => '1.056rem',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.474em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '1.75em',
					'margin-bottom'   => '1.1em',
				),
				'logo'    => array(
					'title'           => esc_html__( 'Logo text', 'cobble' ),
					'description'     => sprintf( $font_description, esc_html__( 'text of the logo', 'cobble' ) ),
					'font-family'     => '"Red Hat Display",sans-serif',
					'font-size'       => '1.7em',
					'font-weight'     => '500',
					'font-style'      => 'normal',
					'line-height'     => '1.25em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'button'  => array(
					'title'           => esc_html__( 'Buttons', 'cobble' ),
					'description'     => sprintf( $font_description, esc_html__( 'buttons', 'cobble' ) ),
					'font-family'     => '"Red Hat Display",sans-serif',
					'font-size'       => '12px',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '20px',
					'text-decoration' => 'none',
					'text-transform'  => 'uppercase',
					'letter-spacing'  => '0.2em',
				),
				'input'   => array(
					'title'           => esc_html__( 'Input fields', 'cobble' ),
					'description'     => sprintf( $font_description, esc_html__( 'input fields, dropdowns and textareas', 'cobble' ) ),
					'font-family'     => 'inherit',
					'font-size'       => '16px',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',     // Attention! Firefox don't allow line-height less then 1.5em in the select
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0.1px',
				),
				'info'    => array(
					'title'           => esc_html__( 'Post meta', 'cobble' ),
					'description'     => sprintf( $font_description, esc_html__( 'post meta (author, categories, publish date, counters, share, etc.)', 'cobble' ) ),
					'font-family'     => 'inherit',
					'font-size'       => '14px',  // Old value '13px' don't allow using 'font zoom' in the custom blog items
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '0.4em',
					'margin-bottom'   => '',
				),
				'menu'    => array(
					'title'           => esc_html__( 'Main menu', 'cobble' ),
					'description'     => sprintf( $font_description, esc_html__( 'main menu items', 'cobble' ) ),
					'font-family'     => '"Red Hat Display",sans-serif',
					'font-size'       => '16px',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0.02em',
				),
				'submenu' => array(
					'title'           => esc_html__( 'Dropdown menu', 'cobble' ),
					'description'     => sprintf( $font_description, esc_html__( 'dropdown menu items', 'cobble' ) ),
					'font-family'     => '"Open Sans",sans-serif',
					'font-size'       => '15px',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'other' => array(
					'title'           => esc_html__( 'Other', 'cobble' ),
					'description'     => sprintf( $font_description, esc_html__( 'specific elements', 'cobble' ) ),
					'font-family'     => '"Red Hat Display",sans-serif',
				),
			)
		);

		// Font presets
		cobble_storage_set(
			'font_presets', array(
				'karla' => array(
								'title'  => esc_html__( 'Karla', 'cobble' ),
								'load_fonts' => array(
													// Google font
													array(
														'name'   => 'Dancing Script',
														'family' => 'fantasy',
														'link'   => '',
														'styles' => '300,400,700',
													),
													// Google font
													array(
														'name'   => 'Sansita Swashed',
														'family' => 'fantasy',
														'link'   => '',
														'styles' => '300,400,700',
													),
												),
								'theme_fonts' => array(
													'p'       => array(
														'font-family'     => '"Dancing Script",fantasy',
														'font-size'       => '1.25rem',
													),
													'post'    => array(
														'font-family'     => '',
													),
													'h1'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
														'font-size'       => '4em',
													),
													'h2'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h3'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h4'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h5'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h6'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'logo'    => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'button'  => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'input'   => array(
														'font-family'     => 'inherit',
													),
													'info'    => array(
														'font-family'     => 'inherit',
													),
													'menu'    => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'submenu' => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
												),
							),
				'roboto' => array(
								'title'  => esc_html__( 'Roboto', 'cobble' ),
								'load_fonts' => array(
													// Google font
													array(
														'name'   => 'Noto Sans JP',
														'family' => 'serif',
														'link'   => '',
														'styles' => '300,300italic,400,400italic,700,700italic',
													),
													// Google font
													array(
														'name'   => 'Merriweather',
														'family' => 'sans-serif',
														'link'   => '',
														'styles' => '300,300italic,400,400italic,700,700italic',
													),
												),
								'theme_fonts' => array(
													'p'       => array(
														'font-family'     => '"Noto Sans JP",serif',
													),
													'post'    => array(
														'font-family'     => '',
													),
													'h1'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h2'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h3'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h4'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h5'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h6'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'logo'    => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'button'  => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'input'   => array(
														'font-family'     => 'inherit',
													),
													'info'    => array(
														'font-family'     => 'inherit',
													),
													'menu'    => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'submenu' => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
												),
							),
				'garamond' => array(
								'title'  => esc_html__( 'Garamond', 'cobble' ),
								'load_fonts' => array(
													// Adobe font
													array(
														'name'   => 'Europe',
														'family' => 'sans-serif',
														'link'   => 'https://use.typekit.net/qmj1tmx.css',
														'styles' => '',
													),
													// Adobe font
													array(
														'name'   => 'Sofia Pro',
														'family' => 'sans-serif',
														'link'   => 'https://use.typekit.net/qmj1tmx.css',
														'styles' => '',
													),
												),
								'theme_fonts' => array(
													'p'       => array(
														'font-family'     => '"Sofia Pro",sans-serif',
													),
													'post'    => array(
														'font-family'     => '',
													),
													'h1'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h2'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h3'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h4'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h5'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h6'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'logo'    => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'button'  => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'input'   => array(
														'font-family'     => 'inherit',
													),
													'info'    => array(
														'font-family'     => 'inherit',
													),
													'menu'    => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'submenu' => array(
														'font-family'     => 'Europe,sans-serif',
													),
												),
							),
			)
		);
	}
}


//--------------------------------------------
// COLOR SCHEMES
//--------------------------------------------
if ( ! function_exists( 'cobble_skin_setup_schemes' ) ) {
	add_action( 'after_setup_theme', 'cobble_skin_setup_schemes', 1 );
	function cobble_skin_setup_schemes() {

		// Theme colors for customizer
		// Attention! Inner scheme must be last in the array below
		cobble_storage_set(
			'scheme_color_groups', array(
				'main'    => array(
					'title'       => esc_html__( 'Main', 'cobble' ),
					'description' => esc_html__( 'Colors of the main content area', 'cobble' ),
				),
				'alter'   => array(
					'title'       => esc_html__( 'Alter', 'cobble' ),
					'description' => esc_html__( 'Colors of the alternative blocks (sidebars, etc.)', 'cobble' ),
				),
				'extra'   => array(
					'title'       => esc_html__( 'Extra', 'cobble' ),
					'description' => esc_html__( 'Colors of the extra blocks (dropdowns, price blocks, table headers, etc.)', 'cobble' ),
				),
				'inverse' => array(
					'title'       => esc_html__( 'Inverse', 'cobble' ),
					'description' => esc_html__( 'Colors of the inverse blocks - when link color used as background of the block (dropdowns, blockquotes, etc.)', 'cobble' ),
				),
				'input'   => array(
					'title'       => esc_html__( 'Input', 'cobble' ),
					'description' => esc_html__( 'Colors of the form fields (text field, textarea, select, etc.)', 'cobble' ),
				),
			)
		);

		cobble_storage_set(
			'scheme_color_names', array(
				'bg_color'    => array(
					'title'       => esc_html__( 'Background color', 'cobble' ),
					'description' => esc_html__( 'Background color of this block in the normal state', 'cobble' ),
				),
				'bg_hover'    => array(
					'title'       => esc_html__( 'Background hover', 'cobble' ),
					'description' => esc_html__( 'Background color of this block in the hovered state', 'cobble' ),
				),
				'bd_color'    => array(
					'title'       => esc_html__( 'Border color', 'cobble' ),
					'description' => esc_html__( 'Border color of this block in the normal state', 'cobble' ),
				),
				'bd_hover'    => array(
					'title'       => esc_html__( 'Border hover', 'cobble' ),
					'description' => esc_html__( 'Border color of this block in the hovered state', 'cobble' ),
				),
				'text'        => array(
					'title'       => esc_html__( 'Text', 'cobble' ),
					'description' => esc_html__( 'Color of the text inside this block', 'cobble' ),
				),
				'text_dark'   => array(
					'title'       => esc_html__( 'Text dark', 'cobble' ),
					'description' => esc_html__( 'Color of the dark text (bold, header, etc.) inside this block', 'cobble' ),
				),
				'text_light'  => array(
					'title'       => esc_html__( 'Text light', 'cobble' ),
					'description' => esc_html__( 'Color of the light text (post meta, etc.) inside this block', 'cobble' ),
				),
				'text_link'   => array(
					'title'       => esc_html__( 'Link', 'cobble' ),
					'description' => esc_html__( 'Color of the links inside this block', 'cobble' ),
				),
				'text_hover'  => array(
					'title'       => esc_html__( 'Link hover', 'cobble' ),
					'description' => esc_html__( 'Color of the hovered state of links inside this block', 'cobble' ),
				),
				'text_link2'  => array(
					'title'       => esc_html__( 'Accent 2', 'cobble' ),
					'description' => esc_html__( 'Color of the accented texts (areas) inside this block', 'cobble' ),
				),
				'text_hover2' => array(
					'title'       => esc_html__( 'Accent 2 hover', 'cobble' ),
					'description' => esc_html__( 'Color of the hovered state of accented texts (areas) inside this block', 'cobble' ),
				),
				'text_link3'  => array(
					'title'       => esc_html__( 'Accent 3', 'cobble' ),
					'description' => esc_html__( 'Color of the other accented texts (buttons) inside this block', 'cobble' ),
				),
				'text_hover3' => array(
					'title'       => esc_html__( 'Accent 3 hover', 'cobble' ),
					'description' => esc_html__( 'Color of the hovered state of other accented texts (buttons) inside this block', 'cobble' ),
				),
			)
		);

		// Default values for each color scheme
		$schemes = array(

			// Color scheme: 'default'
			'default' => array(
				'title'    => esc_html__( 'Default', 'cobble' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#F8F8F8',
					'bd_color'         => '#D6D6D3',

					// Text and links colors
					'text'             => '#707376',
					'text_light'       => '#A5A6AA',
					'text_dark'        => '#3A3633',
					'text_link'        => '#DA9B62',
					'text_hover'       => '#C27E41',
					'text_link2'       => '#FE5C3B',
					'text_hover2'      => '#EB411F',
					'text_link3'       => '#6DA88F',
					'text_hover3'      => '#579279',

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#EFECE7',
					'alter_bg_hover'   => '#E8E2D9',
					'alter_bd_color'   => '#D6D6D3',
					'alter_bd_hover'   => '#DCDCDC',
					'alter_text'       => '#707376',
					'alter_light'      => '#A5A6AA',
					'alter_dark'       => '#3A3633',
					'alter_link'       => '#DA9B62',
					'alter_hover'      => '#C27E41',
					'alter_link2'      => '#FE5C3B',
					'alter_hover2'     => '#EB411F',
					'alter_link3'      => '#6DA88F',
					'alter_hover3'     => '#579279',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#1A1A1A',
					'extra_bg_hover'   => '#3f3d47',
					'extra_bd_color'   => '#313131',
					'extra_bd_hover'   => '#575757',
					'extra_text'       => '#B0B3BC',
					'extra_light'      => '#9497A0',
					'extra_dark'       => '#ffffff',
					'extra_link'       => '#DA9B62',
					'extra_hover'      => '#ffffff',
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent',
					'input_bg_hover'   => 'transparent',
					'input_bd_color'   => '#D6D6D3',
					'input_bd_hover'   => '#3A3633',
					'input_text'       => '#A5A6AA',
					'input_light'      => '#A5A6AA',
					'input_dark'       => '#3A3633',

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#0A0300',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#1d1d1d',
					'inverse_light'    => '#333333',
					'inverse_dark'     => '#3A3633',
					'inverse_link'     => '#ffffff',
					'inverse_hover'    => '#ffffff',

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'dark'
			'dark'    => array(
				'title'    => esc_html__( 'Dark', 'cobble' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#1A1A1A',
					'bd_color'         => '#31302D',

					// Text and links colors
					'text'             => '#B0B3BC',
					'text_light'       => '#9497A0',
					'text_dark'        => '#FCFCFC',
					'text_link'        => '#DA9B62',
					'text_hover'       => '#C27E41',
					'text_link2'       => '#FE5C3B',
					'text_hover2'      => '#EB411F',
					'text_link3'       => '#6DA88F',
					'text_hover3'      => '#579279',

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#262424',
					'alter_bg_hover'   => '#404040',
					'alter_bd_color'   => '#31302D',
					'alter_bd_hover'   => '#53535C',
					'alter_text'       => '#B0B3BC',
					'alter_light'      => '#9497A0',
					'alter_dark'       => '#FCFCFC',
					'alter_link'       => '#DA9B62',
					'alter_hover'      => '#C27E41',
					'alter_link2'      => '#FE5C3B',
					'alter_hover2'     => '#EB411F',
					'alter_link3'      => '#6DA88F',
					'alter_hover3'     => '#579279',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#1A1A1A',
					'extra_bg_hover'   => '#3f3d47',
					'extra_bd_color'   => '#313131',
					'extra_bd_hover'   => '#575757',
					'extra_text'       => '#B0B3BC',
					'extra_light'      => '#9497A0',
					'extra_dark'       => '#ffffff',
					'extra_link'       => '#DA9B62',
					'extra_hover'      => '#ffffff',
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent',
					'input_bg_hover'   => 'transparent',
					'input_bd_color'   => '#31302D',
					'input_bd_hover'   => '#31302D',
					'input_text'       => '#B0B3BC',
					'input_light'      => '#B0B3BC',
					'input_dark'       => '#ffffff',

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#0A0300',
					'inverse_bd_hover' => '#cb5b47',
					'inverse_text'     => '#FCFCFC',
					'inverse_light'    => '#6f6f6f',
					'inverse_dark'     => '#3A3633',
					'inverse_link'     => '#ffffff',
					'inverse_hover'    => '#3A3633',

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'light'
			'light' => array(
				'title'    => esc_html__( 'Light', 'cobble' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#EFECE7',
					'bd_color'         => '#D6D6D3',

					// Text and links colors
					'text'             => '#707376',
					'text_light'       => '#A5A6AA',
					'text_dark'        => '#3A3633',
					'text_link'        => '#DA9B62',
					'text_hover'       => '#C27E41',
					'text_link2'       => '#FE5C3B',
					'text_hover2'      => '#EB411F',
					'text_link3'       => '#6DA88F',
					'text_hover3'      => '#579279',

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#F8F8F8',
					'alter_bg_hover'   => '#E8E2D9',
					'alter_bd_color'   => '#D6D6D3',
					'alter_bd_hover'   => '#DCDCDC',
					'alter_text'       => '#707376',
					'alter_light'      => '#A5A6AA',
					'alter_dark'       => '#3A3633',
					'alter_link'       => '#DA9B62',
					'alter_hover'      => '#C27E41',
					'alter_link2'      => '#FE5C3B',
					'alter_hover2'     => '#EB411F',
					'alter_link3'      => '#6DA88F',
					'alter_hover3'     => '#579279',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#1A1A1A',
					'extra_bg_hover'   => '#3f3d47',
					'extra_bd_color'   => '#313131',
					'extra_bd_hover'   => '#575757',
					'extra_text'       => '#B0B3BC',
					'extra_light'      => '#9497A0',
					'extra_dark'       => '#ffffff',
					'extra_link'       => '#DA9B62',
					'extra_hover'      => '#ffffff',
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent',
					'input_bg_hover'   => 'transparent',
					'input_bd_color'   => '#D6D6D3',
					'input_bd_hover'   => '#3A3633',
					'input_text'       => '#A5A6AA',
					'input_light'      => '#A5A6AA',
					'input_dark'       => '#3A3633',

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#0A0300',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#1d1d1d',
					'inverse_light'    => '#333333',
					'inverse_dark'     => '#3A3633',
					'inverse_link'     => '#ffffff',
					'inverse_hover'    => '#ffffff',

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),
			
			// Color scheme: 'red_default'
			'red_default' => array(
				'title'    => esc_html__( 'Red Default', 'cobble' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#FFFFFF',
					'bd_color'         => '#C7C7C5',

					// Text and links colors
					'text'             => '#707376',
					'text_light'       => '#A5A6AA',
					'text_dark'        => '#161921',
					'text_link'        => '#F84D2A',
					'text_hover'       => '#E22D08',
					'text_link2'       => '#1581FC',
					'text_hover2'      => '#016BE4',
					'text_link3'       => '#F8CF2A',
					'text_hover3'      => '#F2C615',

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#F9F9F9',
					'alter_bg_hover'   => '#F0F0F0',
					'alter_bd_color'   => '#C7C7C5',
					'alter_bd_hover'   => '#DCDCDC',
					'alter_text'       => '#707376',
					'alter_light'      => '#A5A6AA',
					'alter_dark'       => '#161921',
					'alter_link'       => '#F84D2A',
					'alter_hover'      => '#E22D08',
					'alter_link2'      => '#1581FC',
					'alter_hover2'     => '#016BE4',
					'alter_link3'      => '#F8CF2A',
					'alter_hover3'     => '#F2C615',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#040817',
					'extra_bg_hover'   => '#3f3d47',
					'extra_bd_color'   => '#313131',
					'extra_bd_hover'   => '#575757',
					'extra_text'       => '#B0B3BC',
					'extra_light'      => '#9497A0',
					'extra_dark'       => '#ffffff',
					'extra_link'       => '#F84D2A',
					'extra_hover'      => '#ffffff',
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent',
					'input_bg_hover'   => 'transparent',
					'input_bd_color'   => '#C7C7C5',
					'input_bd_hover'   => '#161921',
					'input_text'       => '#A5A6AA',
					'input_light'      => '#A5A6AA',
					'input_dark'       => '#161921',

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#0A0300',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#1d1d1d',
					'inverse_light'    => '#333333',
					'inverse_dark'     => '#161921',
					'inverse_link'     => '#ffffff',
					'inverse_hover'    => '#ffffff',

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'red_dark'
			'red_dark'    => array(
				'title'    => esc_html__( 'Red Dark', 'cobble' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#040817',
					'bd_color'         => '#323641',

					// Text and links colors
					'text'             => '#B0B3BC',
					'text_light'       => '#9497A0',
					'text_dark'        => '#FCFCFC',
					'text_link'        => '#F84D2A',
					'text_hover'       => '#E22D08',
					'text_link2'       => '#1581FC',
					'text_hover2'      => '#016BE4',
					'text_link3'       => '#F8CF2A',
					'text_hover3'      => '#F2C615',

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#0E173B',
					'alter_bg_hover'   => '#151F46',
					'alter_bd_color'   => '#323641',
					'alter_bd_hover'   => '#53535C',
					'alter_text'       => '#B0B3BC',
					'alter_light'      => '#9497A0',
					'alter_dark'       => '#FCFCFC',
					'alter_link'       => '#F84D2A',
					'alter_hover'      => '#E22D08',
					'alter_link2'      => '#1581FC',
					'alter_hover2'     => '#016BE4',
					'alter_link3'      => '#F8CF2A',
					'alter_hover3'     => '#F2C615',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#040817',
					'extra_bg_hover'   => '#3f3d47',
					'extra_bd_color'   => '#313131',
					'extra_bd_hover'   => '#575757',
					'extra_text'       => '#B0B3BC',
					'extra_light'      => '#9497A0',
					'extra_dark'       => '#ffffff',
					'extra_link'       => '#F84D2A',
					'extra_hover'      => '#ffffff',
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent',
					'input_bg_hover'   => 'transparent',
					'input_bd_color'   => '#323641',
					'input_bd_hover'   => '#323641',
					'input_text'       => '#B0B3BC',
					'input_light'      => '#B0B3BC',
					'input_dark'       => '#ffffff',

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#0A0300',
					'inverse_bd_hover' => '#cb5b47',
					'inverse_text'     => '#FCFCFC',
					'inverse_light'    => '#6f6f6f',
					'inverse_dark'     => '#161921',
					'inverse_link'     => '#ffffff',
					'inverse_hover'    => '#161921',

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'red_light'
			'red_light' => array(
				'title'    => esc_html__( 'Red Light', 'cobble' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#F9F9F9',
					'bd_color'         => '#C7C7C5',

					// Text and links colors
					'text'             => '#707376',
					'text_light'       => '#A5A6AA',
					'text_dark'        => '#161921',
					'text_link'        => '#F84D2A',
					'text_hover'       => '#E22D08',
					'text_link2'       => '#1581FC',
					'text_hover2'      => '#016BE4',
					'text_link3'       => '#F8CF2A',
					'text_hover3'      => '#F2C615',

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#FFFFFF',
					'alter_bg_hover'   => '#F0F0F0',
					'alter_bd_color'   => '#C7C7C5',
					'alter_bd_hover'   => '#DCDCDC',
					'alter_text'       => '#707376',
					'alter_light'      => '#A5A6AA',
					'alter_dark'       => '#161921',
					'alter_link'       => '#F84D2A',
					'alter_hover'      => '#E22D08',
					'alter_link2'      => '#1581FC',
					'alter_hover2'     => '#016BE4',
					'alter_link3'      => '#F8CF2A',
					'alter_hover3'     => '#F2C615',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#040817',
					'extra_bg_hover'   => '#3f3d47',
					'extra_bd_color'   => '#313131',
					'extra_bd_hover'   => '#575757',
					'extra_text'       => '#B0B3BC',
					'extra_light'      => '#9497A0',
					'extra_dark'       => '#ffffff',
					'extra_link'       => '#F84D2A',
					'extra_hover'      => '#ffffff',
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent',
					'input_bg_hover'   => 'transparent',
					'input_bd_color'   => '#C7C7C5',
					'input_bd_hover'   => '#161921',
					'input_text'       => '#A5A6AA',
					'input_light'      => '#A5A6AA',
					'input_dark'       => '#161921',

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#0A0300',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#1d1d1d',
					'inverse_light'    => '#333333',
					'inverse_dark'     => '#161921',
					'inverse_link'     => '#ffffff',
					'inverse_hover'    => '#ffffff',

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'brown_default'
			'brown_default' => array(
				'title'    => esc_html__( 'Brown Default', 'cobble' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#E9E8E4',
					'bd_color'         => '#D6D6D3',

					// Text and links colors
					'text'             => '#707376',
					'text_light'       => '#A5A6AA',
					'text_dark'        => '#3A3633',
					'text_link'        => '#BC8F67',
					'text_hover'       => '#B58458',
					'text_link2'       => '#DC6346',
					'text_hover2'      => '#D2583B',
					'text_link3'       => '#6DA88F',
					'text_hover3'      => '#579279',

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#E1DBCA',
					'alter_bg_hover'   => '#D8CFB6',
					'alter_bd_color'   => '#D6D6D3',
					'alter_bd_hover'   => '#DCDCDC',
					'alter_text'       => '#707376',
					'alter_light'      => '#A5A6AA',
					'alter_dark'       => '#3A3633', 
					'alter_link'       => '#BC8F67',
					'alter_hover'      => '#B58458',
					'alter_link2'      => '#DC6346',
					'alter_hover2'     => '#D2583B',
					'alter_link3'      => '#6DA88F',
					'alter_hover3'     => '#579279',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#040817',
					'extra_bg_hover'   => '#3f3d47',
					'extra_bd_color'   => '#313131',
					'extra_bd_hover'   => '#575757',
					'extra_text'       => '#B0B3BC',
					'extra_light'      => '#9497A0',
					'extra_dark'       => '#ffffff',
					'extra_link'       => '#BC8F67',
					'extra_hover'      => '#ffffff',
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent',
					'input_bg_hover'   => 'transparent',
					'input_bd_color'   => '#D6D6D3',
					'input_bd_hover'   => '#3A3633',
					'input_text'       => '#A5A6AA',
					'input_light'      => '#A5A6AA',
					'input_dark'       => '#3A3633',

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#0A0300',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#1d1d1d',
					'inverse_light'    => '#333333',
					'inverse_dark'     => '#3A3633',
					'inverse_link'     => '#ffffff',
					'inverse_hover'    => '#ffffff',

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'brown_dark'
			'brown_dark'    => array(
				'title'    => esc_html__( 'Brown Dark', 'cobble' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#040817',
					'bd_color'         => '#31302D',

					// Text and links colors
					'text'             => '#B0B3BC',
					'text_light'       => '#9497A0',
					'text_dark'        => '#FCFCFC',
					'text_link'        => '#BC8F67',
					'text_hover'       => '#B58458',
					'text_link2'       => '#DC6346',
					'text_hover2'      => '#D2583B',
					'text_link3'       => '#6DA88F',
					'text_hover3'      => '#579279',

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#0E173B',
					'alter_bg_hover'   => '#151F46',
					'alter_bd_color'   => '#31302D',
					'alter_bd_hover'   => '#53535C',
					'alter_text'       => '#B0B3BC',
					'alter_light'      => '#9497A0',
					'alter_dark'       => '#FCFCFC',
					'alter_link'       => '#BC8F67',
					'alter_hover'      => '#B58458',
					'alter_link2'      => '#DC6346',
					'alter_hover2'     => '#D2583B',
					'alter_link3'      => '#6DA88F',
					'alter_hover3'     => '#579279',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#040817',
					'extra_bg_hover'   => '#3f3d47',
					'extra_bd_color'   => '#313131',
					'extra_bd_hover'   => '#575757',
					'extra_text'       => '#B0B3BC',
					'extra_light'      => '#9497A0',
					'extra_dark'       => '#ffffff',
					'extra_link'       => '#BC8F67',
					'extra_hover'      => '#ffffff',
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent',
					'input_bg_hover'   => 'transparent',
					'input_bd_color'   => '#31302D',
					'input_bd_hover'   => '#31302D',
					'input_text'       => '#B0B3BC',
					'input_light'      => '#B0B3BC',
					'input_dark'       => '#ffffff',

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#0A0300',
					'inverse_bd_hover' => '#cb5b47',
					'inverse_text'     => '#FCFCFC',
					'inverse_light'    => '#6f6f6f',
					'inverse_dark'     => '#3A3633',
					'inverse_link'     => '#ffffff',
					'inverse_hover'    => '#3A3633',

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'brown_light'
			'brown_light' => array(
				'title'    => esc_html__( 'Brown Light', 'cobble' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#E1DBCA',
					'bd_color'         => '#D6D6D3',

					// Text and links colors
					'text'             => '#707376',
					'text_light'       => '#A5A6AA',
					'text_dark'        => '#3A3633',
					'text_link'        => '#BC8F67',
					'text_hover'       => '#B58458',
					'text_link2'       => '#DC6346',
					'text_hover2'      => '#D2583B',
					'text_link3'       => '#6DA88F',
					'text_hover3'      => '#579279',

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#E9E8E4',
					'alter_bg_hover'   => '#D8CFB6',
					'alter_bd_color'   => '#D6D6D3',
					'alter_bd_hover'   => '#DCDCDC',
					'alter_text'       => '#707376',
					'alter_light'      => '#A5A6AA',
					'alter_dark'       => '#3A3633',
					'alter_link'       => '#BC8F67',
					'alter_hover'      => '#B58458',
					'alter_link2'      => '#DC6346',
					'alter_hover2'     => '#D2583B',
					'alter_link3'      => '#6DA88F',
					'alter_hover3'     => '#579279',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#040817',
					'extra_bg_hover'   => '#3f3d47',
					'extra_bd_color'   => '#313131',
					'extra_bd_hover'   => '#575757',
					'extra_text'       => '#B0B3BC',
					'extra_light'      => '#9497A0',
					'extra_dark'       => '#ffffff',
					'extra_link'       => '#BC8F67',
					'extra_hover'      => '#ffffff',
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent',
					'input_bg_hover'   => 'transparent',
					'input_bd_color'   => '#D6D6D3',
					'input_bd_hover'   => '#3A3633',
					'input_text'       => '#A5A6AA',
					'input_light'      => '#A5A6AA',
					'input_dark'       => '#3A3633',

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#0A0300',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#1d1d1d',
					'inverse_light'    => '#333333',
					'inverse_dark'     => '#3A3633',
					'inverse_link'     => '#ffffff',
					'inverse_hover'    => '#ffffff',

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'blue_default'
			'blue_default' => array(
				'title'    => esc_html__( 'Blue Default', 'cobble' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#FFFFFF',
					'bd_color'         => '#D6D6D3',

					// Text and links colors
					'text'             => '#707376',
					'text_light'       => '#A5A6AA',
					'text_dark'        => '#3A3633',
					'text_link'        => '#347FFE',
					'text_hover'       => '#0354DF',
					'text_link2'       => '#FEB334',
					'text_hover2'      => '#F8A415',
					'text_link3'       => '#6DA88F',
					'text_hover3'      => '#579279',

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#EEF4FC',
					'alter_bg_hover'   => '#EEEEEE',
					'alter_bd_color'   => '#D6D6D3',
					'alter_bd_hover'   => '#DCDCDC',
					'alter_text'       => '#707376',
					'alter_light'      => '#A5A6AA',
					'alter_dark'       => '#3A3633',
					'alter_link'       => '#347FFE',
					'alter_hover'      => '#0354DF',
					'alter_link2'      => '#FEB334',
					'alter_hover2'     => '#F8A415',
					'alter_link3'      => '#6DA88F',
					'alter_hover3'     => '#579279',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#040817',
					'extra_bg_hover'   => '#3f3d47',
					'extra_bd_color'   => '#313131',
					'extra_bd_hover'   => '#575757',
					'extra_text'       => '#B0B3BC',
					'extra_light'      => '#9497A0',
					'extra_dark'       => '#ffffff',
					'extra_link'       => '#347FFE',
					'extra_hover'      => '#ffffff',
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent',
					'input_bg_hover'   => 'transparent',
					'input_bd_color'   => '#D6D6D3',
					'input_bd_hover'   => '#3A3633',
					'input_text'       => '#A5A6AA',
					'input_light'      => '#A5A6AA',
					'input_dark'       => '#3A3633',

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#0A0300',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#1d1d1d',
					'inverse_light'    => '#333333',
					'inverse_dark'     => '#3A3633',
					'inverse_link'     => '#ffffff',
					'inverse_hover'    => '#ffffff',

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'blue_dark'
			'blue_dark'    => array(
				'title'    => esc_html__( 'Blue Dark', 'cobble' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#040817',
					'bd_color'         => '#31302D',

					// Text and links colors
					'text'             => '#B0B3BC',
					'text_light'       => '#9497A0',
					'text_dark'        => '#FCFCFC',
					'text_link'        => '#347FFE',
					'text_hover'       => '#0354DF',
					'text_link2'       => '#FEB334',
					'text_hover2'      => '#F8A415',
					'text_link3'       => '#6DA88F',
					'text_hover3'      => '#579279',

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#0E173B',
					'alter_bg_hover'   => '#151F46',
					'alter_bd_color'   => '#31302D',
					'alter_bd_hover'   => '#53535C',
					'alter_text'       => '#B0B3BC',
					'alter_light'      => '#9497A0',
					'alter_dark'       => '#FCFCFC',
					'alter_link'       => '#347FFE',
					'alter_hover'      => '#0354DF',
					'alter_link2'      => '#FEB334',
					'alter_hover2'     => '#F8A415',
					'alter_link3'      => '#6DA88F',
					'alter_hover3'     => '#579279',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#040817',
					'extra_bg_hover'   => '#3f3d47',
					'extra_bd_color'   => '#313131',
					'extra_bd_hover'   => '#575757',
					'extra_text'       => '#B0B3BC',
					'extra_light'      => '#9497A0',
					'extra_dark'       => '#ffffff',
					'extra_link'       => '#347FFE',
					'extra_hover'      => '#ffffff',
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent',
					'input_bg_hover'   => 'transparent',
					'input_bd_color'   => '#31302D',
					'input_bd_hover'   => '#31302D',
					'input_text'       => '#B0B3BC',
					'input_light'      => '#B0B3BC',
					'input_dark'       => '#ffffff',

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#0A0300',
					'inverse_bd_hover' => '#cb5b47',
					'inverse_text'     => '#FCFCFC',
					'inverse_light'    => '#6f6f6f',
					'inverse_dark'     => '#3A3633',
					'inverse_link'     => '#ffffff',
					'inverse_hover'    => '#3A3633',

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'blue_light'
			'blue_light' => array(
				'title'    => esc_html__( 'Blue Light', 'cobble' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#EEF4FC',
					'bd_color'         => '#D6D6D3',

					// Text and links colors
					'text'             => '#707376',
					'text_light'       => '#A5A6AA',
					'text_dark'        => '#3A3633',
					'text_link'        => '#347FFE',
					'text_hover'       => '#0354DF',
					'text_link2'       => '#FEB334',
					'text_hover2'      => '#F8A415',
					'text_link3'       => '#6DA88F',
					'text_hover3'      => '#579279',

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#FFFFFF',
					'alter_bg_hover'   => '#EEEEEE',
					'alter_bd_color'   => '#D6D6D3',
					'alter_bd_hover'   => '#DCDCDC',
					'alter_text'       => '#707376',
					'alter_light'      => '#A5A6AA',
					'alter_dark'       => '#3A3633',
					'alter_link'       => '#347FFE',
					'alter_hover'      => '#0354DF',
					'alter_link2'      => '#FEB334',
					'alter_hover2'     => '#F8A415',
					'alter_link3'      => '#6DA88F',
					'alter_hover3'     => '#579279',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#040817',
					'extra_bg_hover'   => '#3f3d47',
					'extra_bd_color'   => '#313131',
					'extra_bd_hover'   => '#575757',
					'extra_text'       => '#B0B3BC',
					'extra_light'      => '#9497A0',
					'extra_dark'       => '#ffffff',
					'extra_link'       => '#347FFE',
					'extra_hover'      => '#ffffff',
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent',
					'input_bg_hover'   => 'transparent',
					'input_bd_color'   => '#D6D6D3',
					'input_bd_hover'   => '#3A3633',
					'input_text'       => '#A5A6AA',
					'input_light'      => '#A5A6AA',
					'input_dark'       => '#3A3633',

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#0A0300',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#1d1d1d',
					'inverse_light'    => '#333333',
					'inverse_dark'     => '#3A3633',
					'inverse_link'     => '#ffffff',
					'inverse_hover'    => '#ffffff',

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),
		);
		cobble_storage_set( 'schemes', $schemes );
		cobble_storage_set( 'schemes_original', $schemes );

		// Add names of additional colors
		//---> For example:
		//---> cobble_storage_set_array( 'scheme_color_names', 'new_color1', array(
		//---> 	'title'       => __( 'New color 1', 'cobble' ),
		//---> 	'description' => __( 'Description of the new color 1', 'cobble' ),
		//---> ) );


		// Additional colors for each scheme
		// Parameters:	'color' - name of the color from the scheme that should be used as source for the transformation
		//				'alpha' - to make color transparent (0.0 - 1.0)
		//				'hue', 'saturation', 'brightness' - inc/dec value for each color's component
		cobble_storage_set(
			'scheme_colors_add', array(
				'bg_color_0'        => array(
					'color' => 'bg_color',
					'alpha' => 0,
				),
				'bg_color_02'       => array(
					'color' => 'bg_color',
					'alpha' => 0.2,
				),
				'bg_color_07'       => array(
					'color' => 'bg_color',
					'alpha' => 0.7,
				),
				'bg_color_08'       => array(
					'color' => 'bg_color',
					'alpha' => 0.8,
				),
				'bg_color_09'       => array(
					'color' => 'bg_color',
					'alpha' => 0.9,
				),
				'alter_bg_color_07' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.7,
				),
				'alter_bg_color_04' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.4,
				),
				'alter_bg_color_00' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0,
				),
				'alter_bg_color_02' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.2,
				),
				'alter_bd_color_02' => array(
					'color' => 'alter_bd_color',
					'alpha' => 0.2,
				),
                'alter_dark_015'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.15,
                ),
                'alter_dark_02'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.2,
                ),
                'alter_dark_05'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.5,
                ),
                'alter_dark_08'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.8,
                ),
				'alter_link_02'     => array(
					'color' => 'alter_link',
					'alpha' => 0.2,
				),
				'alter_link_07'     => array(
					'color' => 'alter_link',
					'alpha' => 0.7,
				),
				'extra_bg_color_00' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0,
				),
				'extra_bg_color_03' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.3,
				),
				'extra_bg_color_05' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.5,
				),
				'extra_bg_color_06' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.6,
				),
				'extra_bg_color_07' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.7,
				),
				'extra_link_02'     => array(
					'color' => 'extra_link',
					'alpha' => 0.2,
				),
				'extra_link_07'     => array(
					'color' => 'extra_link',
					'alpha' => 0.7,
				),
                'text_dark_003'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.03,
                ),
                'text_dark_005'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.05,
                ),
                'text_dark_008'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.08,
                ),
				'text_dark_015'      => array(
					'color' => 'text_dark',
					'alpha' => 0.15,
				),
				'text_dark_02'      => array(
					'color' => 'text_dark',
					'alpha' => 0.2,
				),
                'text_dark_03'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.3,
                ),
                'text_dark_05'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.5,
                ),
				'text_dark_07'      => array(
					'color' => 'text_dark',
					'alpha' => 0.7,
				),
                'text_dark_08'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.8,
                ),
                'text_link_007'      => array(
                    'color' => 'text_link',
                    'alpha' => 0.07,
                ),
				'text_link_02'      => array(
					'color' => 'text_link',
					'alpha' => 0.2,
				),
                'text_link_03'      => array(
                    'color' => 'text_link',
                    'alpha' => 0.3,
                ),
				'text_link_04'      => array(
					'color' => 'text_link',
					'alpha' => 0.4,
				),
				'text_link_07'      => array(
					'color' => 'text_link',
					'alpha' => 0.7,
				),
				'text_link2_08'      => array(
                    'color' => 'text_link2',
                    'alpha' => 0.8,
                ),
                'text_link2_007'      => array(
                    'color' => 'text_link2',
                    'alpha' => 0.07,
                ),
				'text_link2_02'      => array(
					'color' => 'text_link2',
					'alpha' => 0.2,
				),
                'text_link2_03'      => array(
                    'color' => 'text_link2',
                    'alpha' => 0.3,
                ),
				'text_link2_05'      => array(
					'color' => 'text_link2',
					'alpha' => 0.5,
				),
                'text_link3_007'      => array(
                    'color' => 'text_link3',
                    'alpha' => 0.07,
                ),
				'text_link3_02'      => array(
					'color' => 'text_link3',
					'alpha' => 0.2,
				),
                'text_link3_03'      => array(
                    'color' => 'text_link3',
                    'alpha' => 0.3,
                ),
                'inverse_text_03'      => array(
                    'color' => 'inverse_text',
                    'alpha' => 0.3,
                ),
                'inverse_link_08'      => array(
                    'color' => 'inverse_link',
                    'alpha' => 0.8,
                ),
                'inverse_hover_08'      => array(
                    'color' => 'inverse_hover',
                    'alpha' => 0.8,
                ),
				'text_dark_blend'   => array(
					'color'      => 'text_dark',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
				'text_link_blend'   => array(
					'color'      => 'text_link',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
				'alter_link_blend'  => array(
					'color'      => 'alter_link',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
			)
		);

		// Simple scheme editor: lists the colors to edit in the "Simple" mode.
		// For each color you can set the array of 'slave' colors and brightness factors that are used to generate new values,
		// when 'main' color is changed
		// Leave 'slave' arrays empty if your scheme does not have a color dependency
		cobble_storage_set(
			'schemes_simple', array(
				'text_link'        => array(),
				'text_hover'       => array(),
				'text_link2'       => array(),
				'text_hover2'      => array(),
				'text_link3'       => array(),
				'text_hover3'      => array(),
				'alter_link'       => array(),
				'alter_hover'      => array(),
				'alter_link2'      => array(),
				'alter_hover2'     => array(),
				'alter_link3'      => array(),
				'alter_hover3'     => array(),
				'extra_link'       => array(),
				'extra_hover'      => array(),
				'extra_link2'      => array(),
				'extra_hover2'     => array(),
				'extra_link3'      => array(),
				'extra_hover3'     => array(),
			)
		);

		// Parameters to set order of schemes in the css
		cobble_storage_set(
			'schemes_sorted', array(
				'color_scheme',
				'header_scheme',
				'menu_scheme',
				'sidebar_scheme',
				'footer_scheme',
			)
		);

		// Color presets
		cobble_storage_set(
			'color_presets', array(
				'autumn' => array(
								'title'  => esc_html__( 'Autumn', 'cobble' ),
								'colors' => array(
												'default' => array(
																	'text_link'  => '#d83938',
																	'text_hover' => '#f2b232',
																	),
												'dark' => array(
																	'text_link'  => '#d83938',
																	'text_hover' => '#f2b232',
																	)
												)
							),
				'green' => array(
								'title'  => esc_html__( 'Natural Green', 'cobble' ),
								'colors' => array(
												'default' => array(
																	'text_link'  => '#75ac78',
																	'text_hover' => '#378e6d',
																	),
												'dark' => array(
																	'text_link'  => '#75ac78',
																	'text_hover' => '#378e6d',
																	)
												)
							),
			)
		);
	}
}


// Activation methods
if ( ! function_exists( 'cobble_skin_filter_activation_methods2' ) ) {
    add_filter( 'trx_addons_filter_activation_methods', 'cobble_skin_filter_activation_methods2', 11, 1 );
    function cobble_skin_filter_activation_methods2( $args ) {
        $args['elements_key'] = true;
        return $args;
    }
}


//Enqueue skin-specific scripts
if ( ! function_exists( 'cobble_skin_upgrade_style' ) ) {
	add_action( 'wp_enqueue_scripts', 'cobble_skin_upgrade_style', 2060 );
	function cobble_skin_upgrade_style() {
		$cobble_url = cobble_get_file_url( cobble_skins_get_current_skin_dir() . 'skin-upgrade-style.css' );	
		if ( '' != $cobble_url ) {
			wp_enqueue_style( 'cobble-skin-upgrade-style' . esc_attr( cobble_skins_get_current_skin_name() ), $cobble_url, array(), null );
		}
	}
}


// Enqueue styles
$cobble_clone_style_path = cobble_get_file_dir( cobble_skins_get_current_skin_dir() . 'skin-upgrade-style.php' );
if ( ! empty( $cobble_clone_style_path ) ) {
	require_once $cobble_clone_style_path;
}
