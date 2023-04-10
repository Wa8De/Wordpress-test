<?php
/**
 * Posts List Section
 *
 * @package Flash_News
 */

$wp_customize->add_section(
	'flash_news_posts_list_section',
	array(
		'panel' => 'flash_news_front_page_options',
		'title' => esc_html__( 'Posts List Section', 'flash-news' ),
	)
);

// Posts List Section - Enable Section.
$wp_customize->add_setting(
	'flash_news_enable_posts_list_section',
	array(
		'default'           => false,
		'sanitize_callback' => 'flash_news_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Flash_News_Toggle_Switch_Custom_Control(
		$wp_customize,
		'flash_news_enable_posts_list_section',
		array(
			'label'    => esc_html__( 'Enable Posts List Section', 'flash-news' ),
			'section'  => 'flash_news_posts_list_section',
			'settings' => 'flash_news_enable_posts_list_section',
		)
	)
);

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial(
		'flash_news_enable_posts_list_section',
		array(
			'selector' => '#flash_news_posts_list_section .section-link',
			'settings' => 'flash_news_enable_posts_list_section',
		)
	);
}

// Posts List Section - Section Title.
$wp_customize->add_setting(
	'flash_news_posts_list_title',
	array(
		'default'           => __( 'Posts List', 'flash-news' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'flash_news_posts_list_title',
	array(
		'label'           => esc_html__( 'Section Title', 'flash-news' ),
		'section'         => 'flash_news_posts_list_section',
		'settings'        => 'flash_news_posts_list_title',
		'type'            => 'text',
		'active_callback' => 'flash_news_is_posts_list_section_enabled',
	)
);

// Posts List Section - Content Type.
$wp_customize->add_setting(
	'flash_news_posts_list_content_type',
	array(
		'default'           => 'category',
		'sanitize_callback' => 'flash_news_sanitize_select',
	)
);

$wp_customize->add_control(
	'flash_news_posts_list_content_type',
	array(
		'label'           => esc_html__( 'Select Content Type', 'flash-news' ),
		'section'         => 'flash_news_posts_list_section',
		'settings'        => 'flash_news_posts_list_content_type',
		'type'            => 'select',
		'active_callback' => 'flash_news_is_posts_list_section_enabled',
		'choices'         => array(
			'post'     => esc_html__( 'Post', 'flash-news' ),
			'category' => esc_html__( 'Category', 'flash-news' ),
		),
	)
);

for ( $i = 1; $i <= 6; $i++ ) {
	// Posts List Section - Select Post.
	$wp_customize->add_setting(
		'flash_news_posts_list_content_post_' . $i,
		array(
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'flash_news_posts_list_content_post_' . $i,
		array(
			'label'           => sprintf( esc_html__( 'Select Post %d', 'flash-news' ), $i ),
			'section'         => 'flash_news_posts_list_section',
			'settings'        => 'flash_news_posts_list_content_post_' . $i,
			'active_callback' => 'flash_news_is_posts_list_section_and_content_type_post_enabled',
			'type'            => 'select',
			'choices'         => flash_news_get_post_choices(),
		)
	);

}

// Posts List Section - Select Category.
$wp_customize->add_setting(
	'flash_news_posts_list_content_category',
	array(
		'sanitize_callback' => 'flash_news_sanitize_select',
	)
);

$wp_customize->add_control(
	'flash_news_posts_list_content_category',
	array(
		'label'           => esc_html__( 'Select Category', 'flash-news' ),
		'section'         => 'flash_news_posts_list_section',
		'settings'        => 'flash_news_posts_list_content_category',
		'active_callback' => 'flash_news_is_posts_list_section_and_content_type_category_enabled',
		'type'            => 'select',
		'choices'         => flash_news_get_post_cat_choices(),
	)
);

// Posts List Section - Button Label.
$wp_customize->add_setting(
	'flash_news_posts_list_button_label',
	array(
		'default'           => __( 'View All', 'flash-news' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'flash_news_posts_list_button_label',
	array(
		'label'           => esc_html__( 'Button Label', 'flash-news' ),
		'section'         => 'flash_news_posts_list_section',
		'settings'        => 'flash_news_posts_list_button_label',
		'type'            => 'text',
		'active_callback' => 'flash_news_is_posts_list_section_enabled',
	)
);

// Posts Grid Section - Button Link.
$wp_customize->add_setting(
	'flash_news_posts_list_button_link',
	array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	)
);

$wp_customize->add_control(
	'flash_news_posts_list_button_link',
	array(
		'label'           => esc_html__( 'Button Link', 'flash-news' ),
		'section'         => 'flash_news_posts_list_section',
		'settings'        => 'flash_news_posts_list_button_link',
		'type'            => 'url',
		'active_callback' => 'flash_news_is_posts_list_section_enabled',
	)
);
