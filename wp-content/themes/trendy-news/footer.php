<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Trendy News
 */

 /**
  * hook - trendy_news_before_footer_section
  * 
  */
  do_action( 'trendy_news_before_footer_section' );
?>
	<footer id="colophon" class="site-footer dark_bk">
		<?php
			/**
			 * Function - trendy_news_footer_sections_html
			 * 
			 * @since 1.0.0
			 * 
			 */
			trendy_news_footer_sections_html();

			/**
			 * Function - trendy_news_bottom_footer_sections_html
			 * 
			 * @since 1.0.0
			 * 
			 */
			trendy_news_bottom_footer_sections_html();
		?>
	</footer><!-- #colophon -->
	<?php
		/**
		* hook - trendy_news_after_footer_hook
		*
		* @hooked - trendy_news_scroll_to_top
		*
		*/
		if( has_action( 'trendy_news_after_footer_hook' ) ) {
			do_action( 'trendy_news_after_footer_hook' );
		}
	?>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>