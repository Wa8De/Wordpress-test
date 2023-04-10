<?php get_header(); ?>

<!-- Main Container -->
<div class="main-container" id="skip-link-target">
	
	<?php

	if ( have_posts() ) :

		// Loop Start
		while ( have_posts() ) :

			the_post();

			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class('tp-single-post'); ?>>
				
				<div class="post-media">
					<a href="<?php echo esc_url( get_permalink() ); ?>"></a>
					<?php the_post_thumbnail(); ?>
				</div>

				<header class="post-header">

					<h2 class="post-title">
						<a href="<?php esc_url( the_permalink() ); ?>"><?php the_title(); ?></a>
					</h2>

			 		<?php echo '<div class="post-categories">'. get_the_category_list( ',&nbsp;&nbsp;' ) .' </div>'; ?>

				</header>

				<div class="post-content">
					<?php the_excerpt(); ?>
				</div>

				<footer class="post-footer">
					<div class="post-meta">
						<span class="post-date"><?php the_time( get_option( 'date_format' ) ); ?></span>
						<span class="meta-sep">/</span>
						<?php comments_popup_link( esc_html__( '0 Comments', 'news-element' ), esc_html__( '1 Comment', 'news-element' ), '% '. esc_html__( 'Comments', 'news-element' ), 'post-comments'); ?>

					</div>

					<div class="read-more">
						<a href="<?php echo esc_url( get_permalink() ); ?>"><?php esc_html_e( 'read more','news-element' ); ?></a>
					</div>

				</footer>

			</article>
		
			<?php

		endwhile; // Loop End

	else:

	?>

	<div class="no-result-found">
		<h3><?php esc_html_e( 'Nothing Found!', 'news-element' ); ?></h3>
		<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'news-element' ); ?></p>
		<div class="ashe-widget widget_search">
			<?php get_search_form(); ?>
		</div>
	</div>

	<?php
	
	endif; // have_posts()

	// Pagination
	the_posts_pagination();

	?>

</div><!-- .main-container -->

<?php get_footer(); ?>