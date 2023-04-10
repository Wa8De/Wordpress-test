<?php
/**
 * Breaking News Section
 *
 * @package Flash_News
 */

$wp_customize->add_section(
	'flash_news_breaking_news_section',
	array(
		'panel' => 'flash_news_front_page_options',
		'title' => esc_html__( 'Breaking News Section', 'flash-news' ),
	)
);

// Breaking News Section - Enable Section.
$wp_customize->add_setting(
	'flash_news_enable_breaking_news_section',
	array(
		'default'           => false,
		'sanitize_callback' => 'flash_news_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Flash_News_Toggle_Switch_Custom_Control(
		$wp_customize,
		'flash_news_enable_breaking_news_section',
		array(
			'label'    => esc_html__( 'Enable Breaking News Section', 'flash-news' ),
			'section'  => 'flash_news_breaking_news_section',
			'settings' => 'flash_news_enable_breaking_news_section',
		)
	)
);

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial(
		'flash_news_enable_breaking_news_section',
		array(
			'selector' => '#flash_news_breaking_news_section .section-link',
			'settings' => 'flash_news_enable_breaking_news_section',
		)
	);
}

// Breaking News Section - Content Type.
$wp_customize->add_setting(
	'flash_news_breaking_news_content_type',
	array(
		'default'           => 'category',
		'sanitize_callback' => 'flash_news_sanitize_select',
	)
);

$wp_customize->add_control(
	'flash_news_breaking_news_content_type',
	array(
		'label'           => esc_html__( 'Select Content Type', 'flash-news' ),
		'section'         => 'flash_news_breaking_news_section',
		'settings'        => 'flash_news_breaking_news_content_type',
		'type'            => 'select',
		'active_callback' => 'flash_news_is_breaking_news_section_enabled',
		'choices'         => array(
			'post'     => esc_html__( 'Post', 'flash-news' ),
			'category' => esc_html__( 'Category', 'flash-news' ),
		),
	)
);

for ( $i = 1; $i <= 5; $i++ ) {
	// Breaking News Section - Select Post.
	$wp_customize->add_setting(
		'flash_news_breaking_news_content_post_' . $i,
		array(
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'flash_news_breaking_news_content_post_' . $i,
		array(
			'label'           => sprintf( esc_html__( 'Select Post %d', 'flash-news' ), $i ),
			'section'         => 'flash_news_breaking_news_section',
			'settings'        => 'flash_news_breaking_news_content_post_' . $i,
			'active_callback' => 'flash_news_is_breaking_news_section_and_content_type_post_enabled',
			'type'            => 'select',
			'choices'         => flash_news_get_post_choices(),
		)
	);

}

// Breaking News Section - Select Category.
$wp_customize->add_setting(
	'flash_news_breaking_news_content_category',
	array(
		'sanitize_callback' => 'flash_news_sanitize_select',
	)
);

$wp_customize->add_control(
	'flash_news_breaking_news_content_category',
	array(
		'label'           => esc_html__( 'Select Category', 'flash-news' ),
		'section'         => 'flash_news_breaking_news_section',
		'settings'        => 'flash_news_breaking_news_content_category',
		'active_callback' => 'flash_news_is_breaking_news_section_and_content_type_category_enabled',
		'type'            => 'select',
		'choices'         => flash_news_get_post_cat_choices(),
	)
);
