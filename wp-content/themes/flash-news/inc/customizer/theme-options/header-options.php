<?php
/**
 * Header Options
 *
 * @package Flash_News
 */

$wp_customize->add_section(
	'flash_news_header_options',
	array(
		'panel' => 'flash_news_theme_options',
		'title' => esc_html__( 'Header Options', 'flash-news' ),
	)
);

// Header Options - Enable Topbar.
$wp_customize->add_setting(
	'flash_news_enable_topbar',
	array(
		'sanitize_callback' => 'flash_news_sanitize_switch',
		'default'           => false,
	)
);

$wp_customize->add_control(
	new Flash_News_Toggle_Switch_Custom_Control(
		$wp_customize,
		'flash_news_enable_topbar',
		array(
			'label'   => esc_html__( 'Enable Topbar', 'flash-news' ),
			'section' => 'flash_news_header_options',
		)
	)
);

// Header Section - Advertisement.
$wp_customize->add_setting(
	'flash_news_header_advertisement',
	array(
		'sanitize_callback' => 'flash_news_sanitize_image',
	)
);

$wp_customize->add_control(
	new WP_Customize_Image_Control(
		$wp_customize,
		'flash_news_header_advertisement',
		array(
			'label'    => esc_html__( 'Advertisement', 'flash-news' ),
			'section'  => 'flash_news_header_options',
			'settings' => 'flash_news_header_advertisement',
		)
	)
);

// Header Section - Advertisement URL.
$wp_customize->add_setting(
	'flash_news_header_advertisement_url',
	array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	)
);

$wp_customize->add_control(
	'flash_news_header_advertisement_url',
	array(
		'label'    => esc_html__( 'Advertisement URL', 'flash-news' ),
		'section'  => 'flash_news_header_options',
		'settings' => 'flash_news_header_advertisement_url',
		'type'     => 'url',
	)
);
