<?php
/**
 * Sidebar Position
 *
 * @package Flash_News
 */

$wp_customize->add_section(
	'flash_news_sidebar_position',
	array(
		'title' => esc_html__( 'Sidebar Position', 'flash-news' ),
		'panel' => 'flash_news_theme_options',
	)
);

// Sidebar Position - Global Sidebar Position.
$wp_customize->add_setting(
	'flash_news_sidebar_position',
	array(
		'sanitize_callback' => 'flash_news_sanitize_select',
		'default'           => 'right-sidebar',
	)
);

$wp_customize->add_control(
	'flash_news_sidebar_position',
	array(
		'label'   => esc_html__( 'Global Sidebar Position', 'flash-news' ),
		'section' => 'flash_news_sidebar_position',
		'type'    => 'select',
		'choices' => array(
			'right-sidebar' => esc_html__( 'Right Sidebar', 'flash-news' ),
			'left-sidebar'  => esc_html__( 'Left Sidebar', 'flash-news' ),
			'no-sidebar'    => esc_html__( 'No Sidebar', 'flash-news' ),
		),
	)
);

// Sidebar Position - Post Sidebar Position.
$wp_customize->add_setting(
	'flash_news_post_sidebar_position',
	array(
		'sanitize_callback' => 'flash_news_sanitize_select',
		'default'           => 'right-sidebar',
	)
);

$wp_customize->add_control(
	'flash_news_post_sidebar_position',
	array(
		'label'   => esc_html__( 'Post Sidebar Position', 'flash-news' ),
		'section' => 'flash_news_sidebar_position',
		'type'    => 'select',
		'choices' => array(
			'right-sidebar' => esc_html__( 'Right Sidebar', 'flash-news' ),
			'left-sidebar'  => esc_html__( 'Left Sidebar', 'flash-news' ),
			'no-sidebar'    => esc_html__( 'No Sidebar', 'flash-news' ),
		),
	)
);

// Sidebar Position - Page Sidebar Position.
$wp_customize->add_setting(
	'flash_news_page_sidebar_position',
	array(
		'sanitize_callback' => 'flash_news_sanitize_select',
		'default'           => 'right-sidebar',
	)
);

$wp_customize->add_control(
	'flash_news_page_sidebar_position',
	array(
		'label'   => esc_html__( 'Page Sidebar Position', 'flash-news' ),
		'section' => 'flash_news_sidebar_position',
		'type'    => 'select',
		'choices' => array(
			'right-sidebar' => esc_html__( 'Right Sidebar', 'flash-news' ),
			'left-sidebar'  => esc_html__( 'Left Sidebar', 'flash-news' ),
			'no-sidebar'    => esc_html__( 'No Sidebar', 'flash-news' ),
		),
	)
);
