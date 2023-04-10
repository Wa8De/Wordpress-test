<?php
/**
 * Archive Layout
 *
 * @package Flash_News
 */

$wp_customize->add_section(
	'flash_news_archive_layout',
	array(
		'title' => esc_html__( 'Archive Layout', 'flash-news' ),
		'panel' => 'flash_news_theme_options',
	)
);

// Archive Layout - Grid Style.
$wp_customize->add_setting(
	'flash_news_archive_column_layout',
	array(
		'default'           => 'grid-column-3',
		'sanitize_callback' => 'flash_news_sanitize_select',
	)
);

$wp_customize->add_control(
	'flash_news_archive_column_layout',
	array(
		'label'   => esc_html__( 'Grid Column Layout', 'flash-news' ),
		'section' => 'flash_news_archive_layout',
		'type'    => 'select',
		'choices' => array(
			'grid-column-2' => __( 'Column 2', 'flash-news' ),
			'grid-column-3' => __( 'Column 3', 'flash-news' ),
		),
	)
);
