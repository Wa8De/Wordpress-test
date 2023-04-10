<?php
if ( ! get_theme_mod( 'flash_news_enable_breaking_news_section', false ) ) {
	return;
}

$content_ids  = array();
$content_type = get_theme_mod( 'flash_news_breaking_news_content_type', 'category' );

if ( $content_type === 'post' ) {

	for ( $i = 1; $i <= 5; $i++ ) {
		$content_ids[] = get_theme_mod( 'flash_news_breaking_news_content_' . $content_type . '_' . $i );
	}

	$args = array(
		'post_type'           => $content_type,
		'post__in'            => array_filter( $content_ids ),
		'orderby'             => 'post__in',
		'posts_per_page'      => absint( 5 ),
		'ignore_sticky_posts' => true,
	);

} else {
	$cat_content_id = get_theme_mod( 'flash_news_breaking_news_content_category' );
	$args           = array(
		'cat'            => $cat_content_id,
		'posts_per_page' => absint( 5 ),
	);
}

$args = apply_filters( 'flash_news_breaking_news_section_args', $args );

flash_news_render_breaking_news_section( $args );

/**
 * Render Flash News Section.
 */
function flash_news_render_breaking_news_section( $args ) {

	$query = new WP_Query( $args );
	if ( $query->have_posts() ) :
		?>
		<section id="flash_news_breaking_news_section" class="magazine-frontpage-section flash-news section-has-background grey-background">
			<?php
			if ( is_customize_preview() ) :
				flash_news_section_link( 'flash_news_breaking_news_section' );
			endif;
			?>
			<div class="ascendoor-wrapper">
				<div class="flash-news-wrapper" data-slick='{"autoplay": true }'>
					<?php
					$i = 1;
					while ( $query->have_posts() ) :
						$query->the_post();
						?>
						<div class="flash-news-outer">
							<div class="mag-post-single has-image list-design">
								<div class="mag-post-img">
									<a href="<?php the_permalink(); ?>">
										<?php the_post_thumbnail(); ?>
									</a>
									<span class="flash-no"><?php echo absint( $i ); ?></span>
								</div>
								<div class="mag-post-detail">
									<h3 class="mag-post-title">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h3>
									<div class="mag-post-meta">
										<span class="post-author">
											<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><i class="fas fa-user"></i><?php echo esc_html( get_the_author() ); ?></a>
										</span>
										<span class="post-date">
											<a href="<?php the_permalink(); ?>"><i class="far fa-clock"></i><?php echo esc_html( get_the_date() ); ?></a>
										</span>
									</div>
								</div>
							</div>
						</div>
						<?php
						$i++;
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</div>
		</section>
		<?php
	endif;
}
