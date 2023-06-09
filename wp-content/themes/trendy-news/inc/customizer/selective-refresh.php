<?php
/**
 * Includes functions for selective refresh
 * 
 * @package Trendy News
 * @since 1.0.0
 */
use TrendyNews\CustomizerDefault as TND;
if( ! function_exists( 'trendy_news_customize_selective_refresh' ) ) :
    /**
     * Adds partial refresh for the customizer preview
     * 
     */
    function trendy_news_customize_selective_refresh( $wp_customize ) {
        if ( ! isset( $wp_customize->selective_refresh ) ) return;
        // top header show hide
        $wp_customize->selective_refresh->add_partial(
            'top_header_option',
            array(
                'selector'        => '#masthead .top-header',
                'render_callback' => 'trendy_news_top_header_html'
            )
        );
        // top header menu show hide
        $wp_customize->selective_refresh->add_partial(
            'top_header_menu_option',
            array(
                'selector'        => '#masthead .top-header .top-menu',
                'render_callback' => 'trendy_news_top_header_menu_part_selective_refresh'
            )
        );
        // top header social icons show hide
        $wp_customize->selective_refresh->add_partial(
            'top_header_social_option',
            array(
                'selector'        => '#masthead .top-header .social-icons-wrap',
                'render_callback' => 'trendy_news_top_header_social_part_selective_refresh'
            )
        );
        // header sidebar toggle show hide
        $wp_customize->selective_refresh->add_partial(
            'header_sidebar_toggle_option',
            array(
                'selector'        => '#masthead .sidebar-toggle-wrap',
                'render_callback' => 'trendy_news_header_sidebar_toggle_part_selective_refresh'
            )
        );
        // header search icon show hide
        $wp_customize->selective_refresh->add_partial(
            'header_search_option',
            array(
                'selector'        => '#masthead .search-wrap',
                'render_callback' => 'trendy_news_header_search_part_selective_refresh'
            )
        );
        // theme mode toggle show hide
        $wp_customize->selective_refresh->add_partial(
            'header_theme_mode_toggle_option',
            array(
                'selector'        => '#masthead .mode_toggle_wrap',
                'render_callback' => 'trendy_news_header_theme_mode_icon_part_selective_refresh'
            )
        );
        // site title
        $wp_customize->selective_refresh->add_partial(
            'blogname',
            array(
                'selector'        => '.site-title a',
                'render_callback' => 'trendy_news_customize_partial_blogname',
            )
        );
        // site description
        $wp_customize->selective_refresh->add_partial(
            'blogdescription',
            array(
                'selector'        => '.site-description',
                'render_callback' => 'trendy_news_customize_partial_blogdescription',
            )
        );
        
        // social icons target attribute
        $wp_customize->selective_refresh->add_partial(
            'social_icons_target',
            array(
                'selector'        => '.top-header .social-icons-wrap',
                'render_callback' => 'trendy_news_customizer_social_icons',
            )
        );

        // social icons
        $wp_customize->selective_refresh->add_partial(
            'social_icons',
            array(
                'selector'        => '.top-header .social-icons-wrap',
                'render_callback' => 'trendy_news_customizer_social_icons',
            )
        );

        // ticker news title
        $wp_customize->selective_refresh->add_partial(
            'ticker_news_title',
            array(
                'selector'        => '.ticker-news-wrap .ticker_label_title',
                'render_callback' => 'trendy_news_customizer_ticker_label',
            )
        );
        
        // single post related posts option
        $wp_customize->selective_refresh->add_partial(
            'single_post_related_posts_option',
            array(
                'selector'        => '.single-related-posts-section-wrap',
                'render_callback' => 'trendy_news_single_related_posts',
            )
        );
        
        // footer option
        $wp_customize->selective_refresh->add_partial(
            'footer_option',
            array(
                'selector'        => 'footer .main-footer',
                'render_callback' => 'trendy_news_footer_sections_html',
                'container_inclusive'=> true
            )
        );

        // footer column option
        $wp_customize->selective_refresh->add_partial(
            'footer_widget_column',
            array(
                'selector'        => 'footer .main-footer',
                'render_callback' => 'trendy_news_footer_sections_html',
            )
        );

        // bottom footer option
        $wp_customize->selective_refresh->add_partial(
            'bottom_footer_option',
            array(
                'selector'        => 'footer .bottom-footer',
                'render_callback' => 'trendy_news_bottom_footer_sections_html',
            )
        );

        // bottom footer menu option
        $wp_customize->selective_refresh->add_partial(
            'bottom_footer_menu_option',
            array(
                'selector'        => 'footer .bottom-footer .bottom-menu',
                'render_callback' => 'trendy_news_bottom_footer_menu_part_selective_refresh',
            )
        );

        // bottom footer menu option
        $wp_customize->selective_refresh->add_partial(
            'bottom_footer_social_option',
            array(
                'selector'        => 'footer .bottom-footer .social-icons-wrap',
                'render_callback' => 'trendy_news_botttom_footer_social_part_selective_refresh',
            )
        );

        // full width blocks
        $wp_customize->selective_refresh->add_partial(
            'full_width_blocks',
            array(
                'selector'        => '#full-width-section',
                'render_callback' => 'trendy_news_full_width_blocks_part_selective_refresh',
            )
        );

        // leftc rights blocks
        $wp_customize->selective_refresh->add_partial(
            'leftc_rights_blocks',
            array(
                'selector'        => '#leftc-rights-section',
                'render_callback' => 'trendy_news_leftc_rights_blocks_part_selective_refresh',
            )
        );

        // lefts rightc blocks
        $wp_customize->selective_refresh->add_partial(
            'lefts_rightc_blocks',
            array(
                'selector'        => '#lefts-rightc-section',
                'render_callback' => 'trendy_news_lefts_rightc_blocks_part_selective_refresh',
            )
        );

        // bottom full width blocks
        $wp_customize->selective_refresh->add_partial(
            'bottom_full_width_blocks',
            array(
                'selector'        => '#bottom-full-width-section',
                'render_callback' => 'trendy_news_bottom_full_width_blocks_part_selective_refresh',
            )
        );
    }
    add_action( 'customize_register', 'trendy_news_customize_selective_refresh' );
endif;

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function trendy_news_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function trendy_news_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

// top header menu part
function trendy_news_top_header_menu_part_selective_refresh() {
    if( ! TND\trendy_news_get_customizer_option( 'top_header_menu_option' ) ) return;
    ?>
       <div class="top-menu">
              <?php
             if( has_nav_menu( 'menu-1' ) ) :
                wp_nav_menu(
                   array(
                      'theme_location' => 'menu-1',
                      'menu_id'        => 'top-header-menu',
                      'depth' => 1
                   )
                );
             else :
                if ( is_user_logged_in() && current_user_can( 'edit_theme_options' ) ) {
                   ?>
                      <a href="<?php echo esc_url( admin_url( '/nav-menus.php?action=locations' ) ); ?>"><?php esc_html_e( 'Setup Top Header Menu', 'trendy-news' ); ?></a>
                   <?php
                }
             endif;
              ?>
          </div>
    <?php
}

// top header social icons part
function trendy_news_top_header_social_part_selective_refresh() {
    if( ! TND\trendy_news_get_customizer_option( 'top_header_social_option' ) ) return;
    ?>
       <div class="social-icons-wrap">
          <?php trendy_news_customizer_social_icons(); ?>
       </div>
    <?php
}

function trendy_news_header_sidebar_toggle_part_selective_refresh() {
    if( ! TND\trendy_news_get_customizer_option( 'header_sidebar_toggle_option' ) ) return;
    ?>
       <div class="sidebar-toggle-wrap">
           <a class="sidebar-toggle-trigger" href="javascript:void(0);">
               <div class="tn_sidetoggle_menu_burger">
                 <span></span>
                 <span></span>
                 <span></span>
             </div>
           </a>
           <div class="sidebar-toggle dark_bk hide">
             <div class="tn-container">
               <div class="row">
                 <?php dynamic_sidebar( 'header-toggle-sidebar' ); ?>
               </div>
             </div>
           </div>
       </div>
    <?php
}

// ticker label latest tab
function trendy_news_customizer_ticker_label() {
    $ticker_news_title = TND\trendy_news_get_customizer_option( 'ticker_news_title' );
    return ( '<span class="icon"><i class="' .esc_attr( $ticker_news_title['icon'] ). '"></i></span><span class="ticker_label_title_string">' .esc_html( $ticker_news_title['text'] ). '</span>' );
}

function trendy_news_header_search_part_selective_refresh() {
    if( ! TND\trendy_news_get_customizer_option( 'header_search_option' ) ) return;
    ?>
        <div class="search-wrap">
            <button class="search-trigger">
                <i class="fas fa-search"></i>
            </button>
            <div class="search-form-wrap hide">
                <?php echo get_search_form(); ?>
            </div>
        </div>
    <?php
}

function trendy_news_header_theme_mode_icon_part_selective_refresh() {
    if( ! TND\trendy_news_get_customizer_option( 'header_theme_mode_toggle_option' ) ) return;
    ?>
        <div class="mode_toggle_wrap">
            <input class="mode_toggle" type="checkbox">
        </div>
    <?php
 }

// bottom footer menu part
function trendy_news_bottom_footer_menu_part_selective_refresh() {
    if( ! TND\trendy_news_get_customizer_option( 'bottom_footer_menu_option' ) ) return;
    ?>
       <div class="bottom-menu">
          <?php
          if( has_nav_menu( 'menu-3' ) ) :
             wp_nav_menu(
                array(
                   'theme_location' => 'menu-3',
                   'menu_id'        => 'bottom-footer-menu',
                   'depth' => 1
                )
             );
             else :
                if ( is_user_logged_in() && current_user_can( 'edit_theme_options' ) ) {
                   ?>
                      <a href="<?php echo esc_url( admin_url( '/nav-menus.php?action=locations' ) ); ?>"><?php esc_html_e( 'Setup Bottom Footer Menu', 'trendy-news' ); ?></a>
                   <?php
                }
             endif;
          ?>
       </div>
    <?php
 }

// bottom footer social icons part
function trendy_news_botttom_footer_social_part_selective_refresh() {
    if( ! TND\trendy_news_get_customizer_option( 'bottom_footer_social_option' ) ) return;
    ?>
       <div class="social-icons-wrap">
          <?php trendy_news_customizer_social_icons(); ?>
       </div>
    <?php
}

// full  width row
function trendy_news_full_width_blocks_part_selective_refresh() {
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

 // leftc rights row
 function trendy_news_leftc_rights_blocks_part_selective_refresh() {
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

 // lefts rightc row
 function trendy_news_lefts_rightc_blocks_part_selective_refresh() {
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

 // lefts rightc row
 function trendy_news_bottom_full_width_blocks_part_selective_refresh() {
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