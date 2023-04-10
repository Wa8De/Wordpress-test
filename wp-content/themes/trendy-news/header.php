<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Trendy News
 */
use TrendyNews\CustomizerDefault as TND;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php trendy_news_schema_body_attributes(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'trendy-news' ); ?></a>
	<?php
		/**
		 * hook - trendy_news_page_prepend_hook
		 * 
		 * @package Trendy News
		 * @since 1.0.0
		 */
		do_action( "trendy_news_page_prepend_hook" );
	?>
	
	<header id="masthead" class="site-header layout--default layout--one">
		<?php
			/**
			 * Function - trendy_news_top_header_html
			 * 
			 * @since 1.0.0
			 * 
			 */
			trendy_news_top_header_html();

			/**
			 * Function - trendy_news_header_html
			 * 
			 * @since 1.0.0
			 * 
			 */
			trendy_news_header_html();
		?>
	</header><!-- #masthead -->

	<?php
	/**
	 * function - trendy_news_after_header_html
	 * 
	 * @since 1.0.0
	 */
	trendy_news_after_header_html();