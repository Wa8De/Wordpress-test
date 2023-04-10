<?php
/**
 * Pagination
 *
 * @package Flash_News
 */

$wp_customize->add_section(
	'flash_news_pagination',
	array(
		'panel' => 'flash_news_theme_options',
		'title' => esc_html__( 'Pagination', 'flash-news' ),
	)
);

// Pagination - Enable Pagination.
$wp_customize->add_setting(
	'flash_news_enable_pagination',
	array(
		'default'           => true,
		'sanitize_callback' => 'flash_news_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Flash_News_Toggle_Switch_Custom_Control(
		$wp_customize,
		'flash_news_enable_pagination',
		array(
			'label'    => esc_html__( 'Enable Pagination', 'flash-news' ),
			'section'  => 'flash_news_pagination',
			'settings' => 'flash_news_enable_pagination',
			'type'     => 'checkbox',
		)
	)
);

$wp_customize->add_setting(
	'flash_news_pagination_type',
	array(
		'default'           => 'default',
		'sanitize_callback' => 'flash_news_sanitize_select',
	)
);

$wp_customize->add_control(
	'flash_news_pagination_type',
	array(
		'label'           => esc_html__( 'Pagination Type', 'flash-news' ),
		'section'         => 'flash_news_pagination',
		'settings'        => 'flash_news_pagination_type',
		'active_callback' => 'flash_news_is_pagination_enabled',
		'type'            => 'select',
		'choices'         => array(
			'default' => __( 'Default (Older/Newer)', 'flash-news' ),
			'numeric' => __( 'Numeric', 'flash-news' ),
		),
	)
);
