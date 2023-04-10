<?php

// ----------------------------------------------------------------------------------
//	Register Front-End Styles And Scripts
// ----------------------------------------------------------------------------------

function sento_thinkup_child_frontscripts() {

	wp_enqueue_style( 'thinkup-style', get_template_directory_uri() . '/style.css', array( 'thinkup-bootstrap' ) );
	wp_enqueue_style( 'sento-thinkup-style-news', get_stylesheet_uri(), array( 'thinkup-style' ), wp_get_theme()->get('Version') );

}
add_action( 'wp_enqueue_scripts', 'sento_thinkup_child_frontscripts' );


// ----------------------------------------------------------------------------------
//	Update Options Array With Child Theme Color Values
// ----------------------------------------------------------------------------------

// Add child theme settings to options array - UPDATED 20181101
function sento_thinkup_updateoption_child_settings() {

	// Set theme name combinations
	$name_theme_upper = 'Sento';
	$name_theme_lower = strtolower( $name_theme_upper );

	// Set possible options names
	$name_options_free  = 'thinkup_redux_variables';
	$name_options_child = $name_theme_lower . '_thinkup_child_settings_news';

	// Get options values (theme options)
	$options_free = get_option( $name_options_free );

	// Get child settings values
	$options_child_settings = get_option( $name_options_child );

	// Only set child settings values if not already set 
	if ( $options_child_settings != 1 ) {

		$options_free['thinkup_header_styleswitch'] = '';
		$options_free['thinkup_blog_style']         = 'option1';
		$options_free['thinkup_blog_style1layout']  = 'option2';
		$options_free['thinkup_blog_style2layout']  = 'option1';
		$options_free['thinkup_styles_colorswitch'] = '';
		$options_free['thinkup_styles_colorcustom'] = '';
		$options_free['thinkup_styles_skinswitch']  = '1';
		$options_free['thinkup_styles_skin']        = 'news';

		// Add child settings to theme options array
		update_option( $name_options_free, $options_free );

	}

	// Set the child settings flag
	update_option( $name_options_child, 1 );

}
add_action( 'init', 'sento_thinkup_updateoption_child_settings', 999 );

// Remove child theme settings from options array - UPDATED 20181101
function sento_thinkup_removeoption_child_settings() {

	// Set theme name combinations
	$name_theme_upper = 'Sento';
	$name_theme_lower = strtolower( $name_theme_upper );

	// Set possible options names
	$name_options_free  = 'thinkup_redux_variables';
	$name_options_child = $name_theme_lower . '_thinkup_child_settings_news';

	// Get options values (theme options)
	$options_free = get_option( $name_options_free );

	// Determine if Pro version is installed
	$themes = wp_get_themes();
	foreach ( $themes as $theme ) {
		if( $theme == $name_theme_upper . ' Pro' ) {
			$indicator_pro_installed = '1';
		}
	}

	// If Pro version is not installed then remove child settings on theme switch
	if ( $indicator_pro_installed !== '1' ) {

		$options_free['thinkup_header_styleswitch'] = '';
		$options_free['thinkup_blog_style']         = '';
		$options_free['thinkup_blog_style1layout']  = '';
		$options_free['thinkup_blog_style2layout']  = '';
		$options_free['thinkup_styles_colorswitch'] = '';
		$options_free['thinkup_styles_colorcustom'] = '';
		$options_free['thinkup_styles_skinswitch']  = '';
		$options_free['thinkup_styles_skin']        = '';

		// Add child settings to theme options array
		update_option( $name_options_free, $options_free );

	}

	// Delete the child settings flag
	delete_option( $name_options_child );

}
add_action( 'switch_theme', 'sento_thinkup_removeoption_child_settings' );
