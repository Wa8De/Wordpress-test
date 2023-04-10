<?php
/**
 * Breadcrumb
 *
 * @package Flash_News
 */

$wp_customize->add_section(
	'flash_news_breadcrumb',
	array(
		'title' => esc_html__( 'Breadcrumb', 'flash-news' ),
		'panel' => 'flash_news_theme_options',
	)
);

// Breadcrumb - Enable Breadcrumb.
$wp_customize->add_setting(
	'flash_news_enable_breadcrumb',
	array(
		'sanitize_callback' => 'flash_news_sanitize_switch',
		'default'           => true,
	)
);

$wp_customize->add_control(
	new Flash_News_Toggle_Switch_Custom_Control(
		$wp_customize,
		'flash_news_enable_breadcrumb',
		array(
			'label'   => esc_html__( 'Enable Breadcrumb', 'flash-news' ),
			'section' => 'flash_news_breadcrumb',
		)
	)
);

// Breadcrumb - Separator.
$wp_customize->add_setting(
	'flash_news_breadcrumb_separator',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => '/',
	)
);

$wp_customize->add_control(
	'flash_news_breadcrumb_separator',
	array(
		'label'           => esc_html__( 'Separator', 'flash-news' ),
		'active_callback' => 'flash_news_is_breadcrumb_enabled',
		'section'         => 'flash_news_breadcrumb',
	)
);
