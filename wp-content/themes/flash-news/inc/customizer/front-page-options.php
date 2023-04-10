<?php
/**
 * Front Page Options
 *
 * @package Flash News
 */

$wp_customize->add_panel(
	'flash_news_front_page_options',
	array(
		'title'    => esc_html__( 'Front Page Options', 'flash-news' ),
		'priority' => 130,
	)
);

// Breaking News Section.
require get_template_directory() . '/inc/customizer/front-page-options/breaking-news.php';

// Banner Section.
require get_template_directory() . '/inc/customizer/front-page-options/banner.php';

// Posts List Section.
require get_template_directory() . '/inc/customizer/front-page-options/posts-list.php';
