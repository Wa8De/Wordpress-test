<?php
/**
 * Ticker news template two
 * 
 * @package Trendy News
 * @since 1.0.0
 */
$ticker_query = new WP_Query( $args );
if( $ticker_query->have_posts() ) :
    while( $ticker_query->have_posts() ) : $ticker_query->the_post();
    ?>
        <li class="ticker-item">
            <h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
            <?php trendy_news_posted_on(); ?>
        </li>
    <?php
    endwhile;
endif;