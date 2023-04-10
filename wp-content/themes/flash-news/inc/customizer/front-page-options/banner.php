<?php
/**
 * Banner Section
 *
 * @package Flash_News
 */

$wp_customize->add_section(
	'flash_news_banner_section',
	array(
		'panel' => 'flash_news_front_page_options',
		'title' => esc_html__( 'Banner Section', 'flash-news' ),
	)
);

// Banner Section - Enable Section.
$wp_customize->add_setting(
	'flash_news_enable_banner_section',
	array(
		'default'           => false,
		'sanitize_callback' => 'flash_news_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Flash_News_Toggle_Switch_Custom_Control(
		$wp_customize,
		'flash_news_enable_banner_section',
		array(
			'label'    => esc_html__( 'Enable Banner Section', 'flash-news' ),
			'section'  => 'flash_news_banner_section',
			'settings' => 'flash_news_enable_banner_section',
		)
	)
);

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial(
		'flash_news_enable_banner_section',
		array(
			'selector' => '#flash_news_banner_section .section-link',
			'settings' => 'flash_news_enable_banner_section',
		)
	);
}

// Banner Section - Banner Slider Content Type.
$wp_customize->add_setting(
	'flash_news_banner_slider_content_type',
	array(
		'default'           => 'category',
		'sanitize_callback' => 'flash_news_sanitize_select',
	)
);

$wp_customize->add_control(
	'flash_news_banner_slider_content_type',
	array(
		'label'           => esc_html__( 'Select Banner Slider Content Type', 'flash-news' ),
		'section'         => 'flash_news_banner_section',
		'settings'        => 'flash_news_banner_slider_content_type',
		'type'            => 'select',
		'active_callback' => 'flash_news_is_banner_slider_section_enabled',
		'choices'         => array(
			'post'     => esc_html__( 'Post', 'flash-news' ),
			'category' => esc_html__( 'Category', 'flash-news' ),
		),
	)
);

for ( $i = 1; $i <= 3; $i++ ) {
	// Banner Section - Select Post.
	$wp_customize->add_setting(
		'flash_news_banner_slider_content_post_' . $i,
		array(
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'flash_news_banner_slider_content_post_' . $i,
		array(
			'label'           => sprintf( esc_html__( 'Select Post %d', 'flash-news' ), $i ),
			'section'         => 'flash_news_banner_section',
			'settings'        => 'flash_news_banner_slider_content_post_' . $i,
			'active_callback' => 'flash_news_is_banner_slider_section_and_content_type_post_enabled',
			'type'            => 'select',
			'choices'         => flash_news_get_post_choices(),
		)
	);

}

// Banner Section - Select Category.
$wp_customize->add_setting(
	'flash_news_banner_slider_content_category',
	array(
		'sanitize_callback' => 'flash_news_sanitize_select',
	)
);

$wp_customize->add_control(
	'flash_news_banner_slider_content_category',
	array(
		'label'           => esc_html__( 'Select Category', 'flash-news' ),
		'section'         => 'flash_news_banner_section',
		'settings'        => 'flash_news_banner_slider_content_category',
		'active_callback' => 'flash_news_is_banner_slider_section_and_content_type_category_enabled',
		'type'            => 'select',
		'choices'         => flash_news_get_post_cat_choices(),
	)
);

// Banner Section - Horizontal Line.
$wp_customize->add_setting(
	'flash_news_banner_horizontal_line',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Flash_News_Customize_Horizontal_Line(
		$wp_customize,
		'flash_news_banner_horizontal_line',
		array(
			'section'         => 'flash_news_banner_section',
			'settings'        => 'flash_news_banner_horizontal_line',
			'active_callback' => 'flash_news_is_banner_slider_section_enabled',
			'type'            => 'hr',
		)
	)
);

// Banner Section - Banner Grid Posts Content Type.
$wp_customize->add_setting(
	'flash_news_banner_grid_content_type',
	array(
		'default'           => 'category',
		'sanitize_callback' => 'flash_news_sanitize_select',
	)
);

$wp_customize->add_control(
	'flash_news_banner_grid_content_type',
	array(
		'label'           => esc_html__( 'Select Banner Grid Posts Content Type', 'flash-news' ),
		'section'         => 'flash_news_banner_section',
		'settings'        => 'flash_news_banner_grid_content_type',
		'type'            => 'select',
		'active_callback' => 'flash_news_is_banner_slider_section_enabled',
		'choices'         => array(
			'post'     => esc_html__( 'Post', 'flash-news' ),
			'category' => esc_html__( 'Category', 'flash-news' ),
		),
	)
);

for ( $i = 1; $i <= 3; $i++ ) {
	// Banner Section - Banner Grid Select Post.
	$wp_customize->add_setting(
		'flash_news_banner_grid_post_content_post_' . $i,
		array(
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'flash_news_banner_grid_post_content_post_' . $i,
		array(
			'label'           => sprintf( esc_html__( 'Select Post %d', 'flash-news' ), $i ),
			'section'         => 'flash_news_banner_section',
			'settings'        => 'flash_news_banner_grid_post_content_post_' . $i,
			'active_callback' => 'flash_news_is_banner_grid_section_and_content_type_post_enabled',
			'type'            => 'select',
			'choices'         => flash_news_get_post_choices(),
		)
	);

}

// Banner Section - Banner Grid Select Category.
$wp_customize->add_setting(
	'flash_news_banner_grid_post_content_category',
	array(
		'sanitize_callback' => 'flash_news_sanitize_select',
	)
);

$wp_customize->add_control(
	'flash_news_banner_grid_post_content_category',
	array(
		'label'           => esc_html__( 'Select Category', 'flash-news' ),
		'section'         => 'flash_news_banner_section',
		'settings'        => 'flash_news_banner_grid_post_content_category',
		'active_callback' => 'flash_news_is_banner_grid_section_and_content_type_category_enabled',
		'type'            => 'select',
		'choices'         => flash_news_get_post_cat_choices(),
	)
);
