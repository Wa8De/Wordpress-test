<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Trendy News
 */

use TrendyNews\CustomizerDefault as TND;
/**
 * Set up the WordPress core custom header feature.
 *
 * @uses trendy_news_header_style()
 */
function trendy_news_custom_header_setup() {
	add_theme_support(
		'custom-header',
		apply_filters(
			'trendy_news_custom_header_args',
			array(
				'default-image'      => '',
				'default-text-color' => '289dcc',
				'width'              => 1000,
				'height'             => 250,
				'flex-height'        => true,
				'wp-head-callback'   => 'trendy_news_header_style',
			)
		)
	);
}
add_action( 'after_setup_theme', 'trendy_news_custom_header_setup' );

if ( ! function_exists( 'trendy_news_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see trendy_news_custom_header_setup().
	 */
	function trendy_news_header_style() {
		$header_site_title_color = get_header_textcolor();
		$header_hover_textcolor = TND\trendy_news_get_customizer_option( 'site_title_hover_textcolor' );
		$site_description_color = TND\trendy_news_get_customizer_option( 'site_description_color' );

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
			<?php
			// Has the text been hidden?
			if ( ! display_header_text() ) :
				?>
				.site-title {
					position: absolute;
					clip: rect(1px, 1px, 1px, 1px);
					}
				<?php
				// If the user has set a custom color for the text use that.
			else :
				?>
				header .site-title a, header .site-title a:after  {
					color: #<?php echo esc_attr( $header_site_title_color ); ?>;
				}
				header .site-title a:hover {
					color: <?php echo esc_attr( $header_hover_textcolor ); ?>;
				}
			<?php endif;
				if( ! get_theme_mod( 'blogdescription_option', true ) ) :
			?>
					.site-description {
						position: absolute;
						clip: rect(1px, 1px, 1px, 1px);
					}
				<?php
				else :
				?>
					.site-description {
						color: <?php echo esc_attr( $site_description_color ); ?>;
					}
				<?php
				endif;
			 ?>
		</style>
		<?php
	}
endif;
