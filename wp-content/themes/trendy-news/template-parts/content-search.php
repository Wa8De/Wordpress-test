<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Trendy News
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('list-item'); ?>>

	<figure class="post-thumb-wrap <?php if(!has_post_thumbnail()){ echo esc_attr('no-feat-img');} ?>">
        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
            <?php
                if( has_post_thumbnail() ) : 
                    the_post_thumbnail('trendy-news-list', array(
                        'title' => the_title_attribute(array(
                            'echo'  => false
                        ))
                    ));
                endif;
            ?>
        </a>
        <?php trendy_news_get_post_categories( get_the_ID(), 2 ); ?>
    </figure>
    <div class="post-element">
        <h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
        <div class="post-meta">
            <span class="post-author"><span class="author_name"><?php echo esc_html(get_the_author_meta( 'display_name' )); ?></span></span>
            <?php trendy_news_posted_on(); ?>
            <span class="post-comment"><?php echo absint( get_comments_number() ); ?></span>
        </div>
        <div class="post-excerpt"><?php the_excerpt(); ?></div>
        <?php
            do_action( 'trendy_news_section_block_view_all_hook', array(
                'option'    => true
            ));
        ?>
    </div>

</article><!-- #post-<?php the_ID(); ?> -->
