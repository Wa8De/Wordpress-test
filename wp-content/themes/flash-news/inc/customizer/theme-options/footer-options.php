<?php
/**
 * Footer Options
 *
 * @package Flash_News
 */

$wp_customize->add_section(
	'flash_news_footer_options',
	array(
		'panel' => 'flash_news_theme_options',
		'title' => esc_html__( 'Footer Options', 'flash-news' ),
	)
);

// Footer Options - Copyright Text.
/* translators: 1: Year, 2: Site Title with home URL. */
$copyright_default = sprintf( esc_html_x( 'Copyright &copy; %1$s %2$s', '1: Year, 2: Site Title with home URL', 'flash-news' ), '[the-year]', '[site-link]' );
$wp_customize->add_setting(
	'flash_news_footer_copyright_text',
	array(
		'default'           => $copyright_default,
		'sanitize_callback' => 'wp_kses_post',
	)
);

$wp_customize->add_control(
	'flash_news_footer_copyright_text',
	array(
		'label'    => esc_html__( 'Copyright Text', 'flash-news' ),
		'section'  => 'flash_news_footer_options',
		'settings' => 'flash_news_footer_copyright_text',
		'type'     => 'textarea',
	)
);

// Footer Options - Scroll Top.
$wp_customize->add_setting(
	'flash_news_scroll_top',
	array(
		'sanitize_callback' => 'flash_news_sanitize_switch',
		'default'           => true,
	)
);

$wp_customize->add_control(
	new Flash_News_Toggle_Switch_Custom_Control(
		$wp_customize,
		'flash_news_scroll_top',
		array(
			'label'   => esc_html__( 'Enable Scroll Top Button', 'flash-news' ),
			'section' => 'flash_news_footer_options',
		)
	)
);
