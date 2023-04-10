<?php
/**
 * Inner sections hooks and functions
 * 
 * @package Trendy News
 * @since 1.0.0
 */
use TrendyNews\CustomizerDefault as TND;
if( ! function_exists( 'trendy_news_single_related_posts' ) ) :
    /**
     * Single related posts
     * 
     * @package Trendy News
     */
    function trendy_news_single_related_posts() {
        if( get_post_type() != 'post' ) return;
        $single_post_related_posts_option = TND\trendy_news_get_customizer_option( 'single_post_related_posts_option' );
        if( ! $single_post_related_posts_option ) return;
        $related_posts_title = TND\trendy_news_get_customizer_option('single_post_related_posts_title');
        $related_posts_args = array(
            'post_status'	=> 'publish',
            'posts_per_page'   => 3,
            'post__not_in'  => array( get_the_ID() )
        );
        $current_post_categories = get_the_category(get_the_ID());
        if( $current_post_categories ) :
            foreach( $current_post_categories as $current_post_cat ) :
                $query_cats[] =  $current_post_cat->term_id;
            endforeach;
            $related_posts_args['category__in'] = $query_cats;
        endif;
        $related_posts = new WP_Query( $related_posts_args );
        if( ! $related_posts->have_posts() ) return;
  ?>
            <div class="single-related-posts-section-wrap layout--grid<?php if( TND\trendy_news_get_customizer_option( 'single_post_related_posts_popup_option' ) ) echo esc_attr( ' related_posts_popup' ); ?>">
                <div class="single-related-posts-section">
                    <a href="javascript:void(0);" class="related_post_close">
                        <i class="fas fa-times-circle"></i>
                    </a>
                    <?php
                        if( $related_posts_title ) echo '<h2 class="tn-block-title"><span>' .esc_html( $related_posts_title ). '</span></h2>';
                            echo '<div class="single-related-posts-wrap">';
                                while( $related_posts->have_posts() ) : $related_posts->the_post();
                            ?>
                                <article post-id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                    <?php if( has_post_thumbnail() ) : ?>
                                        <figure class="post-thumb-wrap <?php if(!has_post_thumbnail()){ echo esc_attr('no-feat-img');} ?>">
                                            <?php trendy_news_post_thumbnail(); ?>
                                        </figure>
                                    <?php endif; ?>
                                    <div class="post-element">
                                        <h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                        <div class="post-meta">
                                            <?php
                                                trendy_news_posted_by();
                                                trendy_news_posted_on();
                                            ?>
                                            <span class="post-comment"><?php echo absint( get_comments_number() ); ?></span>
                                        </div>
                                    </div>
                                </article>
                            <?php
                                endwhile;
                            echo '</div>';
                    ?>
                </div>
            </div>
    <?php
    }
endif;
add_action( 'trendy_news_single_post_append_hook', 'trendy_news_single_related_posts' );