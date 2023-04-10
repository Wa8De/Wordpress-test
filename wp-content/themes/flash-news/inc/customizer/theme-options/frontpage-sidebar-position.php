<?php
/**
 * Frontpage Sidebar Position
 *
 * @package Flash_News
 */

$wp_customize->add_section(
	'flash_news_frontpage_sidebar',
	array(
		'panel' => 'flash_news_theme_options',
		'title' => esc_html__( 'Frontpage Sidebar Position', 'flash-news' ),
	)
);

// Frontpage Sidebar Position - Frontpage Sidebar Position.
$wp_customize->add_setting(
	'flash_news_frontpage_sidebar_position',
	array(
		'default'           => 'frontpage-right-sidebar',
		'sanitize_callback' => 'flash_news_sanitize_select',
	)
);

$wp_customize->add_control(
	'flash_news_frontpage_sidebar_position',
	array(
		'label'    => esc_html__( 'Frontpage Sidebar Position', 'flash-news' ),
		'section'  => 'flash_news_frontpage_sidebar',
		'settings' => 'flash_news_frontpage_sidebar_position',
		'type'     => 'select',
		'choices'  => array(
			'frontpage-left-sidebar'  => __( 'Left', 'flash-news' ),
			'frontpage-right-sidebar' => __( 'Right', 'flash-news' ),
			'no-frontpage-sidebar'    => __( 'No Sidebar', 'flash-news' ),
		),
	)
);
