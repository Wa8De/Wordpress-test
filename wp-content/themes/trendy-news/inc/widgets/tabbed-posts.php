<?php
/**
 * Adds Trendy_News_Tabbed_Posts_Widget widget.
 * 
 * @package Trendy News
 * @since 1.0.0
 */
class Trendy_News_Tabbed_Posts_Widget extends WP_Widget {
    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'trendy_news_tabbed_posts_widget',
            esc_html__( 'TN : Tabbed Posts', 'trendy-news' ),
            array( 'description' => __( 'A collection of tabbed posts from specific category.', 'trendy-news' ) )
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        extract( $args );
        $latest_tab_title = isset( $instance['latest_tab_title'] ) ? json_decode( $instance['latest_tab_title'], true ) : '';
        $latest_tab_count = isset( $instance['latest_tab_count'] ) ? $instance['latest_tab_count'] : 4;
        $popular_tab_title = isset( $instance['popular_tab_title'] ) ? json_decode( $instance['popular_tab_title'], true ) : '';
        $popular_tab_count = isset( $instance['popular_tab_count'] ) ? $instance['popular_tab_count'] : 4;
        $popular_tab_category = isset( $instance['popular_tab_category'] ) ? $instance['popular_tab_category'] : '';
        $comments_tab_title = isset( $instance['comments_tab_title'] ) ? json_decode( $instance['comments_tab_title'], true ) : '';
        $comments_tab_count = isset( $instance['comments_tab_count'] ) ? $instance['comments_tab_count'] : 4;
        $tab_order = isset( $instance['tab_order'] ) ? $instance['tab_order'] : 'latest-popular-comments';
        $tabbed_posts_tab_section_order = explode( '-', $tab_order );

        echo wp_kses_post($before_widget);
            ?>
            <div class="trendy-news-tabbed-widget-tabs-wrap">
                <ul class="tabbed-widget-tabs">
                    <?php
                        $tab_count = 0;
                        foreach( $tabbed_posts_tab_section_order as $tab_key => $tab_section_order ) :
                        switch( $tab_section_order ) {
                            case 'latest': ?> <li class="tabbed-widget latest-tab<?php if( $tab_count == 0 ) echo ' active'; ?>" tab-item="latest">
                                        <?php if( $latest_tab_title['icon'] != 'fas fa-ban' ) { ?><i class="<?php echo esc_attr( $latest_tab_title['icon'] ); ?>"></i><?php } ?>
                                        <?php echo esc_html( $latest_tab_title['title'] ); ?></li>
                                    <?php
                                    $tab_count++;
                                        break;
                            case 'popular': ?> <li class="tabbed-widget popular-tab<?php if( $tab_count == 0 ) echo ' active'; ?>" tab-item="popular">
                                                <?php if( $popular_tab_title['icon'] != 'fas fa-ban' ) { ?><i class="<?php echo esc_attr( $popular_tab_title['icon'] ); ?>"></i><?php } ?><?php echo esc_html( $popular_tab_title['title'] ); ?></li>
                                            <?php
                                            $tab_count++;
                                                break;
                            case 'comments': ?> <li class="tabbed-widget comments-tab<?php if( $tab_count == 0 ) echo ' active'; ?>" tab-item="comments">
                                            <?php if( $comments_tab_title['icon'] != 'fas fa-ban' ) { ?><i class="<?php echo esc_attr( $comments_tab_title['icon'] ); ?>"></i><?php } ?><?php echo esc_html( $comments_tab_title['title'] ); ?></li>
                                            <?php
                                            $tab_count++;
                                                break;
                        }
                    endforeach; ?>
                </ul>
                <div class="widget-tabs-content">
                    <?php
                        $tab_ccount = 0;
                        foreach( $tabbed_posts_tab_section_order as $tab_key => $tab_section_order ) :
                            ?>
                            <div class="tab-item<?php if( $tab_ccount == 0 ) echo ' active'; ?>" tab-content="<?php echo esc_attr( $tab_section_order ); ?>">
                            <?php
                                switch( $tab_section_order ) {
                                    case 'latest': $latest_tab_posts = get_posts( array( 'numberposts' => absint( $latest_tab_count ) ) );
                                                    if( $latest_tab_posts ) :
                                                        foreach( $latest_tab_posts as $latest_tab_post ) :
                                                            $latest_tab_id  = $latest_tab_post->ID;
                                                        ?>
                                                            <article class="post-item tn-category-no-bk <?php if(!has_post_thumbnail($latest_tab_id)){ echo esc_attr('no-feat-img');} ?>">
                                                                <figure class="post-thumb">
                                                                    <?php if( has_post_thumbnail($latest_tab_id) ): ?>
                                                                    <a href="<?php echo esc_url(get_the_permalink($latest_tab_id));?>"><img src="<?php echo esc_url( get_the_post_thumbnail_url($latest_tab_id, 'trendy-news-thumb') ); ?>"/></a>
                                                                    <?php endif; ?>
                                                                </figure>
                                                                <div class="post-element">
                                                                    <div class="post-meta">
                                                                        <?php trendy_news_get_post_categories($latest_tab_id,2); ?>
                                                                        <?php trendy_news_posted_on(); ?>
                                                                    </div>
                                                                    <h2 class="post-title"><a href="<?php the_permalink($latest_tab_id); ?>"><?php echo wp_kses_post(get_the_title($latest_tab_id) ); ?></a></h2>
                                                                </div>
                                                            </article>
                                                        <?php
                                                        endforeach;
                                                    endif;
                                                    $tab_ccount++;
                                                break;
                                    case 'popular':    $popular_tab_posts = get_posts( array( 'numberposts' => absint( $popular_tab_count ), 'category_name' => esc_attr( $popular_tab_category ) ) );
                                                        if( $popular_tab_posts ) :
                                                            foreach( $popular_tab_posts as $popular_tab_post ) :
                                                                $popular_tab_id  = $popular_tab_post->ID;
                                                            ?>
                                                                <article class="post-item tn-category-no-bk <?php if(!has_post_thumbnail($popular_tab_id)){ echo esc_attr('no-feat-img');} ?>">
                                                                    <figure class="post-thumb">
                                                                        <?php if( has_post_thumbnail($popular_tab_id) ): ?>
                                                                            <a href="<?php echo esc_url(get_the_permalink($popular_tab_id));?>"><img src="<?php echo esc_url( get_the_post_thumbnail_url($popular_tab_id, 'trendy-news-thumb') ); ?>"/></a>
                                                                        <?php endif; ?>
                                                                    </figure>
                                                                    <div class="post-element">
                                                                        <div class="post-meta">
                                                                            <?php trendy_news_get_post_categories( $popular_tab_id, 2 ); ?>
                                                                            <?php trendy_news_posted_on(); ?>
                                                                        </div>
                                                                        <h2 class="post-title"><a href="<?php the_permalink($popular_tab_id); ?>"><?php echo wp_kses_post(get_the_title($popular_tab_id) ); ?></a></h2>
                                                                    </div>
                                                                </article>
                                                            <?php
                                                            endforeach;
                                                        endif;
                                                        $tab_ccount++;
                                                        break;
                                    case 'comments': $tab_comments = get_comments(array( 'number'   => absint( $comments_tab_count ) ));
                                                        if( $tab_comments ) :
                                                            foreach( $tab_comments as $tab_comment ) :
                                                        ?>
                                                                <div class="comment-item">
                                                                    <figure class="tn_avatar">
                                                                            <a href="<?php echo esc_url( get_comment_link( $tab_comment->comment_ID ) ); ?>">
                                                                                <?php echo get_avatar( $tab_comment->comment_author_email, 50 ); ?>     
                                                                            </a>                               
                                                                    </figure> 
                                                                    <div class="tn-comm-content">
                                                                        <a href="<?php echo esc_url( get_comment_link( $tab_comment->comment_ID ) ); ?>">
                                                                            <span class="tn-comment-author"><?php echo esc_html( get_comment_author( $tab_comment->comment_ID ) ); ?> </span> - <span class="tn_comment_post"><?php echo wp_kses_post( get_the_title($tab_comment->comment_post_ID) ); ?></span>
                                                                        </a>
                                                                        <p class="tn-comment">
                                                                            <?php echo wp_kses_post( $tab_comment->comment_content ); ?>
                                                                        </p>
                                                                    </div>
                                        
                                                                </div>
                                                        <?php
                                                            endforeach;
                                                        endif;
                                                        $tab_ccount++;
                                                        break;
                                }
                            ?>
                            </div>
                        <?php
                    endforeach; ?>
                </div>
            </div>
    <?php
        echo wp_kses_post($after_widget);
    }

    /**
     * Widgets fields
     * 
     */
    function widget_fields() {
        $categories = get_categories();
        $categories_options[''] = esc_html__( 'Select category', 'trendy-news' );
        foreach( $categories as $category ) :
            $categories_options[$category->slug] = $category->name. ' (' .$category->count. ') ';
        endforeach;
        return array(
                array(
                    'name'      => 'latest_tab_title',
                    'type'      => 'icon-text',
                    'title'     => esc_html__( 'Latest Tab', 'trendy-news' ),
                    'default'   => json_encode( array( 'icon' => 'far fa-clock', 'title'    => esc_html__( 'Latest', 'trendy-news' ) ) )
                ),
                array(
                    'name'      => 'latest_tab_count',
                    'type'      => 'number',
                    'title'     => esc_html__( 'No. of latest posts', 'trendy-news' ),
                    'default'   => 4
                ),
                array(
                    'name'      => 'popular_tab_title',
                    'type'      => 'icon-text',
                    'title'     => esc_html__( 'Popular Tab', 'trendy-news' ),
                    'default'   => json_encode( array( 'icon' => 'fas fa-fire', 'title'    => esc_html__( 'Popular', 'trendy-news' ) ) )
                ),
                array(
                    'name'      => 'popular_tab_count',
                    'type'      => 'number',
                    'title'     => esc_html__( 'No. of popular posts', 'trendy-news' ),
                    'default'   => 4
                ),
                array(
                    'name'      => 'popular_tab_category',
                    'type'      => 'select',
                    'title'     => esc_html__( 'Categories', 'trendy-news' ),
                    'description'=> esc_html__( 'Choose the category to display for popular tab', 'trendy-news' ),
                    'options'   => $categories_options
                ),
                array(
                    'name'      => 'comments_tab_title',
                    'type'      => 'icon-text',
                    'title'     => esc_html__( 'Comments Tab', 'trendy-news' ),
                    'default'   => json_encode( array( 'icon' => 'far fa-comments', 'title'    => esc_html__( 'Comments', 'trendy-news' ) ) )
                ),
                array(
                    'name'      => 'comments_tab_count',
                    'type'      => 'number',
                    'title'     => esc_html__( 'No. of comments', 'trendy-news' ),
                    'default'   => 4
                ),
                array(
                    'name'      => 'tab_order',
                    'type'      => 'select',
                    'title'     => esc_html__( 'Tab Order', 'trendy-news' ),
                    'default'   => 'latest-popular-comments',
                    'options'   => array(
                        'latest-popular-comments'   => esc_html( 'Latest - Popular - Comments', 'trendy-news' ),
                        'latest-comments-popular'   => esc_html( 'Latest - Comments - Popular', 'trendy-news' ),
                        'popular-latest-comments'   => esc_html( 'Popular - Latest - Comments', 'trendy-news' ),
                        'popular-comments-latest'   => esc_html( 'Popular - Comments - Latest', 'trendy-news' ),
                        'comments-latest-popular'   => esc_html( 'Comments - Latest - Popular', 'trendy-news' ),
                        'comments-popular-latest'   => esc_html( 'Comments - Popular - Latest', 'trendy-news' ),
                    )
                )
            );
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        $widget_fields = $this->widget_fields();
        foreach( $widget_fields as $widget_field ) :
            if ( isset( $instance[ $widget_field['name'] ] ) ) {
                $field_value = $instance[ $widget_field['name'] ];
            } else if( isset( $widget_field['default'] ) ) {
                $field_value = $widget_field['default'];
            } else {
                $field_value = '';
            }
            trendy_news_widget_fields( $this, $widget_field, $field_value );
        endforeach;
    }
 
    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $widget_fields = $this->widget_fields();
        if( ! is_array( $widget_fields ) ) {
            return $instance;
        }
        foreach( $widget_fields as $widget_field ) :
            $instance[$widget_field['name']] = trendy_news_sanitize_widget_fields( $widget_field, $new_instance );
        endforeach;

        return $instance;
    }
 
} // class Trendy_News_Tabbed_Posts_Widget