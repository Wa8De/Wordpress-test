<?php
/**
 * Theme Options
 *
 * @package Flash_News
 */

$wp_customize->add_panel(
	'flash_news_theme_options',
	array(
		'title'    => esc_html__( 'Theme Options', 'flash-news' ),
		'priority' => 130,
	)
);

// Header Options.
require get_template_directory() . '/inc/customizer/theme-options/header-options.php';

// Frontpage Sidebar Position.
require get_template_directory() . '/inc/customizer/theme-options/frontpage-sidebar-position.php';

// Typography.
require get_template_directory() . '/inc/customizer/theme-options/typography.php';

// Excerpt.
require get_template_directory() . '/inc/customizer/theme-options/excerpt.php';

// Breadcrumb.
require get_template_directory() . '/inc/customizer/theme-options/breadcrumb.php';

// Archive Layout.
require get_template_directory() . '/inc/customizer/theme-options/archive-layout.php';

// Sidebar Position.
require get_template_directory() . '/inc/customizer/theme-options/sidebar-position.php';

// Post Options.
require get_template_directory() . '/inc/customizer/theme-options/post-options.php';

// Pagination.
require get_template_directory() . '/inc/customizer/theme-options/pagination.php';

// Footer Options.
require get_template_directory() . '/inc/customizer/theme-options/footer-options.php';
