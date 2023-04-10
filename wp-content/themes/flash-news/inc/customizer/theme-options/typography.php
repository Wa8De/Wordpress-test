<?php
/**
 * Typography
 *
 * @package Flash_News
 */

$wp_customize->add_section(
	'flash_news_typography',
	array(
		'panel' => 'flash_news_theme_options',
		'title' => esc_html__( 'Typography', 'flash-news' ),
	)
);

// Typography - Site Title Font.
$wp_customize->add_setting(
	'flash_news_site_title_font',
	array(
		'default'           => 'Source Sans Pro',
		'sanitize_callback' => 'flash_news_sanitize_google_fonts',
	)
);

$wp_customize->add_control(
	'flash_news_site_title_font',
	array(
		'label'    => esc_html__( 'Site Title Font Family', 'flash-news' ),
		'section'  => 'flash_news_typography',
		'settings' => 'flash_news_site_title_font',
		'type'     => 'select',
		'choices'  => flash_news_get_all_google_font_families(),
	)
);

// Typography - Site Description Font.
$wp_customize->add_setting(
	'flash_news_site_description_font',
	array(
		'default'           => 'Lato',
		'sanitize_callback' => 'flash_news_sanitize_google_fonts',
	)
);

$wp_customize->add_control(
	'flash_news_site_description_font',
	array(
		'label'    => esc_html__( 'Site Description Font Family', 'flash-news' ),
		'section'  => 'flash_news_typography',
		'settings' => 'flash_news_site_description_font',
		'type'     => 'select',
		'choices'  => flash_news_get_all_google_font_families(),
	)
);

// Typography - Header Font.
$wp_customize->add_setting(
	'flash_news_header_font',
	array(
		'default'           => 'Source Sans Pro',
		'sanitize_callback' => 'flash_news_sanitize_google_fonts',
	)
);

$wp_customize->add_control(
	'flash_news_header_font',
	array(
		'label'    => esc_html__( 'Header Font Family', 'flash-news' ),
		'section'  => 'flash_news_typography',
		'settings' => 'flash_news_header_font',
		'type'     => 'select',
		'choices'  => flash_news_get_all_google_font_families(),
	)
);

// Typography - Body Font.
$wp_customize->add_setting(
	'flash_news_body_font',
	array(
		'default'           => 'Lato',
		'sanitize_callback' => 'flash_news_sanitize_google_fonts',
	)
);

$wp_customize->add_control(
	'flash_news_body_font',
	array(
		'label'    => esc_html__( 'Body Font Family', 'flash-news' ),
		'section'  => 'flash_news_typography',
		'settings' => 'flash_news_body_font',
		'type'     => 'select',
		'choices'  => flash_news_get_all_google_font_families(),
	)
);
