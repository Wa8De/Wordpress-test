<?php
/**
 * Post Options
 *
 * @package Flash_News
 */

$wp_customize->add_section(
	'flash_news_post_options',
	array(
		'title' => esc_html__( 'Post Options', 'flash-news' ),
		'panel' => 'flash_news_theme_options',
	)
);

// Post Options - Hide Date.
$wp_customize->add_setting(
	'flash_news_post_hide_date',
	array(
		'default'           => false,
		'sanitize_callback' => 'flash_news_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Flash_News_Toggle_Switch_Custom_Control(
		$wp_customize,
		'flash_news_post_hide_date',
		array(
			'label'   => esc_html__( 'Hide Date', 'flash-news' ),
			'section' => 'flash_news_post_options',
		)
	)
);

// Post Options - Hide Author.
$wp_customize->add_setting(
	'flash_news_post_hide_author',
	array(
		'default'           => false,
		'sanitize_callback' => 'flash_news_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Flash_News_Toggle_Switch_Custom_Control(
		$wp_customize,
		'flash_news_post_hide_author',
		array(
			'label'   => esc_html__( 'Hide Author', 'flash-news' ),
			'section' => 'flash_news_post_options',
		)
	)
);

// Post Options - Hide Category.
$wp_customize->add_setting(
	'flash_news_post_hide_category',
	array(
		'default'           => false,
		'sanitize_callback' => 'flash_news_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Flash_News_Toggle_Switch_Custom_Control(
		$wp_customize,
		'flash_news_post_hide_category',
		array(
			'label'   => esc_html__( 'Hide Category', 'flash-news' ),
			'section' => 'flash_news_post_options',
		)
	)
);

// Post Options - Hide Tag.
$wp_customize->add_setting(
	'flash_news_post_hide_tags',
	array(
		'default'           => false,
		'sanitize_callback' => 'flash_news_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Flash_News_Toggle_Switch_Custom_Control(
		$wp_customize,
		'flash_news_post_hide_tags',
		array(
			'label'   => esc_html__( 'Hide Tag', 'flash-news' ),
			'section' => 'flash_news_post_options',
		)
	)
);

// Post Options - Related Post Label.
$wp_customize->add_setting(
	'flash_news_post_related_post_label',
	array(
		'default'           => __( 'Related Posts', 'flash-news' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'flash_news_post_related_post_label',
	array(
		'label'    => esc_html__( 'Related Posts Label', 'flash-news' ),
		'section'  => 'flash_news_post_options',
		'settings' => 'flash_news_post_related_post_label',
		'type'     => 'text',
	)
);

// Post Options - Hide Related Posts.
$wp_customize->add_setting(
	'flash_news_post_hide_related_posts',
	array(
		'default'           => false,
		'sanitize_callback' => 'flash_news_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Flash_News_Toggle_Switch_Custom_Control(
		$wp_customize,
		'flash_news_post_hide_related_posts',
		array(
			'label'   => esc_html__( 'Hide Related Posts', 'flash-news' ),
			'section' => 'flash_news_post_options',
		)
	)
);
