<?php
/**
 * Header hooks and functions
 * 
 * @package Trendy News
 * @since 1.0.0
 */
use TrendyNews\CustomizerDefault as TND;
 if( ! function_exists( 'trendy_news_header_site_branding_part' ) ) :
    /**
     * Header site branding element
     * 
     * @since 1.0.0
     */
     function trendy_news_header_site_branding_part() {
         ?>
            <div class="site-branding">
                <?php
                    the_custom_logo();
                    if ( is_front_page() && is_home() ) :
                ?>
                        <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                <?php
                    else :
                ?>
                        <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                <?php
                    endif;
                    $trendy_news_description = get_bloginfo( 'description', 'display' );
                    if ( $trendy_news_description || is_customize_preview() ) :
                ?>
                    <p class="site-description" itemprop="description"><?php echo apply_filters( 'trendy_news_bloginfo_description', esc_html( $trendy_news_description ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
                <?php endif; ?>
            </div><!-- .site-branding -->
         <?php
     }
    add_action( 'trendy_news_header__site_branding_section_hook', 'trendy_news_header_site_branding_part', 10 );
 endif;

 if( ! function_exists( 'trendy_news_header_ads_banner_part' ) ) :
    /**
     * Header ads banner element
     * 
     * @since 1.0.0
     */
     function trendy_news_header_ads_banner_part() {
        if( ! TND\trendy_news_get_multiselect_tab_option( 'header_ads_banner_responsive_option' ) ) return;
        $header_ads_banner_type = TND\trendy_news_get_customizer_option( 'header_ads_banner_type' );
        ?>
            <div class="ads-banner">
                <?php
                    switch( $header_ads_banner_type ) {
                        case 'sidebar' : dynamic_sidebar( 'ads-banner-sidebar' );
                                    break;
                        default: $header_ads_banner_custom_image = TND\trendy_news_get_customizer_option( 'header_ads_banner_custom_image' );
                            $header_ads_banner_custom_url = TND\trendy_news_get_customizer_option( 'header_ads_banner_custom_url' );
                            $header_ads_banner_custom_target = TND\trendy_news_get_customizer_option( 'header_ads_banner_custom_target' );
                            if( ! empty( $header_ads_banner_custom_image ) ) :
                            ?>
                                <a href="<?php echo esc_url( $header_ads_banner_custom_url ); ?>" target="<?php echo esc_html( $header_ads_banner_custom_target ); ?>"><img src="<?php echo esc_url( wp_get_attachment_url( $header_ads_banner_custom_image ) ); ?>"></a>
                            <?php
                            endif;
                    }
                ?>        
            </div><!-- .ads-banner -->
        <?php
     }
    add_action( 'trendy_news_header__site_branding_section_hook', 'trendy_news_header_ads_banner_part', 20 );
 endif;

 if( ! function_exists( 'trendy_news_header_sidebar_toggle_part' ) ) :
    /**
     * Header sidebar toggle element
     * 
     * @since 1.0.0
     */
     function trendy_news_header_sidebar_toggle_part() {
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
    add_action( 'trendy_news_header__menu_section_hook', 'trendy_news_header_sidebar_toggle_part', 30 );
 endif;

 if( ! function_exists( 'trendy_news_header_menu_part' ) ) :
    /**
     * Header menu element
     * 
     * @since 1.0.0
     */
    function trendy_news_header_menu_part() {
      ?>
        <nav id="site-navigation" class="main-navigation <?php echo esc_attr( 'hover-effect--' . TND\trendy_news_get_customizer_option( 'header_menu_hover_effect' ) ); ?>">
            <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                <div id="tn_menu_burger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <span class="menu_txt"><?php esc_html_e( 'Menu', 'trendy-news' ); ?></span></button>
            <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'menu-2',
                        'menu_id'        => 'header-menu',
                    )
                );
            ?>
        </nav><!-- #site-navigation -->
      <?php
    }
    add_action( 'trendy_news_header__menu_section_hook', 'trendy_news_header_menu_part', 40 );
 endif;

 if( ! function_exists( 'trendy_news_header_search_part' ) ) :
   /**
    * Header search element
    * 
    * @since 1.0.0
    */
    function trendy_news_header_search_part() {
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
   add_action( 'trendy_news_header__menu_section_hook', 'trendy_news_header_search_part', 50 );
endif;

if( ! function_exists( 'trendy_news_header_theme_mode_icon_part' ) ) :
    /**
     * Header theme mode element
     * 
     * @since 1.0.0
     */
     function trendy_news_header_theme_mode_icon_part() {
        if( ! TND\trendy_news_get_customizer_option( 'header_theme_mode_toggle_option' ) ) return;
        ?>
            <div class="mode_toggle_wrap">
                <input class="mode_toggle" type="checkbox">
            </div>
        <?php
     }
    add_action( 'trendy_news_header__menu_section_hook', 'trendy_news_header_theme_mode_icon_part', 60 );
 endif;

 if( ! function_exists( 'trendy_news_ticker_news_part' ) ) :
    /**
     * Ticker news element
     * 
     * @since 1.0.0
     */
     function trendy_news_ticker_news_part() {
        if( ! is_front_page() || ! TND\trendy_news_get_customizer_option('ticker_news_option' ) ) return;
        $ticker_news_post_filter = TND\trendy_news_get_customizer_option( 'ticker_news_post_filter' );
        $ticker_args = array(
            'order' => 'desc',
            'orderby' => 'date',
            'posts_per_page'    => 6
        );
        if( $ticker_news_post_filter == 'category' ) {
            $ticker_news_categories = json_decode( TND\trendy_news_get_customizer_option( 'ticker_news_categories' ) );
            if( TND\trendy_news_get_customizer_option( 'ticker_news_date_filter' ) != 'all' ) $ticker_args['date_query'] = trendy_news_get_date_format_array_args(TND\trendy_news_get_customizer_option( 'ticker_news_date_filter' ));
            if( $ticker_news_categories ) $ticker_args['category_name'] = trendy_news_get_categories_for_args($ticker_news_categories);
        } else if( $ticker_news_post_filter == 'title' ) {
            $ticker_news_posts = json_decode(TND\trendy_news_get_customizer_option( 'ticker_news_posts' ));
            if( $ticker_news_posts ) $ticker_args['post_name__in'] = trendy_news_get_post_slugs_for_args($ticker_news_posts);
        }
         ?>
            <div class="ticker-news-wrap trendy-news-ticker <?php echo esc_attr( 'layout--two' ); ?>">
                <?php
                    $ticker_news_title = TND\trendy_news_get_customizer_option('ticker_news_title');
                    if( $ticker_news_title ) {
                        ?>
                        <div class="ticker_label_title ticker-title trendy-news-ticker-label">
                            <?php if( $ticker_news_title['icon'] != "fas fa-ban" ) : ?>
                                <span class="icon">
                                    <i class="<?php echo esc_attr($ticker_news_title['icon']); ?>"></i>
                                </span>
                            <?php endif;
                                if( $ticker_news_title['text'] ) :
                             ?>
                                    <span class="ticker_label_title_string"><?php echo esc_html( $ticker_news_title['text'] ); ?></span>
                                <?php endif; ?>
                        </div>
                        <?php
                    }
                ?>
                <div class="trendy-news-ticker-box">
                  <?php
                    $trendy_news_direction = 'left';
                    $trendy_news_dir = 'ltr';
                    if( is_rtl() ){
                      $trendy_news_direction = 'right';
                      $trendy_news_dir = 'ltr';
                    }
                  ?>

                    <ul class="ticker-item-wrap" direction="<?php echo esc_attr($trendy_news_direction); ?>" dir="<?php echo esc_attr($trendy_news_dir); ?>">
                        <?php get_template_part( 'template-parts/ticker-news/template', 'two', $ticker_args ); ?>
                    </ul>
                </div>
                <div class="trendy-news-ticker-controls">
                    <button class="trendy-news-ticker-pause"><i class="fas fa-pause"></i></button>
                </div>
            </div>
         <?php
     }
    add_action( 'trendy_news_after_header_hook', 'trendy_news_ticker_news_part', 10 );
 endif;
 