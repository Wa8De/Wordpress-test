<?php
/**
 * Excerpt
 *
 * @package Flash_News
 */

$wp_customize->add_section(
	'flash_news_excerpt_options',
	array(
		'panel' => 'flash_news_theme_options',
		'title' => esc_html__( 'Excerpt', 'flash-news' ),
	)
);

// Excerpt - Excerpt Length.
$wp_customize->add_setting(
	'flash_news_excerpt_length',
	array(
		'default'           => 20,
		'sanitize_callback' => 'flash_news_sanitize_number_range',
		'validate_callback' => 'flash_news_validate_excerpt_length',
	)
);

$wp_customize->add_control(
	'flash_news_excerpt_length',
	array(
		'label'       => esc_html__( 'Excerpt Length (no. of words)', 'flash-news' ),
		'description' => esc_html__( 'Note: Min 1 & Max 100. Please input the valid number and save. Then refresh the page to see the change.', 'flash-news' ),
		'section'     => 'flash_news_excerpt_options',
		'settings'    => 'flash_news_excerpt_length',
		'type'        => 'number',
		'input_attrs' => array(
			'min'  => 1,
			'max'  => 100,
			'step' => 1,
		),
	)
);
