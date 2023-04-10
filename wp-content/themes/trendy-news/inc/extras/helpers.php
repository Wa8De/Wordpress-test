<?php
/**
 * Includes the helper functions and hooks the theme. 
 * 
 * @package Trendy News
 * @since 1.0.0
 */
 use TrendyNews\CustomizerDefault as TND;

if( !function_exists( 'trendy_news_advertisement_block_html' ) ) :
    /**
     * Calls advertisement block
     * 
     * @since 1.0.0
     */
    function trendy_news_advertisement_block_html($options,$echo) {
        $media = $options->media;
        if( ! isset( $media->media_id ) ) return;
        echo '<div class="tn-advertisement-block is-large">';
            if( $echo ) {
                if( $options->title ) echo '<h2 class="tn-block-title">' .esc_html( $options->title ). '</h2>';
                if( $media->media_id != 0 ) {
                ?>
                    <figure class="inner-ad-block">
                        <a href="<?php echo esc_url( $options->url ); ?>" target="<?php echo esc_attr( $options->targetAttr ); ?>" rel="<?php echo esc_attr( $options->relAttr ); ?>"><img src="<?php echo esc_url( wp_get_attachment_url( $media->media_id ) ); ?>"></a>
                    </figure>
                <?php
                }
            }
        echo '</div>';
    }
 endif;

 if( !function_exists( 'trendy_news_shortcode_block_html' ) ) :
    /**
     * Calls shortcode block
     * 
     * @since 1.0.0
     */
    function trendy_news_shortcode_block_html($options,$echo) {
        $shortcode = $options->shortcode;
        if( ! $shortcode ) return;
        echo '<div class="tn-shortcode-block is-large">';
            if( $echo ) {
                echo do_shortcode( $shortcode );
            }
        echo '</div>';
    }
 endif;

 if( !function_exists( 'trendy_news_top_header_html' ) ) :
    /**
     * Calls top header hooks
     * 
     * @since 1.0.0
     */
    function trendy_news_top_header_html() {
        if( ! TND\trendy_news_get_customizer_option( 'top_header_option' ) ) return;
        require get_template_directory() . '/inc/hooks/top-header-hooks.php'; // top header hooks.
        echo '<div class="top-header">';
            echo '<div class="tn-container">';
                echo '<div class="row">';
                /**
                 * hook - trendy_news_top_header_hook
                 * 
                 * @hooked - trendy_news_top_header_menu_part - 10
                 * @hooked - trendy_news_top_header_social_part - 20
                 */
                if( has_action( 'trendy_news_top_header_hook' ) ) do_action( 'trendy_news_top_header_hook' );
                echo '</div>';
            echo '</div>';
        echo '</div>';
    }
endif;

if( !function_exists( 'trendy_news_header_html' ) ) :
    /**
     * Calls header hooks
     * 
     * @since 1.0.0
     */
    function trendy_news_header_html() {
        require get_template_directory() . '/inc/hooks/header-hooks.php'; // top header hooks.
        ?>
        <div class="main-header">
            <div class="site-branding-section">
                <div class="tn-container">
                    <div class="row">
                        <?php
                            /**
                             * hook - trendy_news_header__site_branding_section_hook
                             * 
                             * @hooked - trendy_news_header_menu_part - 10
                             * @hooked - trendy_news_header_ads_banner_part - 20
                             */
                            if( has_action( 'trendy_news_header__site_branding_section_hook' ) ) do_action( 'trendy_news_header__site_branding_section_hook' );
                        ?>
                    </div>
                </div>
            </div>
            <div class="menu-section">
                <div class="tn-container">
                    <div class="row">
                        <?php
                            /**
                             * hook - trendy_news_header__menu_section_hook
                             * 
                             * @hooked - trendy_news_header_menu_part - 10
                             * @hooked - trendy_news_header_search_part - 20
                             */
                            if( has_action( 'trendy_news_header__menu_section_hook' ) ) do_action( 'trendy_news_header__menu_section_hook' );
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
endif;

if( !function_exists( 'trendy_news_after_header_html' ) ) :
    /**
     * Calls after header hooks
     * 
     * @since 1.0.0
     */
    function trendy_news_after_header_html() {
        ?>
        <div class="after-header header-layout-banner-two">
            <div class="tn-container">
                <div class="row">
                    <?php
                        /**
                         * hook - trendy_news_after_header_hook
                         * 
                         * @hooked - trendy_news_ticker_news_part - 10
                         */
                        if( has_action( 'trendy_news_after_header_hook' ) ) do_action( 'trendy_news_after_header_hook' );
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
endif;

require get_template_directory() . '/inc/hooks/footer-hooks.php'; // footer hooks.
if( !function_exists( 'trendy_news_footer_sections_html' ) ) :
    /**
     * Calls footer hooks
     * 
     * @since 1.0.0
     */
    function trendy_news_footer_sections_html() {
        if( ! TND\trendy_news_get_customizer_option( 'footer_option' ) ) return;
        ?>
        <div class="main-footer boxed-width">
            <div class="footer-inner tn-container">
                <div class="row">
                    <?php
                        /**
                         * hook - trendy_news_footer_hook
                         * 
                         * @hooked - trendy_news_footer_widgets_area_part - 10
                         */
                        if( has_action( 'trendy_news_footer_hook' ) ) do_action( 'trendy_news_footer_hook' );
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
endif;

if( !function_exists( 'trendy_news_bottom_footer_sections_html' ) ) :
    /**
     * Calls bottom footer hooks
     * 
     * @since 1.0.0
     */
    function trendy_news_bottom_footer_sections_html() {
        if( ! TND\trendy_news_get_customizer_option( 'bottom_footer_option' ) ) return;
        require get_template_directory() . '/inc/hooks/bottom-footer-hooks.php'; // footer hooks.
        ?>
        <div class="bottom-footer">
            <div class="tn-container">
                <div class="row">
                    <?php
                        /**
                         * hook - trendy_news_bottom_footer_sections_html
                         * 
                         * @hooked - bottom_footer_social_option - 10
                         * @hooked - trendy_news_bottom_footer_menu_part - 20
                         * @hooked - trendy_news_bottom_footer_copyright_part - 3020
                         */
                        if( has_action( 'trendy_news_botttom_footer_hook' ) ) do_action( 'trendy_news_botttom_footer_hook' );
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
endif;
require get_template_directory() . '/inc/hooks/inner-hooks.php'; // inner hooks.
require get_template_directory() . '/inc/hooks/frontpage-sections-hooks.php'; // frontpage sections hooks.

if ( ! function_exists( 'trendy_news_breadcrumb_trail' ) ) :
    /**
     * Theme default breadcrumb function.
     *
     * @since 1.0.0
     */
    function trendy_news_breadcrumb_trail() {
        if ( ! function_exists( 'breadcrumb_trail' ) ) {
            // load class file
            require_once get_template_directory() . '/inc/breadcrumb-trail/breadcrumb-trail.php';
        }

        // arguments variable
        $breadcrumb_args = array(
            'container' => 'div',
            'show_browse' => false,
        );
        breadcrumb_trail( $breadcrumb_args );
    }
    add_action( 'trendy_news_breadcrumb_trail_hook', 'trendy_news_breadcrumb_trail' );
endif;

if( ! function_exists( 'trendy_news_breadcrumb_html' ) ) :
    /**
     * Theme breadcrumb
     *
     * @package Trendy News
     * @since 1.0.0
     */
    function trendy_news_breadcrumb_html() {
        $site_breadcrumb_option = TND\trendy_news_get_customizer_option( 'site_breadcrumb_option' );
        if ( ! $site_breadcrumb_option ) return;
        if ( is_front_page() || is_home() ) return;
        $site_breadcrumb_type = TND\trendy_news_get_customizer_option( 'site_breadcrumb_type' );
            ?>
        <div class="tn-container">
            <div class="row">
                <div class="trendy-news-breadcrumb-wrap">
                    <?php
                        switch( $site_breadcrumb_type ) {
                            case 'yoast': if( trendy_news_compare_wand([trendy_news_function_exists( 'yoast_breadcrumb' )] ) ) yoast_breadcrumb();
                                    break;
                            case 'rankmath': if( trendy_news_compare_wand([trendy_news_function_exists( 'rank_math_the_breadcrumbs' )] ) ) rank_math_the_breadcrumbs();
                                    break;
                            case 'bcn': if( trendy_news_compare_wand([trendy_news_function_exists( 'bcn_display' )] ) ) bcn_display();
                                    break;
                            default: do_action( 'trendy_news_breadcrumb_trail_hook' );
                                    break;
                        }
                    ?>
                </div>
            </div>
        </div>
    <?php
    }
endif;
add_action( 'trendy_news_before_main_content', 'trendy_news_breadcrumb_html' );

if( ! function_exists( 'trendy_news_button_html' ) ) :
    /**
     * View all html
     * 
     * @package Trendy News
     * @since 1.0.0
     */
    function trendy_news_button_html( $args ) {
        if( ! $args['option'] ) return;
        $global_button_text = array( 
            "icon"  => "fas fa-angle-right",
            "text"   => esc_html__( 'Read More', 'trendy-news'
        ));
        $classes = isset( $args['classes'] ) ? 'post-link-button' . ' ' .$args['classes'] : 'post-link-button';
        $link = isset( $args['link'] ) ? $args['link'] : get_the_permalink();
        $text = isset( $args['text'] ) ? $args['text'] : $global_button_text['text'];
        $icon = isset( $args['icon'] ) ? $args['icon'] : $global_button_text['icon'];
        echo apply_filters( 'trendy_news_button_html', sprintf( '<a class="%1$s" href="%2$s">%3$s<i class="%4$s"></i></a>', esc_attr( $classes ), esc_url( $link ), esc_html( $text ), esc_attr( $icon ) ) );
    }
    add_action( 'trendy_news_section_block_view_all_hook', 'trendy_news_button_html', 10, 1 );
endif;

if( ! function_exists( 'trendy_news_archive_excerpt_length' ) ) :
    /**
     * Custom excerpt length
     * 
     * @package Trendy News
     * @since 1.0.0
     */
    function trendy_news_archive_excerpt_length( $length ) {
        return absint( TND\trendy_news_get_customizer_option( 'archive_excerpt_length' ) );
    }
endif;

if( ! function_exists( 'trendy_news_archive_excerpt_more_string' ) ) :
    /**
     * Excerpt more string filter
     * 
     * @package Trendy News
     * @since 1.0.0
     */
    function trendy_news_archive_excerpt_more_string( $more ) {
        return '...';
    }
    add_filter('excerpt_more', 'trendy_news_archive_excerpt_more_string');
endif;

if( ! function_exists( 'trendy_news_pagination_fnc' ) ) :
    /**
     * Renders pagination html
     * 
     * @package Trendy News
     * @since 1.0.0
     */
    function trendy_news_pagination_fnc() {
        if( is_null( paginate_links() ) ) {
            return;
        }
        ?>
        <div class="pagination"><?php echo wp_kses_post( paginate_links( array( 'prev_text' => '<i class="fas fa-chevron-left"></i>', 'next_text' => '<i class="fas fa-chevron-right"></i>', 'type' => 'list' ) ) ); ?></div>
        <?php
    }
    add_action( 'trendy_news_pagination_link_hook', 'trendy_news_pagination_fnc' );
 endif;

 if( ! function_exists( 'trendy_news_scroll_to_top_html' ) ) :
    /**
     * Scroll to top fnc
     * 
     * @package Trendy News
     * @since 1.0.0
     */
    function trendy_news_scroll_to_top_html() {
        if( ! TND\trendy_news_get_multiselect_tab_option('stt_responsive_option') ) return;
        $stt_alignment = TND\trendy_news_get_customizer_option( 'stt_alignment' );
    ?>
        <div id="tn-scroll-to-top" class="<?php echo esc_attr( 'align--' . $stt_alignment ); ?>">
            <span class="icon-holder"><i class="fas fa-angle-up"></i></span>
        </div><!-- #tn-scroll-to-top -->
    <?php
    }
    add_action( 'trendy_news_after_footer_hook', 'trendy_news_scroll_to_top_html' );
 endif;

if( ! function_exists( 'trendy_news_loader_html' ) ) :
	/**
     * Preloader html
     * 
     * @package Trendy News
     * @since 1.0.0
     */
	function trendy_news_loader_html() {
        if( ! TND\trendy_news_get_customizer_option( 'preloader_option' ) ) return;
	?>
		<div class="tn_loading_box">
			<div class="box">
				<div class="loader-9"></div>
			</div>
		</div>
	<?php
	}
    add_action( 'trendy_news_page_prepend_hook', 'trendy_news_loader_html', 1 );
endif;

 if( ! function_exists( 'trendy_news_custom_header_html' ) ) :
    /**
     * Site custom header html
     * 
     * @package Trendy News
     * @since 1.0.0
     */
    function trendy_news_custom_header_html() {
        /**
         * Get custom header markup
         * 
         * @since 1.0.0 
         */
        the_custom_header_markup();
    }
    add_action( 'trendy_news_page_prepend_hook', 'trendy_news_custom_header_html', 20 );
 endif;