<?php
if ( ! get_theme_mod( 'flash_news_enable_banner_section', false ) ) {
	return;
}

$content_ids         = $grid_content_ids = array();
$slider_content_type = get_theme_mod( 'flash_news_banner_slider_content_type', 'category' );
$gird_content_type   = get_theme_mod( 'flash_news_banner_grid_content_type', 'category' );

if ( $slider_content_type === 'post' ) {
	for ( $i = 1; $i <= 3; $i++ ) {
		$content_ids[] = get_theme_mod( 'flash_news_banner_slider_content_' . $slider_content_type . '_' . $i );
	}
	$banner_slider_args = array(
		'post_type'           => $slider_content_type,
		'post__in'            => array_filter( $content_ids ),
		'orderby'             => 'post__in',
		'posts_per_page'      => absint( 3 ),
		'ignore_sticky_posts' => true,
	);
} else {
	$cat_content_id     = get_theme_mod( 'flash_news_banner_slider_content_category' );
	$banner_slider_args = array(
		'cat'            => $cat_content_id,
		'posts_per_page' => absint( 3 ),
	);
}
$banner_slider_args = apply_filters( 'flash_news_banner_section_args', $banner_slider_args );

if ( $gird_content_type === 'post' ) {
	for ( $i = 1; $i <= 3; $i++ ) {
		$grid_content_ids[] = get_theme_mod( 'flash_news_banner_grid_post_content_' . $gird_content_type . '_' . $i );
	}
	$banner_grid_args = array(
		'post_type'           => $gird_content_type,
		'post__in'            => array_filter( $grid_content_ids ),
		'orderby'             => 'post__in',
		'posts_per_page'      => absint( 3 ),
		'ignore_sticky_posts' => true,
	);
} else {
	$cat_content_id   = get_theme_mod( 'flash_news_banner_grid_post_content_category' );
	$banner_grid_args = array(
		'cat'            => $cat_content_id,
		'posts_per_page' => absint( 3 ),
	);
}
$banner_grid_args = apply_filters( 'flash_news_banner_section_args', $banner_grid_args );

flash_news_render_banner_section( $banner_slider_args, $banner_grid_args );

/**
 * Render Banner Section.
 */
function flash_news_render_banner_section( $banner_slider_args, $banner_grid_args ) {
	?>
	<section id="flash_news_banner_section" class="banner-section has-normal-gap banner-style-3">
		<?php
		if ( is_customize_preview() ) :
			flash_news_section_link( 'flash_news_banner_section' );
		endif;
		?>
		<div class="ascendoor-wrapper">
			<div class="banner-section-wrapper">
				<?php
				$query = new WP_Query( $banner_slider_args );
				if ( $query->have_posts() ) :
					?>
					<div class="slider-part">
						<div class="magazine-slider-wrapper banner-slider magazine-carousel-slider-navigation">
							<?php
							while ( $query->have_posts() ) :
								$query->the_post();
								?>
								<div class="mag-post-single has-image tile-design">
									<div class="mag-post-img">
										<a href="<?php the_permalink(); ?>">
											<?php the_post_thumbnail( 'full' ); ?>
										</a>
									</div>
									<div class="mag-post-detail">
										<div class="mag-post-category with-background">
											<?php flash_news_categories_list( true ); ?>
										</div>
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
								<?php
							endwhile;
							wp_reset_postdata();
							?>
						</div>
					</div>
					<?php
				endif;

				$grid_query = new WP_Query( $banner_grid_args );
				if ( $grid_query->have_posts() ) :
					while ( $grid_query->have_posts() ) :
						$grid_query->the_post();
						?>
						<div class="mag-post-single banner-gird-single has-image tile-design">
							<div class="mag-post-img">
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail(); ?>
								</a>
							</div>
							<div class="mag-post-detail">
								<div class="mag-post-category with-background">
									<?php flash_news_categories_list( true ); ?>
								</div>
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
						<?php
					endwhile;
					wp_reset_postdata();
				endif;
				?>
			</div>
		</div>
	</section>
	<?php
}
