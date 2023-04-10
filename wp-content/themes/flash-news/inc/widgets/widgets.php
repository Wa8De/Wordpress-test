<?php

// Posts Grid Widgets.
require get_template_directory() . '/inc/widgets/posts-grid-widget.php';

// Posts List Widgets.
require get_template_directory() . '/inc/widgets/posts-list-widget.php';

// Posts Tile Widgets.
require get_template_directory() . '/inc/widgets/posts-tile-widget.php';

// Post Carousel Widgets.
require get_template_directory() . '/inc/widgets/posts-carousel-widget.php';

// Trending Posts Carousel Widgets.
require get_template_directory() . '/inc/widgets/trending-posts-carousel-widget.php';

// Posts Tabs Widgets.
require get_template_directory() . '/inc/widgets/posts-tabs-widget.php';

// Posts Small List Widgets.
require get_template_directory() . '/inc/widgets/posts-small-list-widget.php';

// Social Icons Widget.
require get_template_directory() . '/inc/widgets/social-icons-widget.php';

/**
 * Register Widgets
 */
function flash_news_register_widgets() {

	register_widget( 'Flash_News_Posts_Grid_Widget' );

	register_widget( 'Flash_News_Posts_List_Widget' );

	register_widget( 'Flash_News_Posts_Tile_Widget' );

	register_widget( 'Flash_News_Posts_Carousel_Widget' );

	register_widget( 'Flash_News_Trending_Posts_Carousel_Widget' );

	register_widget( 'Flash_News_Posts_Tabs_Widget' );

	register_widget( 'Flash_News_Posts_Small_List_Widget' );

	register_widget( 'Flash_News_Social_Icons_Widget' );

}
add_action( 'widgets_init', 'flash_news_register_widgets' );
