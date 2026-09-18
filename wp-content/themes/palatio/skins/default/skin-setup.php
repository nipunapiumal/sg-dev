<?php
/**
 * Skin Setup
 *
 * @package PALATIO
 * @since PALATIO 1.76.0
 */


//--------------------------------------------
// SKIN DEFAULTS
//--------------------------------------------

// Return theme's (skin's) default value for the specified parameter
if ( ! function_exists( 'palatio_theme_defaults' ) ) {
	function palatio_theme_defaults( $name='', $value='' ) {
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
if ( ! function_exists( 'palatio_skin_woocommerce_allow_extensions' ) ) {
	add_filter( 'palatio_filter_load_woocommerce_extensions', 'palatio_skin_woocommerce_allow_extensions' );
	function palatio_skin_woocommerce_allow_extensions( $allow ) {
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
if ( ! function_exists( 'palatio_skin_setup' ) ) {
	add_action( 'after_setup_theme', 'palatio_skin_setup', 1 );
	function palatio_skin_setup() {

		$GLOBALS['PALATIO_STORAGE'] = array_merge( $GLOBALS['PALATIO_STORAGE'], array(

			// Key validator: market[env|loc]-vendor[axiom|ancora|themerex]
			'theme_pro_key'       => 'env-axiom',

			'theme_doc_url'       => '//doc.themerex.net/palatio/',

			'theme_demofiles_url' => '//demofiles.axiomthemes.com/palatio/',
			
			'theme_rate_url'      => '//themeforest.net/downloads',

			'theme_custom_url'    => '//themerex.net/offers/?utm_source=offers&utm_medium=click&utm_campaign=themeinstall',

			'theme_support_url'   => '//themerex.net/support/',

			'theme_download_url'  => '//themeforest.net/user/axiomthemes/portfolio',         // Axiom

			'theme_video_url'     => '//www.youtube.com/channel/UCBjqhuwKj3MfE3B6Hg2oA8Q',   // Axiom

			'theme_privacy_url'   => '//axiomthemes.com/privacy-policy/',                    // Axiom

			'portfolio_url'       => '//themeforest.net/user/axiomthemes/portfolio',         // Axiom

			// Comma separated slugs of theme-specific categories (for get relevant news in the dashboard widget)
			// (i.e. 'children,kindergarten')
			'theme_categories'    => '',
		) );
	}
}


// Add/remove/change Theme Settings
if ( ! function_exists( 'palatio_skin_setup_settings' ) ) {
	add_action( 'after_setup_theme', 'palatio_skin_setup_settings', 1 );
	function palatio_skin_setup_settings() {
		// Example: enable (true) / disable (false) thumbs in the prev/next navigation
		palatio_storage_set_array( 'settings', 'thumbs_in_navigation', false );
		palatio_storage_merge_array( 'required_plugins', '', array(
			'wp-booking-system' => array(
				'title'       => esc_html__( 'WP Booking System – Booking Calendar', 'palatio' ),
				'description' => '',
				'required'    => false,
				'install'     => true,
				'logo'        => palatio_get_file_url( 'plugins/wp-booking-system/wp-booking-system.jpg' ),
			),
		) );
		
//		fw_print(palatio_storage_get_array( 'required_plugins'));
	}
}




//--------------------------------------------
// SKIN FONTS
//--------------------------------------------
if ( ! function_exists( 'palatio_skin_setup_fonts' ) ) {
	add_action( 'after_setup_theme', 'palatio_skin_setup_fonts', 1 );
	function palatio_skin_setup_fonts() {
		// Fonts to load when theme start
		// It can be:
		// - Google fonts (specify name, family and styles)
		// - Adobe fonts (specify name, family and link URL)
		// - uploaded fonts (specify name, family), placed in the folder css/font-face/font-name inside the skin folder
		// Attention! Font's folder must have name equal to the font's name, with spaces replaced on the dash '-'
		// example: font name 'TeX Gyre Termes', folder 'TeX-Gyre-Termes'
		palatio_storage_set(
			'load_fonts', array(
				array(
					'name'   => 'ivypresto-display',
					'family' => 'serif',
					'link'   => 'https://use.typekit.net/uyr3aws.css',
					'styles' => ''
				),
				// Google font
				array(
					'name'   => 'Open Sans',
					'family' => 'sans-serif',
					'link'   => '',
					'styles' => 'ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800',     // Parameter 'style' used only for the Google fonts
				),
			)
		);

		// Characters subset for the Google fonts. Available values are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese
		palatio_storage_set( 'load_fonts_subset', 'latin,latin-ext' );

		// Settings of the main tags.
		// Default value of 'font-family' may be specified as reference to the array $load_fonts (see above)
		// or as comma-separated string.
		// In the second case (if 'font-family' is specified manually as comma-separated string):
		//    1) Font name with spaces in the parameter 'font-family' will be enclosed in the quotes and no spaces after comma!
		//    2) If font-family inherit a value from the 'Main text' - specify 'inherit' as a value
		// example:
		// Correct:   'font-family' => palatio_get_load_fonts_family_string( $load_fonts[0] )
		// Correct:   'font-family' => 'Roboto,sans-serif'
		// Correct:   'font-family' => '"PT Serif",sans-serif'
		// Incorrect: 'font-family' => 'Roboto, sans-serif'
		// Incorrect: 'font-family' => 'PT Serif,sans-serif'

		$font_description = esc_html__( 'Font settings for the %s of the site. To ensure that the elements scale properly on mobile devices, please use only the following units: "rem", "em" or "ex"', 'palatio' );

		palatio_storage_set(
			'theme_fonts', array(
				'p'       => array(
					'title'           => esc_html__( 'Main text', 'palatio' ),
					'description'     => sprintf( $font_description, esc_html__( 'main text', 'palatio' ) ),
					'font-family'     => '"Open Sans",sans-serif',
					'font-size'       => '1rem',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.8em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '0em',
					'margin-bottom'   => '1.8em',
				),
				'post'    => array(
					'title'           => esc_html__( 'Article text', 'palatio' ),
					'description'     => sprintf( $font_description, esc_html__( 'article text', 'palatio' ) ),
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
					'title'           => esc_html__( 'Heading 1', 'palatio' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H1', 'palatio' ) ),
					'font-family'     => 'ivypresto-display,serif',
					'font-size'       => '3.563em',
					'font-weight'     => '300',
					'font-style'      => 'normal',
					'line-height'     => '1.021em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '1.04em',
					'margin-bottom'   => '0.46em',
				),
				'h2'      => array(
					'title'           => esc_html__( 'Heading 2', 'palatio' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H2', 'palatio' ) ),
					'font-family'     => 'ivypresto-display,serif',
					'font-size'       => '2.938em',
					'font-weight'     => '300',
					'font-style'      => 'normal',
					'line-height'     => '1.021em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '0.67em',
					'margin-bottom'   => '0.56em',
				),
				'h3'      => array(
					'title'           => esc_html__( 'Heading 3', 'palatio' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H3', 'palatio' ) ),
					'font-family'     => 'ivypresto-display,serif',
					'font-size'       => '2.188em',
					'font-weight'     => '300',
					'font-style'      => 'normal',
					'line-height'     => '1.086em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '0.94em',
					'margin-bottom'   => '0.72em',
				),
				'h4'      => array(
					'title'           => esc_html__( 'Heading 4', 'palatio' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H4', 'palatio' ) ),
					'font-family'     => 'ivypresto-display,serif',
					'font-size'       => '1.750em',
					'font-weight'     => '300',
					'font-style'      => 'normal',
					'line-height'     => '1.214em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '1.15em',
					'margin-bottom'   => '0.83em',
				),
				'h5'      => array(
					'title'           => esc_html__( 'Heading 5', 'palatio' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H5', 'palatio' ) ),
					'font-family'     => 'ivypresto-display,serif',
					'font-size'       => '1.500em',
					'font-weight'     => '300',
					'font-style'      => 'normal',
					'line-height'     => '1.208em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '1.3em',
					'margin-bottom'   => '0.84em',
				),
				'h6'      => array(
					'title'           => esc_html__( 'Heading 6', 'palatio' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H6', 'palatio' ) ),
					'font-family'     => 'ivypresto-display,serif',
					'font-size'       => '1.188em',
					'font-weight'     => '300',
					'font-style'      => 'normal',
					'line-height'     => '1.474em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '1.75em',
					'margin-bottom'   => '1em',
				),
				'logo'    => array(
					'title'           => esc_html__( 'Logo text', 'palatio' ),
					'description'     => sprintf( $font_description, esc_html__( 'text of the logo', 'palatio' ) ),
					'font-family'     => 'ivypresto-display,serif',
					'font-size'       => '1.8em',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.25em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'button'  => array(
					'title'           => esc_html__( 'Buttons', 'palatio' ),
					'description'     => sprintf( $font_description, esc_html__( 'buttons', 'palatio' ) ),
					'font-family'     => 'ivypresto-display,serif',
					'font-size'       => '17px',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '21px',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'input'   => array(
					'title'           => esc_html__( 'Input fields', 'palatio' ),
					'description'     => sprintf( $font_description, esc_html__( 'input fields, dropdowns and textareas', 'palatio' ) ),
					'font-family'     => 'inherit',
					'font-size'       => '15px',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',     // Attention! Firefox don't allow line-height less then 1.5em in the select
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0.1px',
				),
				'info'    => array(
					'title'           => esc_html__( 'Post meta', 'palatio' ),
					'description'     => sprintf( $font_description, esc_html__( 'post meta (author, categories, publish date, counters, share, etc.)', 'palatio' ) ),
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
					'title'           => esc_html__( 'Main menu', 'palatio' ),
					'description'     => sprintf( $font_description, esc_html__( 'main menu items', 'palatio' ) ),
					'font-family'     => 'ivypresto-display,serif',
					'font-size'       => '17px',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'submenu' => array(
					'title'           => esc_html__( 'Dropdown menu', 'palatio' ),
					'description'     => sprintf( $font_description, esc_html__( 'dropdown menu items', 'palatio' ) ),
					'font-family'     => '"Open Sans",sans-serif',
					'font-size'       => '14px',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'other' => array(
					'title'           => esc_html__( 'Other', 'palatio' ),
					'description'     => sprintf( $font_description, esc_html__( 'specific elements', 'palatio' ) ),
					'font-family'     => 'ivypresto-display,serif',
				),
			)
		);

		// Font presets
		palatio_storage_set(
			'font_presets', array(
				'karla' => array(
								'title'  => esc_html__( 'Karla', 'palatio' ),
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
								'title'  => esc_html__( 'Roboto', 'palatio' ),
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
								'title'  => esc_html__( 'Garamond', 'palatio' ),
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
if ( ! function_exists( 'palatio_skin_setup_schemes' ) ) {
	add_action( 'after_setup_theme', 'palatio_skin_setup_schemes', 1 );
	function palatio_skin_setup_schemes() {

		// Theme colors for customizer
		// Attention! Inner scheme must be last in the array below
		palatio_storage_set(
			'scheme_color_groups', array(
				'main'    => array(
					'title'       => esc_html__( 'Main', 'palatio' ),
					'description' => esc_html__( 'Colors of the main content area', 'palatio' ),
				),
				'alter'   => array(
					'title'       => esc_html__( 'Alter', 'palatio' ),
					'description' => esc_html__( 'Colors of the alternative blocks (sidebars, etc.)', 'palatio' ),
				),
				'extra'   => array(
					'title'       => esc_html__( 'Extra', 'palatio' ),
					'description' => esc_html__( 'Colors of the extra blocks (dropdowns, price blocks, table headers, etc.)', 'palatio' ),
				),
				'inverse' => array(
					'title'       => esc_html__( 'Inverse', 'palatio' ),
					'description' => esc_html__( 'Colors of the inverse blocks - when link color used as background of the block (dropdowns, blockquotes, etc.)', 'palatio' ),
				),
				'input'   => array(
					'title'       => esc_html__( 'Input', 'palatio' ),
					'description' => esc_html__( 'Colors of the form fields (text field, textarea, select, etc.)', 'palatio' ),
				),
			)
		);

		palatio_storage_set(
			'scheme_color_names', array(
				'bg_color'    => array(
					'title'       => esc_html__( 'Background color', 'palatio' ),
					'description' => esc_html__( 'Background color of this block in the normal state', 'palatio' ),
				),
				'bg_hover'    => array(
					'title'       => esc_html__( 'Background hover', 'palatio' ),
					'description' => esc_html__( 'Background color of this block in the hovered state', 'palatio' ),
				),
				'bd_color'    => array(
					'title'       => esc_html__( 'Border color', 'palatio' ),
					'description' => esc_html__( 'Border color of this block in the normal state', 'palatio' ),
				),
				'bd_hover'    => array(
					'title'       => esc_html__( 'Border hover', 'palatio' ),
					'description' => esc_html__( 'Border color of this block in the hovered state', 'palatio' ),
				),
				'text'        => array(
					'title'       => esc_html__( 'Text', 'palatio' ),
					'description' => esc_html__( 'Color of the text inside this block', 'palatio' ),
				),
				'text_dark'   => array(
					'title'       => esc_html__( 'Text dark', 'palatio' ),
					'description' => esc_html__( 'Color of the dark text (bold, header, etc.) inside this block', 'palatio' ),
				),
				'text_light'  => array(
					'title'       => esc_html__( 'Text light', 'palatio' ),
					'description' => esc_html__( 'Color of the light text (post meta, etc.) inside this block', 'palatio' ),
				),
				'text_link'   => array(
					'title'       => esc_html__( 'Link', 'palatio' ),
					'description' => esc_html__( 'Color of the links inside this block', 'palatio' ),
				),
				'text_hover'  => array(
					'title'       => esc_html__( 'Link hover', 'palatio' ),
					'description' => esc_html__( 'Color of the hovered state of links inside this block', 'palatio' ),
				),
				'text_link2'  => array(
					'title'       => esc_html__( 'Accent 2', 'palatio' ),
					'description' => esc_html__( 'Color of the accented texts (areas) inside this block', 'palatio' ),
				),
				'text_hover2' => array(
					'title'       => esc_html__( 'Accent 2 hover', 'palatio' ),
					'description' => esc_html__( 'Color of the hovered state of accented texts (areas) inside this block', 'palatio' ),
				),
				'text_link3'  => array(
					'title'       => esc_html__( 'Accent 3', 'palatio' ),
					'description' => esc_html__( 'Color of the other accented texts (buttons) inside this block', 'palatio' ),
				),
				'text_hover3' => array(
					'title'       => esc_html__( 'Accent 3 hover', 'palatio' ),
					'description' => esc_html__( 'Color of the hovered state of other accented texts (buttons) inside this block', 'palatio' ),
				),
			)
		);

		// Default values for each color scheme
		$schemes = array(
			
			'default' => array(
				'title'    => esc_html__( 'Default', 'palatio' ),
				'internal' => true,
				'colors'   => array(
					
					// Whole block border and background
					'bg_color'         => '#EFE7D0',
					'bd_color'         => '#CFC49E',
					
					// Text and links colors
					'text'             => '#635756',
					'text_light'       => '#9B9275',
					'text_dark'        => '#12232E',
					'text_link'        => '#D8A01D',
					'text_hover'       => '#C88C00',
					'text_link2'       => '#62C3C9',
					'text_hover2'      => '#3FA9AF',
					'text_link3'       => '#186EDF',
					'text_hover3'      => '#0051BB',
					
					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#F6F3EC',
					'alter_bg_hover'   => '#FCFCFC',
					'alter_bd_color'   => '#CFC49E',
					'alter_bd_hover'   => '#DCCE9E',
					'alter_text'       => '#635756',
					'alter_light'      => '#9B9275',
					'alter_dark'       => '#12232E',
					'alter_link'       => '#D8A01D',
					'alter_hover'      => '#C88C00',
					'alter_link2'      => '#62C3C9',
					'alter_hover2'     => '#3FA9AF',
					'alter_link3'      => '#186EDF',
					'alter_hover3'     => '#0051BB',
					
					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#12232E',
					'extra_bg_hover'   => '#3f3d47',
					'extra_bd_color'   => '#434951',
					'extra_bd_hover'   => '#575757',
					'extra_text'       => '#7A7A7A',
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#FCFCFC',
					'extra_link'       => '#D8A01D',
					'extra_hover'      => '#FCFCFC',
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',
					
					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent',
					'input_bg_hover'   => 'transparent',
					'input_bd_color'   => '#CFC49E',
					'input_bd_hover'   => '#12232E',
					'input_text'       => '#9B9275',
					'input_light'      => '#9B9275',
					'input_dark'       => '#12232E',
					
					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#1d1d1d',
					'inverse_light'    => '#333333',
					'inverse_dark'     => '#12232E',
					'inverse_link'     => '#FCFCFC',
					'inverse_hover'    => '#FCFCFC',
					
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
				'title'    => esc_html__( 'Dark', 'palatio' ),
				'internal' => true,
				'colors'   => array(
					
					// Whole block border and background
					'bg_color'         => '#1D2C36',
					'bd_color'         => '#3C3F47',
					
					// Text and links colors
					'text'             => '#C6C2BE',
					'text_light'       => '#7A7A7A',
					'text_dark'        => '#FCFCFC',
					'text_link'        => '#D8A01D',
					'text_hover'       => '#C88C00',
					'text_link2'       => '#62C3C9',
					'text_hover2'      => '#3FA9AF',
					'text_link3'       => '#186EDF',
					'text_hover3'      => '#0051BB',
					
					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#12232E',
					'alter_bg_hover'   => '#273139',
					'alter_bd_color'   => '#3C3F47',
					'alter_bd_hover'   => '#404346',
					'alter_text'       => '#C6C2BE',
					'alter_light'      => '#7A7A7A',
					'alter_dark'       => '#FCFCFC',
					'alter_link'       => '#D8A01D',
					'alter_hover'      => '#C88C00',
					'alter_link2'      => '#62C3C9',
					'alter_hover2'     => '#3FA9AF',
					'alter_link3'      => '#186EDF',
					'alter_hover3'     => '#0051BB',
					
					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#12232E',
					'extra_bg_hover'   => '#3f3d47',
					'extra_bd_color'   => '#434951',
					'extra_bd_hover'   => '#575757',
					'extra_text'       => '#7A7A7A',
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#FCFCFC',
					'extra_link'       => '#D8A01D',
					'extra_hover'      => '#FCFCFC',
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',
					
					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent',
					'input_bg_hover'   => 'transparent',
					'input_bd_color'   => '#3C3F47',
					'input_bd_hover'   => '#3C3F47',
					'input_text'       => '#C6C2BE',
					'input_light'      => '#C6C2BE',
					'input_dark'       => '#FCFCFC',
					
					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#e36650',
					'inverse_bd_hover' => '#cb5b47',
					'inverse_text'     => '#FCFCFC',
					'inverse_light'    => '#6f6f6f',
					'inverse_dark'     => '#12232E',
					'inverse_link'     => '#FCFCFC',
					'inverse_hover'    => '#12232E',
					
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
				'title'    => esc_html__( 'Light', 'palatio' ),
				'internal' => true,
				'colors'   => array(
					
					// Whole block border and background
					'bg_color'         => '#F6F3EC',
					'bd_color'         => '#CFC49E',
					
					// Text and links colors
					'text'             => '#635756',
					'text_light'       => '#9B9275',
					'text_dark'        => '#12232E',
					'text_link'        => '#D8A01D',
					'text_hover'       => '#C88C00',
					'text_link2'       => '#62C3C9',
					'text_hover2'      => '#3FA9AF',
					'text_link3'       => '#186EDF',
					'text_hover3'      => '#0051BB',
					
					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#EFE7D0',
					'alter_bg_hover'   => '#FCFCFC',
					'alter_bd_color'   => '#CFC49E',
					'alter_bd_hover'   => '#DCCE9E',
					'alter_text'       => '#635756',
					'alter_light'      => '#9B9275',
					'alter_dark'       => '#12232E',
					'alter_link'       => '#D8A01D',
					'alter_hover'      => '#C88C00',
					'alter_link2'      => '#62C3C9',
					'alter_hover2'     => '#3FA9AF',
					'alter_link3'      => '#186EDF',
					'alter_hover3'     => '#0051BB',
					
					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#12232E',
					'extra_bg_hover'   => '#3f3d47',
					'extra_bd_color'   => '#434951',
					'extra_bd_hover'   => '#575757',
					'extra_text'       => '#7A7A7A',
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#FCFCFC',
					'extra_link'       => '#D8A01D',
					'extra_hover'      => '#FCFCFC',
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',
					
					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent',
					'input_bg_hover'   => 'transparent',
					'input_bd_color'   => '#CFC49E',
					'input_bd_hover'   => '#12232E',
					'input_text'       => '#9B9275',
					'input_light'      => '#9B9275',
					'input_dark'       => '#12232E',
					
					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#1d1d1d',
					'inverse_light'    => '#333333',
					'inverse_dark'     => '#12232E',
					'inverse_link'     => '#FCFCFC',
					'inverse_hover'    => '#FCFCFC',
					
					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),
			
			// Color scheme: 'default_red'
			'default_red' => array(
				'title'    => esc_html__( 'Default Red', 'palatio' ),
				'internal' => true,
				'colors'   => array(
					
					// Whole block border and background
					'bg_color'         => '#F6EAD9',
					'bd_color'         => '#EED9C0',
					
					// Text and links colors
					'text'             => '#635756',
					'text_light'       => '#AEAAAA',
					'text_dark'        => '#FC695A',
					'text_link'        => '#65BAB3',
					'text_hover'       => '#209C92',
					'text_link2'       => '#F56916',
					'text_hover2'      => '#D85000',
					'text_link3'       => '#186EDF',
					'text_hover3'      => '#0051BB',
					
					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#F9F4EE',
					'alter_bg_hover'   => '#FFE5C7',
					'alter_bd_color'   => '#EED9C0', // +++
					'alter_bd_hover'   => '#F5E0C7',
					'alter_text'       => '#635756',
					'alter_light'      => '#AEAAAA',
					'alter_dark'       => '#FC695A',
					'alter_link'       => '#65BAB3',
					'alter_hover'      => '#209C92',
					'alter_link2'      => '#F56916',
					'alter_hover2'     => '#D85000',
					'alter_link3'      => '#186EDF',
					'alter_hover3'     => '#0051BB',
					
					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#0F0F10',
					'extra_bg_hover'   => '#3f3d47',
					'extra_bd_color'   => '#434951',
					'extra_bd_hover'   => '#575757',
					'extra_text'       => '#7A7A7A',
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#F9F4EE',
					'extra_link'       => '#65BAB3',
					'extra_hover'      => '#F9F4EE',
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',
					
					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent',
					'input_bg_hover'   => 'transparent',
					'input_bd_color'   => '#EED9C0', // +++
					'input_bd_hover'   => '#F5E0C7',
					'input_text'       => '#AEAAAA',
					'input_light'      => '#AEAAAA',
					'input_dark'       => '#FC695A',
					
					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#1d1d1d',
					'inverse_light'    => '#333333',
					'inverse_dark'     => '#FC695A',
					'inverse_link'     => '#F9F4EE',
					'inverse_hover'    => '#F9F4EE',
					
					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),
			
			// Color scheme: 'dark_red'
			'dark_red'    => array(
				'title'    => esc_html__( 'Dark Red', 'palatio' ),
				'internal' => true,
				'colors'   => array(
					
					// Whole block border and background
					'bg_color'         => '#1F2327',
					'bd_color'         => '#3C3F47',
					
					// Text and links colors
					'text'             => '#C6C2BE',
					'text_light'       => '#7A7A7A',
					'text_dark'        => '#FCFCFC',
					'text_link'        => '#65BAB3',
					'text_hover'       => '#209C92',
					'text_link2'       => '#F56916',
					'text_hover2'      => '#D85000',
					'text_link3'       => '#186EDF',
					'text_hover3'      => '#0051BB',
					
					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#34393E',
					'alter_bg_hover'   => '#222426',
					'alter_bd_color'   => '#3C3F47',
					'alter_bd_hover'   => '#404346',
					'alter_text'       => '#C6C2BE',
					'alter_light'      => '#7A7A7A',
					'alter_dark'       => '#FCFCFC',
					'alter_link'       => '#65BAB3',
					'alter_hover'      => '#209C92',
					'alter_link2'      => '#F56916',
					'alter_hover2'     => '#D85000',
					'alter_link3'      => '#186EDF',
					'alter_hover3'     => '#0051BB',
					
					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#0F0F10',
					'extra_bg_hover'   => '#3f3d47',
					'extra_bd_color'   => '#434951',
					'extra_bd_hover'   => '#575757',
					'extra_text'       => '#7A7A7A',
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#F9F4EE',
					'extra_link'       => '#65BAB3',
					'extra_hover'      => '#F9F4EE',
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',
					
					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent',
					'input_bg_hover'   => 'transparent',
					'input_bd_color'   => '#3C3F47',
					'input_bd_hover'   => '#404346',
					'input_text'       => '#C6C2BE',
					'input_light'      => '#C6C2BE',
					'input_dark'       => '#F9F4EE',
					
					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#e36650',
					'inverse_bd_hover' => '#cb5b47',
					'inverse_text'     => '#F9F9F9',
					'inverse_light'    => '#6f6f6f',
					'inverse_dark'     => '#FC695A',
					'inverse_link'     => '#F9F4EE',
					'inverse_hover'    => '#FC695A',
					
					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),
			
			// Color scheme: 'light_red'
			'light_red' => array(
				'title'    => esc_html__( 'Light Red', 'palatio' ),
				'internal' => true,
				'colors'   => array(
					
					// Whole block border and background
					'bg_color'         => '#F9F4EE',
					'bd_color'         => '#EED9C0', // +++
					
					// Text and links colors
					'text'             => '#635756',
					'text_light'       => '#AEAAAA',
					'text_dark'        => '#FC695A',
					'text_link'        => '#65BAB3',
					'text_hover'       => '#209C92',
					'text_link2'       => '#F56916',
					'text_hover2'      => '#D85000',
					'text_link3'       => '#186EDF',
					'text_hover3'      => '#0051BB',
					
					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#F6EAD9',
					'alter_bg_hover'   => '#FFE5C7',
					'alter_bd_color'   => '#EED9C0',
					'alter_bd_hover'   => '#F5E0C7',
					'alter_text'       => '#635756',
					'alter_light'      => '#AEAAAA',
					'alter_dark'       => '#FC695A',
					'alter_link'       => '#65BAB3',
					'alter_hover'      => '#209C92',
					'alter_link2'      => '#F56916',
					'alter_hover2'     => '#D85000',
					'alter_link3'      => '#186EDF',
					'alter_hover3'     => '#0051BB',
					
					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#0F0F10',
					'extra_bg_hover'   => '#3f3d47',
					'extra_bd_color'   => '#434951',
					'extra_bd_hover'   => '#575757',
					'extra_text'       => '#7A7A7A',
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#F9F4EE',
					'extra_link'       => '#65BAB3',
					'extra_hover'      => '#F9F4EE',
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',
					
					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent',
					'input_bg_hover'   => 'transparent',
					'input_bd_color'   => '#EED9C0',
					'input_bd_hover'   => '#F5E0C7',
					'input_text'       => '#AEAAAA',
					'input_light'      => '#AEAAAA',
					'input_dark'       => '#FC695A',
					
					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#1d1d1d',
					'inverse_light'    => '#333333',
					'inverse_dark'     => '#FC695A',
					'inverse_link'     => '#F9F4EE',
					'inverse_hover'    => '#F9F4EE',
					
					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),
			
			// Color scheme: 'dark_beige'
			'dark_beige'    => array(
				'title'    => esc_html__( 'Dark Beige', 'palatio' ),
				'internal' => true,
				'colors'   => array(
					
					// Whole block border and background
					'bg_color'         => '#181A1C',
					'bd_color'         => '#3C3F47',
					
					// Text and links colors
					'text'             => '#C6C2BE',
					'text_light'       => '#7A7A7A',
					'text_dark'        => '#F9EFED',
					'text_link'        => '#DEA97D',
					'text_hover'       => '#CF915D',
					'text_link2'       => '#8F423C',
					'text_hover2'      => '#BC4E46',
					'text_link3'       => '#B98D6F',
					'text_hover3'      => '#A26E4B',
					
					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#252529',
					'alter_bg_hover'   => '#181A1C',
					'alter_bd_color'   => '#3C3F47',
					'alter_bd_hover'   => '#404346',
					'alter_text'       => '#C6C2BE',
					'alter_light'      => '#7A7A7A',
					'alter_dark'       => '#F9EFED',
					'alter_link'       => '#DEA97D',
					'alter_hover'      => '#CF915D',
					'alter_link2'      => '#8F423C',
					'alter_hover2'     => '#BC4E46',
					'alter_link3'      => '#B98D6F',
					'alter_hover3'     => '#A26E4B',
					
					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#252529',
					'extra_bg_hover'   => '#1D1F21',
					'extra_bd_color'   => '#434951',
					'extra_bd_hover'   => '#575757',
					'extra_text'       => '#7A7A7A',
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#F9EFED',
					'extra_link'       => '#DEA97D',
					'extra_hover'      => '#F9EFED',
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',
					
					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent',
					'input_bg_hover'   => 'transparent',
					'input_bd_color'   => '#3C3F47',
					'input_bd_hover'   => '#3C3F47',
					'input_text'       => '#C6C2BE',
					'input_light'      => '#C6C2BE',
					'input_dark'       => '#F9EFED',
					
					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#e36650',
					'inverse_bd_hover' => '#cb5b47',
					'inverse_text'     => '#F9EFED',
					'inverse_light'    => '#6f6f6f',
					'inverse_dark'     => '#252529',
					'inverse_link'     => '#F9EFED',
					'inverse_hover'    => '#252529',
					
					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),
		);
		palatio_storage_set( 'schemes', $schemes );
		palatio_storage_set( 'schemes_original', $schemes );

		// Add names of additional colors
		//---> For example:
		//---> palatio_storage_set_array( 'scheme_color_names', 'new_color1', array(
		//---> 	'title'       => __( 'New color 1', 'palatio' ),
		//---> 	'description' => __( 'Description of the new color 1', 'palatio' ),
		//---> ) );


		// Additional colors for each scheme
		// Parameters:	'color' - name of the color from the scheme that should be used as source for the transformation
		//				'alpha' - to make color transparent (0.0 - 1.0)
		//				'hue', 'saturation', 'brightness' - inc/dec value for each color's component
		palatio_storage_set(
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
				'bd_color_045' => array(
					'color' => 'alter_bd_color',
					'alpha' => 0.45,
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
				'extra_bg_color_05' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.5,
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
		palatio_storage_set(
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
		palatio_storage_set(
			'schemes_sorted', array(
				'color_scheme',
				'header_scheme',
				'menu_scheme',
				'sidebar_scheme',
				'footer_scheme',
			)
		);

		// Color presets
		palatio_storage_set(
			'color_presets', array(
				'autumn' => array(
								'title'  => esc_html__( 'Autumn', 'palatio' ),
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
								'title'  => esc_html__( 'Natural Green', 'palatio' ),
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

// Theme init priorities:
// 3 - add/remove Theme Options elements
if ( ! function_exists( 'palatio_clone_skin_theme_setup3' ) ) {
	add_action( 'after_setup_theme', 'palatio_clone_skin_theme_setup3', 3 );
	function palatio_clone_skin_theme_setup3() {
		palatio_storage_set_array_after( 'options', 'remove_margins', array(
				'extra_bg_image'        => array(
					'title'      => esc_html__( 'Extra background image', 'palatio' ),
					'desc'       => wp_kses_data( __( 'Select or upload background-image to display it in the page. Does not work for boxed body style.', 'palatio' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'palatio' )
					),
					'dependency' => array(
						'body_style' => array( 'wide', 'fullwide', 'fullscreen' ),
					),
					'std'        => '',
					'pro_only'   => PALATIO_THEME_FREE,
					'type'       => "image"
				),
				'extra_bg_image_size'   => array(
					'title'      => esc_html__( 'Extra background image size', 'palatio' ),
					'desc'       => wp_kses_data( __( 'Select a size of background image', 'palatio' ) ),
					'override'   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'palatio' )
					),
					'dependency' => array(
						'body_style' => array( 'wide', 'fullwide', 'fullscreen' ),
					),
					'pro_only'   => PALATIO_THEME_FREE,
					'std'        => '',
					'options'    => array(
						''        => esc_html__( 'Default', 'palatio' ),
						'auto'    => esc_html__( 'Auto', 'palatio' ),
						'cover'   => esc_html__( 'Cover', 'palatio' ),
						'contain' => esc_html__( 'Contain', 'palatio' ),
					),
					'type'       => 'select'
				),
				'extra_bg_image_repeat' => array(
					'title'      => esc_html__( 'Extra background repeat', 'palatio' ),
					'desc'       => wp_kses_data( __( 'Select a repeat of background image', 'palatio' ) ),
					"override"   => array(
						'mode'    => 'page',
						'section' => esc_html__( 'Content', 'palatio' )
					),
					'dependency' => array(
						'body_style' => array( 'wide', 'fullwide', 'fullscreen' ),
					),
					'pro_only'   => PALATIO_THEME_FREE,
					'std'        => '',
					'options'    => array(
						''       => esc_html__( 'No-repeat', 'palatio' ),
						'repeat' => esc_html__( 'Repeat', 'palatio' ),
					),
					'type'       => 'select'
				),
			)
		);
	}
}

if ( ! function_exists( 'palatio_skin_filter_page_wrap_class' ) ) {
	add_action( 'palatio_filter_page_wrap_class', 'palatio_skin_filter_page_wrap_class' );
	function palatio_skin_filter_page_wrap_class( $class ) {
		$bg_image        = palatio_get_theme_option( 'extra_bg_image' );
		$bg_image_size   = palatio_get_theme_option( 'extra_bg_image_size' );
		$bg_size_class   = $bg_image_size ? 'center/'.$bg_image_size : '';
		$bg_image_repeat = palatio_get_theme_option( 'extra_bg_image_repeat' );
		$bg_repeat_class = $bg_image_repeat ? $bg_image_repeat : 'no-repeat';
		
		$body_boxed_style     = palatio_get_theme_option( 'body_style' ) == 'boxed';
		if ( ! empty( $bg_image ) && ! $body_boxed_style ) {
			$custom_bg = ' with_bg ' . palatio_add_inline_css_class(
				'background: url(' . esc_url( $bg_image ) . ') ' . $bg_repeat_class . ' ' . $bg_size_class . ';'
			);
			$class     = $class . $custom_bg;
		}
		
		return $class;
	}
}

// Add additional height for Spacer and Divider
if ( ! function_exists( 'palatio_clone_add_additional_spacer' ) ) {
	add_filter( 'trx_addons_filter_get_list_sc_empty_space_heights', 'palatio_clone_add_additional_spacer' );
	function palatio_clone_add_additional_spacer( $spaser ) {
		palatio_array_insert_after( $spaser, 'huge', array( 'extra_huge' => esc_html__( 'Extra Huge', 'palatio' ) ) );
		return $spaser;
	}
}

// Enqueue extra styles for frontend
if ( ! function_exists( 'palatio_clone_frontend_scripts' ) ) {
	add_action( 'wp_enqueue_scripts', 'palatio_clone_frontend_scripts', 1150 );
	function palatio_clone_frontend_scripts() {
		$palatio_url = palatio_get_file_url( palatio_skins_get_current_skin_dir() . 'extra-styles.css' );
		if ( '' != $palatio_url ) {
			wp_enqueue_style( 'palatio-extra-skin-' . esc_attr( palatio_skins_get_current_skin_name() ), $palatio_url, array(), null );
		}
	}
}

// Add new file for plugin
$palatio_clone_plugin_booking_system = palatio_get_file_dir( palatio_skins_get_current_skin_dir() . 'plugins/wp-booking-system/wp-booking-system.php' );
if ( ! empty( $palatio_clone_plugin_booking_system ) ) {
	require_once $palatio_clone_plugin_booking_system;
}

// Activation methods
if ( ! function_exists( 'palatio_skin_filter_activation_methods2' ) ) {
	add_filter( 'trx_addons_filter_activation_methods', 'palatio_skin_filter_activation_methods2', 11, 1 );
	function palatio_skin_filter_activation_methods2( $args ) {
		$args['elements_key'] = true;
		return $args;
	}
}

