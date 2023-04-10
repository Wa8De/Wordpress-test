<?php

/**
 * Active Callbacks
 *
 * @package Flash_News
 */

// Theme Options.
function flash_news_is_pagination_enabled( $control ) {
	return ( $control->manager->get_setting( 'flash_news_enable_pagination' )->value() );
}
function flash_news_is_breadcrumb_enabled( $control ) {
	return ( $control->manager->get_setting( 'flash_news_enable_breadcrumb' )->value() );
}

// Header Options.
function flash_news_is_topbar_enabled( $control ) {
	return ( $control->manager->get_Setting( 'flash_news_enable_topbar' )->value() );
}

// Breaking News Section.
function flash_news_is_breaking_news_section_enabled( $control ) {
	return ( $control->manager->get_setting( 'flash_news_enable_breaking_news_section' )->value() );
}
function flash_news_is_breaking_news_section_and_content_type_post_enabled( $control ) {
	$content_type = $control->manager->get_setting( 'flash_news_breaking_news_content_type' )->value();
	return ( flash_news_is_breaking_news_section_enabled( $control ) && ( 'post' === $content_type ) );
}
function flash_news_is_breaking_news_section_and_content_type_category_enabled( $control ) {
	$content_type = $control->manager->get_setting( 'flash_news_breaking_news_content_type' )->value();
	return ( flash_news_is_breaking_news_section_enabled( $control ) && ( 'category' === $content_type ) );
}

// Banner Slider Section.
function flash_news_is_banner_slider_section_enabled( $control ) {
	return ( $control->manager->get_setting( 'flash_news_enable_banner_section' )->value() );
}
function flash_news_is_banner_slider_section_and_content_type_post_enabled( $control ) {
	$content_type = $control->manager->get_setting( 'flash_news_banner_slider_content_type' )->value();
	return ( flash_news_is_banner_slider_section_enabled( $control ) && ( 'post' === $content_type ) );
}
function flash_news_is_banner_slider_section_and_content_type_category_enabled( $control ) {
	$content_type = $control->manager->get_setting( 'flash_news_banner_slider_content_type' )->value();
	return ( flash_news_is_banner_slider_section_enabled( $control ) && ( 'category' === $content_type ) );
}
function flash_news_is_banner_grid_section_and_content_type_post_enabled( $control ) {
	$content_type = $control->manager->get_setting( 'flash_news_banner_grid_content_type' )->value();
	return ( flash_news_is_banner_slider_section_enabled( $control ) && ( 'post' === $content_type ) );
}
function flash_news_is_banner_grid_section_and_content_type_category_enabled( $control ) {
	$content_type = $control->manager->get_setting( 'flash_news_banner_grid_content_type' )->value();
	return ( flash_news_is_banner_slider_section_enabled( $control ) && ( 'category' === $content_type ) );
}

// Posts List Section.
function flash_news_is_posts_list_section_enabled( $control ) {
	return ( $control->manager->get_setting( 'flash_news_enable_posts_list_section' )->value() );
}
function flash_news_is_posts_list_section_and_content_type_post_enabled( $control ) {
	$content_type = $control->manager->get_setting( 'flash_news_posts_list_content_type' )->value();
	return ( flash_news_is_posts_list_section_enabled( $control ) && ( 'post' === $content_type ) );
}
function flash_news_is_posts_list_section_and_content_type_category_enabled( $control ) {
	$content_type = $control->manager->get_setting( 'flash_news_posts_list_content_type' )->value();
	return ( flash_news_is_posts_list_section_enabled( $control ) && ( 'category' === $content_type ) );
}
