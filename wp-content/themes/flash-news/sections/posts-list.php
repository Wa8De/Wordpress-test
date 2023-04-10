<?php
if ( ! get_theme_mod( 'flash_news_enable_posts_list_section', false ) ) {
	return;
}

$content_ids   = array();
$content_count = get_theme_mod( 'flash_news_posts_list_count', 6 );
$content_type  = get_theme_mod( 'flash_news_posts_list_content_type', 'category' );

if ( in_array( $content_type, array( 'post', 'page' ) ) ) {

	for ( $i = 1; $i <= $content_count; $i++ ) {
		$content_ids[] = get_theme_mod( 'flash_news_posts_list_content_' . $content_type . '_' . $i );
	}

	$args = array(
		'post_type'           => $content_type,
		'post__in'            => array_filter( $content_ids ),
		'orderby'             => 'post__in',
		'posts_per_page'      => absint( $content_count ),
		'ignore_sticky_posts' => true,
	);

} elseif ( $content_type === 'category' ) {
	$cat_content_id = get_theme_mod( 'flash_news_posts_list_content_category' );
	$args           = array(
		'cat'            => $cat_content_id,
		'posts_per_page' => absint( $content_count ),
	);
} elseif ( $content_type === 'recent' ) {
	$args = array(
		'post_type'           => 'post',
		'posts_per_page'      => absint( $content_count ),
		'ignore_sticky_posts' => true,
	);
}

$args = apply_filters( 'flash_news_posts_list_section_args', $args );

flash_news_render_posts_list_section( $args );

/**
 * Render Posts List Section.
 */
function flash_news_render_posts_list_section( $args ) {
	$section_title = get_theme_mod( 'flash_news_posts_list_title', __( 'Posts List', 'flash-news' ) );
	$button_label  = get_theme_mod( 'flash_news_posts_list_button_label', __( 'View All', 'flash-news' ) );
	$button_link   = get_theme_mod( 'flash_news_posts_list_button_link' );
	$button_link   = ! empty( $button_link ) ? $button_link : '#';
	$tile_style    = get_theme_mod( 'flash_news_posts_list_section_style', 'style-1' );

	$query = new WP_Query( $args );
	if ( $query->have_posts() ) :
		?>
		<section id="flash_news_posts_list_section" class="magazine-frontpage-section magazine-small-list-section <?php echo esc_attr( $tile_style ); ?>">
			<?php
			if ( is_customize_preview() ) :
				flash_news_section_link( 'flash_news_posts_list_section' );
			endif;
			?>
			<div class="ascendoor-wrapper">
				<div class="section-header">
					<h3 class="section-title"><?php echo esc_html( $section_title ); ?></h3>
					<a href="<?php echo esc_url( $button_link ); ?>" class="mag-view-all-link"><?php echo esc_html( $button_label ); ?></a>
				</div>
				<div class="magazine-section-body">
					<div class="magazine-list-section-wrapper">
						<?php
						while ( $query->have_posts() ) :
							$query->the_post();
							?>
							<div class="mag-post-single has-image list-design">
								<div class="mag-post-img">
									<a href="<?php the_permalink(); ?>">
										<?php the_post_thumbnail(); ?>
									</a>
								</div>
								<div class="mag-post-detail">
									<div class="mag-post-detail-inner">
										<div class="mag-post-category">
											<?php flash_news_categories_list(); ?>
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
							</div>
							<?php
						endwhile;
						wp_reset_postdata();
						?>
					</div>
				</div>
			</div>
		</section>
		<?php
	endif;
}
