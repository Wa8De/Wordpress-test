<?php
/**
 * Includes all the frontpage sections html functions
 * 
 * @package Trendy News
 * @since 1.0.0
 */
use TrendyNews\CustomizerDefault as TND;

if( ! function_exists( 'trendy_news_main_banner_part' ) ) :
    /**
     * Main Banner element
     * 
     * @since 1.0.0
     */
     function trendy_news_main_banner_part() {
        $main_banner_option = TND\trendy_news_get_customizer_option( 'main_banner_option' );
        $main_banner_post_filter = TND\trendy_news_get_customizer_option( 'main_banner_post_filter' );
        if( ! $main_banner_option || is_paged() ) return;
        $main_banner_args = array(
            'slider_args'  => array(
                'post_status'	=> 'publish',
                'order' => 'desc',
                'orderby' => 'date',
                'posts_per_page'    => absint( TND\trendy_news_get_customizer_option( 'main_banner_slider_numbers' ) )
            )
        );
        if( $main_banner_post_filter == 'category' ) {
            $main_banner_slider_categories = json_decode( TND\trendy_news_get_customizer_option( 'main_banner_slider_categories' ) );
            $main_banner_args['slider_args']['posts_per_page']= absint( TND\trendy_news_get_customizer_option( 'main_banner_slider_numbers' ) );
            if( TND\trendy_news_get_customizer_option( 'main_banner_date_filter' ) != 'all' ) $main_banner_args['slider_args']['date_query'] = trendy_news_get_date_format_array_args(TND\trendy_news_get_customizer_option( 'main_banner_date_filter' ));
            if( $main_banner_slider_categories ) $main_banner_args['slider_args']['category_name'] = trendy_news_get_categories_for_args($main_banner_slider_categories);
        } else if( $main_banner_post_filter == 'title' ) {
            $main_banner_posts = json_decode(TND\trendy_news_get_customizer_option( 'main_banner_posts' ));
            if( $main_banner_posts ) $main_banner_args['slider_args']['post_name__in'] = trendy_news_get_post_slugs_for_args($main_banner_posts);
        }
        $banner_section_order = TND\trendy_news_get_customizer_option( 'banner_section_order' );
        ?>
            <section id="main-banner-section" class="trendy-news-section banner-layout--three <?php echo esc_attr( implode( '--', array( $banner_section_order[0]['value'], $banner_section_order[1]['value'] ) ) ); ?>">
                <div class="tn-container">
                    <div class="row">
                        <?php get_template_part( 'template-parts/main-banner/template', 'one', $main_banner_args ); ?>
                    </div>
                    <?php
                        if( TND\trendy_news_get_customizer_option( 'main_banner_block_posts_numbers' ) > 3 ) :
                            ?>
                                <div class="row">
                                    <div class="main-banner-trailing-block-posts banner-trailing-posts">
                                        <?php
                                            $main_banner_block_posts_categories = json_decode( TND\trendy_news_get_customizer_option( 'main_banner_block_posts_categories' ) );
                                            $main_banner_block_posts_order_by = TND\trendy_news_get_customizer_option( 'main_banner_block_posts_order_by' );
                                            $blockPostsOrderArray = explode( '-', $main_banner_block_posts_order_by );
                                            $block_posts_args = array(
                                                'post_status'	=> 'publish',
                                                'numberposts' => absint( TND\trendy_news_get_customizer_option( 'main_banner_block_posts_numbers' ) - 3 ),
                                                'offset'    => 3,
                                                'order' => esc_html( $blockPostsOrderArray[1] ),
                                                'orderby' => esc_html( $blockPostsOrderArray[0] ),
                                                'category_name' => trendy_news_get_categories_for_args($main_banner_block_posts_categories)
                                            );
                                            $block_posts = get_posts( $block_posts_args );
                                            if( $block_posts ) :
                                                foreach( $block_posts as $popular_post ) :
                                                    $popular_post_id  = $popular_post->ID;
                                                ?>
                                                        <article class="post-item<?php if(!has_post_thumbnail($popular_post_id)){ echo esc_attr(' no-feat-img');} ?>">
                                                            <figure class="post-thumb">
                                                                <?php if( has_post_thumbnail($popular_post_id) ): ?> 
                                                                    <a href="<?php echo esc_url(get_the_permalink($popular_post_id)); ?>">
                                                                        <img src="<?php echo esc_url( get_the_post_thumbnail_url($popular_post_id, 'trendy-news-grid') ); ?>"/>
                                                                    </a>
                                                                <?php endif; ?>
                                                            </figure>
                                                            <div class="post-element">
                                                                <?php if( TND\trendy_news_get_customizer_option( 'main_banner_block_posts_categories_option' ) ) : ?>
                                                                    <div class="post-meta">
                                                                        <?php trendy_news_get_post_categories( $popular_post_id, 2 ); ?>
                                                                    </div>
                                                                <?php endif; ?>
                                                                <h2 class="post-title"><a href="<?php the_permalink($popular_post_id); ?>"><?php echo wp_kses_post( get_the_title($popular_post_id) ); ?></a></h2>
                                                            </div>
                                                        </article>
                                                <?php
                                                endforeach;
                                            endif;
                                        ?>
                                    </div>
                                </div>
                            <?php
                        endif;
                    ?>
                </div>
            </section>
        <?php
     }
endif;
add_action( 'trendy_news_main_banner_hook', 'trendy_news_main_banner_part', 10 );

if( ! function_exists( 'trendy_news_full_width_blocks_part' ) ) :
    /**
     * Full Width Blocks element
     * 
     * @since 1.0.0
     */
     function trendy_news_full_width_blocks_part() {
        $full_width_blocks = TND\trendy_news_get_customizer_option( 'full_width_blocks' );
        if( empty( $full_width_blocks ) || is_paged() ) return;
        $full_width_blocks = json_decode( $full_width_blocks );
        if( ! in_array( true, array_column( $full_width_blocks, 'option' ) ) ) {
            return;
        }
        ?>
            <section id="full-width-section" class="trendy-news-section full-width-section">
                <div class="tn-container">
                    <div class="row">
                        <?php
                            foreach( $full_width_blocks as $block ) :
                                if( $block->option ) :
                                    $type = $block->type;
                                    switch($type) {
                                        case 'shortcode-block' : trendy_news_shortcode_block_html( $block, true );
                                                        break;
                                        case 'ad-block' : trendy_news_advertisement_block_html( $block, true );
                                                        break;
                                        default: $layout = $block->layout;
                                                $order = $block->query->order;
                                                $postCategories = $block->query->categories;
                                                $customexclude_ids = $block->query->ids;
                                                $orderArray = explode( '-', $order );
                                                $block_args = array(
                                                    'post_args' => array(
                                                        'post_status'	=> 'publish',
                                                        'post_type' => 'post',
                                                        'order' => esc_html( $orderArray[1] ),
                                                        'orderby' => esc_html( $orderArray[0] )
                                                    ),
                                                    'options'    => $block
                                                );
                                                if( $block->query->postFilter == 'category' ) {
                                                    $block_args['post_args']['posts_per_page'] = absint( $block->query->count );
                                                    if( $customexclude_ids ) $block_args['post_args']['post__not_in'] = $customexclude_ids;
                                                    if( $postCategories ) $block_args['post_args']['category_name'] = trendy_news_get_categories_for_args($postCategories);
                                                    if( $block->query->dateFilter != 'all' ) $block_args['post_args']['date_query'] = trendy_news_get_date_format_array_args($block->query->dateFilter);
                                                } else if( $block->query->postFilter == 'title' ) {
                                                    if( $block->query->posts ) $block_args['post_args']['post_name__in'] = trendy_news_get_post_slugs_for_args($block->query->posts);
                                                }
                                                // get template file w.r.t par
                                                get_template_part( 'template-parts/' .esc_html( $type ). '/template', esc_html( $layout ), $block_args );
                                    }
                                endif;
                            endforeach;
                        ?>
                    </div>
                </div>
            </section>
        <?php
     }
     add_action( 'trendy_news_full_width_blocks_hook', 'trendy_news_full_width_blocks_part' );
endif;

if( ! function_exists( 'trendy_news_leftc_rights_blocks_part' ) ) :
    /**
     * Left Content Right Sidebar Blocks element
     * 
     * @since 1.0.0
     */
     function trendy_news_leftc_rights_blocks_part() {
        $leftc_rights_blocks = TND\trendy_news_get_customizer_option( 'leftc_rights_blocks' );
        if( empty( $leftc_rights_blocks ) || is_paged() ) return;
        $leftc_rights_blocks = json_decode( $leftc_rights_blocks );
        if( ! in_array( true, array_column( $leftc_rights_blocks, 'option' ) ) ) {
            return;
        }
        ?>
            <section id="leftc-rights-section" class="trendy-news-section leftc-rights-section">
                <div class="tn-container">
                    <div class="row">
                        <div class="primary-content">
                            <?php
                                foreach( $leftc_rights_blocks as $block ) :
                                    if( $block->option ) :
                                        $type = $block->type;
                                        switch($type) {
                                            case 'shortcode-block' : trendy_news_shortcode_block_html( $block, true );
                                                        break;
                                            case 'ad-block' : trendy_news_advertisement_block_html( $block, true );
                                                            break;
                                            default: $layout = $block->layout;
                                                    $order = $block->query->order;
                                                    $postCategories = $block->query->categories;
                                                    $customexclude_ids = $block->query->ids;
                                                    $orderArray = explode( '-', $order );
                                                    $block_args = array(
                                                        'post_args' => array(
                                                            'post_status'	=> 'publish',
                                                            'post_type' => 'post',
                                                            'order' => esc_html( $orderArray[1] ),
                                                            'orderby' => esc_html( $orderArray[0] )
                                                        ),
                                                        'options'    => $block
                                                    );
                                                    if( $block->query->postFilter == 'category' ) {
                                                        $block_args['post_args']['posts_per_page'] = absint( $block->query->count );
                                                        if( $customexclude_ids ) $block_args['post_args']['post__not_in'] = $customexclude_ids;
                                                        if( $postCategories ) $block_args['post_args']['category_name'] = trendy_news_get_categories_for_args($postCategories);
                                                        if( $block->query->dateFilter != 'all' ) $block_args['post_args']['date_query'] = trendy_news_get_date_format_array_args($block->query->dateFilter);
                                                    } else if( $block->query->postFilter == 'title' ) {
                                                        if( $block->query->posts ) $block_args['post_args']['post_name__in'] = trendy_news_get_post_slugs_for_args($block->query->posts);
                                                    }
                                                    // get template file w.r.t par
                                                    get_template_part( 'template-parts/' .esc_html( $type ). '/template', esc_html( $layout ), $block_args );
                                        }
                                    endif;
                                endforeach;
                            ?>
                        </div>
                        <div class="secondary-sidebar">
                            <?php dynamic_sidebar( 'front-right-sidebar' ); ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php
     }
     add_action( 'trendy_news_leftc_rights_blocks_hook', 'trendy_news_leftc_rights_blocks_part', 10 );
endif;

if( ! function_exists( 'trendy_news_lefts_rightc_blocks_part' ) ) :
    /**
     * Left Sidebar Right Content Blocks element
     * 
     * @since 1.0.0
     */
     function trendy_news_lefts_rightc_blocks_part() {
        $lefts_rightc_blocks = TND\trendy_news_get_customizer_option( 'lefts_rightc_blocks' );
        if( empty( $lefts_rightc_blocks )|| is_paged() ) return;
        $lefts_rightc_blocks = json_decode( $lefts_rightc_blocks );
        if( ! in_array( true, array_column( $lefts_rightc_blocks, 'option' ) ) ) {
            return;
        }
        ?>
            <section id="lefts-rightc-section" class="trendy-news-section lefts-rightc-section">
                <div class="tn-container">
                    <div class="row">
                        <div class="secondary-sidebar">
                            <?php dynamic_sidebar( 'front-left-sidebar' ); ?>
                        </div>
                        <div class="primary-content">
                            <?php
                                foreach( $lefts_rightc_blocks as $block ) :
                                    if( $block->option ) :
                                        $type = $block->type;
                                        switch($type) {
                                            case 'shortcode-block' : trendy_news_shortcode_block_html( $block, true );
                                                        break;
                                            case 'ad-block' : trendy_news_advertisement_block_html( $block, true );
                                                            break;
                                            default: $layout = $block->layout;
                                                    $order = $block->query->order;
                                                    $postCategories = $block->query->categories;
                                                    $customexclude_ids = $block->query->ids;
                                                    $orderArray = explode( '-', $order );
                                                    $block_args = array(
                                                        'post_args' => array(
                                                            'post_type' => 'post',
                                                            'order' => esc_html( $orderArray[1] ),
                                                            'orderby' => esc_html( $orderArray[0] )
                                                        ),
                                                        'options'    => $block
                                                    );
                                                    if( $block->query->postFilter == 'category' ) {
                                                        $block_args['post_args']['posts_per_page'] = absint( $block->query->count );
                                                        if( $customexclude_ids ) $block_args['post_args']['post__not_in'] = $customexclude_ids;
                                                        if( $postCategories ) $block_args['post_args']['category_name'] = trendy_news_get_categories_for_args($postCategories);
                                                        if( $block->query->dateFilter != 'all' ) $block_args['post_args']['date_query'] = trendy_news_get_date_format_array_args($block->query->dateFilter);
                                                    } else if( $block->query->postFilter == 'title' ) {
                                                        if( $block->query->posts ) $block_args['post_args']['post_name__in'] = trendy_news_get_post_slugs_for_args($block->query->posts);
                                                    }
                                                    // get template file w.r.t par
                                                    get_template_part( 'template-parts/' .esc_html( $type ). '/template', esc_html( $layout ), $block_args );
                                        }
                                    endif;
                                endforeach;
                            ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php
     }
     add_action( 'trendy_news_lefts_rightc_blocks_hook', 'trendy_news_lefts_rightc_blocks_part', 10 );
endif;

if( ! function_exists( 'trendy_news_bottom_full_width_blocks_part' ) ) :
    /**
     * Bottom Full Width Blocks element
     * 
     * @since 1.0.0
     */
     function trendy_news_bottom_full_width_blocks_part() {
        $bottom_full_width_blocks = TND\trendy_news_get_customizer_option( 'bottom_full_width_blocks' );
        if( empty( $bottom_full_width_blocks )|| is_paged() ) return;
        $bottom_full_width_blocks = json_decode( $bottom_full_width_blocks );
        if( ! in_array( true, array_column( $bottom_full_width_blocks, 'option' ) ) ) {
            return;
        }
        ?>
            <section id="bottom-full-width-section" class="trendy-news-section bottom-full-width-section">
                <div class="tn-container">
                    <div class="row">
                        <?php
                            foreach( $bottom_full_width_blocks as $block ) :
                                if( $block->option ) :
                                    $type = $block->type;
                                    switch($type) {
                                        case 'shortcode-block' : trendy_news_shortcode_block_html( $block, true );
                                                        break;
                                        case 'ad-block' : trendy_news_advertisement_block_html( $block, true );
                                                        break;
                                        default: $layout = $block->layout;
                                                $order = $block->query->order;
                                                $postCategories = $block->query->categories;
                                                $customexclude_ids = $block->query->ids;
                                                $orderArray = explode( '-', $order );
                                                $block_args = array(
                                                    'post_args' => array(
                                                        'post_type' => 'post',
                                                        'order' => esc_html( $orderArray[1] ),
                                                        'orderby' => esc_html( $orderArray[0] )
                                                    ),
                                                    'options'    => $block
                                                );
                                                if( $block->query->postFilter == 'category' ) {
                                                    $block_args['post_args']['posts_per_page'] = absint( $block->query->count );
                                                    if( $customexclude_ids ) $block_args['post_args']['post__not_in'] = $customexclude_ids;
                                                    if( $postCategories ) $block_args['post_args']['category_name'] = trendy_news_get_categories_for_args($postCategories);
                                                    if( $block->query->dateFilter != 'all' ) $block_args['post_args']['date_query'] = trendy_news_get_date_format_array_args($block->query->dateFilter);
                                                } else if( $block->query->postFilter == 'title' ) {
                                                    if( $block->query->posts ) $block_args['post_args']['post_name__in'] = trendy_news_get_post_slugs_for_args($block->query->posts);
                                                }
                                                // get template file w.r.t par
                                                get_template_part( 'template-parts/' .esc_html( $type ). '/template', esc_html( $layout ), $block_args );
                                    }
                                endif;
                            endforeach;
                        ?>
                    </div>
                </div>
            </section>
        <?php
     }
     add_action( 'trendy_news_bottom_full_width_blocks_hook', 'trendy_news_bottom_full_width_blocks_part', 10 );
endif;