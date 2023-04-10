<?php
use TrendyNews\CustomizerDefault as TND;
/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
add_action( 'customize_preview_init', function() {
    wp_enqueue_script( 
        'trendy-news-customizer-preview',
        get_template_directory_uri() . '/inc/customizer/assets/customizer-preview.min.js',
        ['customize-preview'],
        TRENDY_NEWS_VERSION,
        true
    );
    // localize scripts
	wp_localize_script( 
        'trendy-news-customizer-preview',
        'trendyNewsPreviewObject', array(
            '_wpnonce'	=> wp_create_nonce( 'trendy-news-customizer-nonce' ),
            'ajaxUrl' => admin_url('admin-ajax.php')
        )
    );
});

add_action( 'customize_controls_enqueue_scripts', function() {
    $buildControlsDeps = apply_filters(  'trendy_news_customizer_build_controls_dependencies', array(
        'react',
        'wp-blocks',
        'wp-editor',
        'wp-element',
        'wp-i18n',
        'wp-polyfill',
        'wp-components'
    ));
	wp_enqueue_style( 
        'trendy-news-customizer-control',
        get_template_directory_uri() . '/inc/customizer/assets/customizer-controls.min.css', 
        array('wp-components'),
        TRENDY_NEWS_VERSION,
        'all'
    );
    wp_enqueue_script( 
        'trendy-news-customizer-control',
        get_template_directory_uri() . '/inc/customizer/assets/customizer-extends.min.js',
        $buildControlsDeps,
        TRENDY_NEWS_VERSION,
        true
    );
    wp_localize_script( 
        'trendy-news-customizer-control', 
        'customizerControlsObject', array(
            'categories'    => trendy_news_get_multicheckbox_categories_simple_array(),
            'posts'    => trendy_news_get_multicheckbox_posts_simple_array(),
            '_wpnonce'	=> wp_create_nonce( 'trendy-news-customizer-controls-live-nonce' ),
            'ajaxUrl' => admin_url('admin-ajax.php')
        )
    );
    // localize scripts
    wp_localize_script( 
        'trendy-news-customizer-extras', 
        'customizerExtrasObject', array(
            '_wpnonce'	=> wp_create_nonce( 'trendy-news-customizer-controls-nonce' ),
            'ajaxUrl' => admin_url('admin-ajax.php')
        )
    );
});

if( !function_exists( 'trendy_news_customizer_about_theme_panel' ) ) :
    /**
     * Register blog archive section settings
     * 
     */
    function trendy_news_customizer_about_theme_panel( $wp_customize ) {
        /**
         * About theme section
         * 
         * @since 1.0.0
         */
        $wp_customize->add_section( TRENDY_NEWS_PREFIX . 'about_section', array(
            'title' => esc_html__( 'About Theme / Pro Features', 'trendy-news' ),
            'priority'  => 1
        ));

        // upgrade info box
        $wp_customize->add_setting( 'upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Info_Box_Control( $wp_customize, 'upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'trendy-news' ),
                'description' => esc_html__( 'For more features like unlimited news sections, more layouts, typography, color options, youtube video playlist section and many more advanced features with technical support.', 'trendy-news' ),
                'section'     => TRENDY_NEWS_PREFIX . 'about_section',
                'settings'    => 'upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'trendy-news' ),
                        'url'   => esc_url( '//blazethemes.com/theme/trendy-news-pro/' )
                    )
                )
            ))
        );

        // theme documentation info box
        $wp_customize->add_setting( 'site_documentation_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Info_Box_Control( $wp_customize, 'site_documentation_info', array(
                'label'	      => esc_html__( 'Theme Documentation', 'trendy-news' ),
                'description' => esc_html__( 'We have well prepared documentation which includes overall instructions and recommendations that are required in this theme.', 'trendy-news' ),
                'section'     => TRENDY_NEWS_PREFIX . 'about_section',
                'settings'    => 'site_documentation_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Documentation', 'trendy-news' ),
                        'url'   => esc_url( '//doc.blazethemes.com/trendy-news' )
                    )
                )
            ))
        );

        // theme documentation info box
        $wp_customize->add_setting( 'site_support_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Info_Box_Control( $wp_customize, 'site_support_info', array(
                'label'	      => esc_html__( 'Theme Support', 'trendy-news' ),
                'description' => esc_html__( 'We provide 24/7 support regarding any theme issue. Our support team will help you to solve any kind of issue. Feel free to contact us.', 'trendy-news' ),
                'section'     => TRENDY_NEWS_PREFIX . 'about_section',
                'settings'    => 'site_support_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'Support Form', 'trendy-news' ),
                        'url'   => esc_url( '//blazethemes.com/support' )
                    )
                )
            ))
        );
    }
    add_action( 'customize_register', 'trendy_news_customizer_about_theme_panel', 10 );
endif;

if( !function_exists( 'trendy_news_customizer_global_panel' ) ) :
    /**
     * Register global options settings
     * 
     */
    function trendy_news_customizer_global_panel( $wp_customize ) {
        /**
         * Global panel
         * 
         * @package Trendy News
         * @since 1.0.0
         */
        $wp_customize->add_panel( 'trendy_news_global_panel', array(
            'title' => esc_html__( 'Global', 'trendy-news' ),
            'priority'  => 5
        ));

        // section- seo/misc settings section
        $wp_customize->add_section( 'trendy_news_seo_misc_section', array(
            'title' => esc_html__( 'SEO / Misc', 'trendy-news' ),
            'panel' => 'trendy_news_global_panel'
        ));

        // site schema ready option
        $wp_customize->add_setting( 'site_schema_ready', array(
            'default'   => TND\trendy_news_get_customizer_default( 'site_schema_ready' ),
            'sanitize_callback' => 'trendy_news_sanitize_toggle_control',
            'transport'    => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Toggle_Control( $wp_customize, 'site_schema_ready', array(
                'label'	      => esc_html__( 'Make website schema ready', 'trendy-news' ),
                'section'     => 'trendy_news_seo_misc_section',
                'settings'    => 'site_schema_ready'
            ))
        );

        // site date to show
        $wp_customize->add_setting( 'site_date_to_show', array(
            'sanitize_callback' => 'trendy_news_sanitize_select_control',
            'default'   => TND\trendy_news_get_customizer_default( 'site_date_to_show' )
        ));
        $wp_customize->add_control( 'site_date_to_show', array(
            'type'      => 'select',
            'section'   => 'trendy_news_seo_misc_section',
            'label'     => esc_html__( 'Date to display', 'trendy-news' ),
            'description' => esc_html__( 'Whether to show date published or modified date.', 'trendy-news' ),
            'choices'   => array(
                'published'  => __( 'Published date', 'trendy-news' ),
                'modified'   => __( 'Modified date', 'trendy-news' )
            )
        ));

        // site date format
        $wp_customize->add_setting( 'site_date_format', array(
            'sanitize_callback' => 'trendy_news_sanitize_select_control',
            'default'   => TND\trendy_news_get_customizer_default( 'site_date_format' )
        ));
        $wp_customize->add_control( 'site_date_format', array(
            'type'      => 'select',
            'section'   => 'trendy_news_seo_misc_section',
            'label'     => esc_html__( 'Date format', 'trendy-news' ),
            'description' => esc_html__( 'Date format applied to single and archive pages.', 'trendy-news' ),
            'choices'   => array(
                'theme_format'  => __( 'Default by theme', 'trendy-news' ),
                'default'   => __( 'Wordpress default date', 'trendy-news' )
            )
        ));

        // preset colors header
        $wp_customize->add_setting( 'preset_colors_heading', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Section_Heading_Control( $wp_customize, 'preset_colors_heading', array(
                'label'	      => esc_html__( 'Theme Presets', 'trendy-news' ),
                'section'     => 'colors',
                'settings'    => 'preset_colors_heading'
            ))
        );

        // primary preset color
        $wp_customize->add_setting( 'preset_color_1', array(
            'default'   => TND\trendy_news_get_customizer_default( 'preset_color_1' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'trendy_news_sanitize_color_picker_control'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Preset_Color_Picker_Control( $wp_customize, 'preset_color_1', array(
                'label'	      => esc_html__( 'Color 1', 'trendy-news' ),
                'section'     => 'colors',
                'settings'    => 'preset_color_1',
                'variable'   => '--tn-global-preset-color-1'
            ))
        );

        // secondary preset color
        $wp_customize->add_setting( 'preset_color_2', array(
            'default'   => TND\trendy_news_get_customizer_default( 'preset_color_2' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'trendy_news_sanitize_color_picker_control'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Preset_Color_Picker_Control( $wp_customize, 'preset_color_2', array(
                'label'	      => esc_html__( 'Color 2', 'trendy-news' ),
                'section'     => 'colors',
                'settings'    => 'preset_color_2',
                'variable'   => '--tn-global-preset-color-2'
            ))
        );

        // tertiary preset color
        $wp_customize->add_setting( 'preset_color_3', array(
            'default'   => TND\trendy_news_get_customizer_default( 'preset_color_3' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'trendy_news_sanitize_color_picker_control'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Preset_Color_Picker_Control( $wp_customize, 'preset_color_3', array(
                'label'	      => esc_html__( 'Color 3', 'trendy-news' ),
                'section'     => 'colors',
                'settings'    => 'preset_color_3',
                'variable'   => '--tn-global-preset-color-3'
            ))
        );

        // primary preset link color
        $wp_customize->add_setting( 'preset_color_4', array(
            'default'   => TND\trendy_news_get_customizer_default( 'preset_color_4' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'trendy_news_sanitize_color_picker_control'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Preset_Color_Picker_Control( $wp_customize, 'preset_color_4', array(
                'label'	      => esc_html__( 'Color 4', 'trendy-news' ),
                'section'     => 'colors',
                'settings'    => 'preset_color_4',
                'variable'   => '--tn-global-preset-color-4'
            ))
        );

        // secondary preset link color
        $wp_customize->add_setting( 'preset_color_5', array(
            'default'   => TND\trendy_news_get_customizer_default( 'preset_color_5' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'trendy_news_sanitize_color_picker_control'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Preset_Color_Picker_Control( $wp_customize, 'preset_color_5', array(
                'label'	      => esc_html__( 'Color 5', 'trendy-news' ),
                'section'     => 'colors',
                'settings'    => 'preset_color_5',
                'variable'   => '--tn-global-preset-color-5'
            ))
        );
        
        // tertiary preset link color
        $wp_customize->add_setting( 'preset_color_6', array(
            'default'   => TND\trendy_news_get_customizer_default( 'preset_color_6' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'trendy_news_sanitize_color_picker_control'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Preset_Color_Picker_Control( $wp_customize, 'preset_color_6', array(
                'label'	      => esc_html__( 'Color 6', 'trendy-news' ),
                'section'     => 'colors',
                'settings'    => 'preset_color_6',
                'variable'   => '--tn-global-preset-color-6'
            ))
        );

        // tertiary preset link color
        $wp_customize->add_setting( 'preset_color_7', array(
            'default'   => TND\trendy_news_get_customizer_default( 'preset_color_7' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'trendy_news_sanitize_color_picker_control'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Preset_Color_Picker_Control( $wp_customize, 'preset_color_7', array(
                'label'       => esc_html__( 'Color 7', 'trendy-news' ),
                'section'     => 'colors',
                'settings'    => 'preset_color_7',
                'variable'   => '--tn-global-preset-color-7'
            ))
        );

        // tertiary preset link color
        $wp_customize->add_setting( 'preset_color_8', array(
            'default'   => TND\trendy_news_get_customizer_default( 'preset_color_8' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'trendy_news_sanitize_color_picker_control'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Preset_Color_Picker_Control( $wp_customize, 'preset_color_8', array(
                'label'       => esc_html__( 'Color 8', 'trendy-news' ),
                'section'     => 'colors',
                'settings'    => 'preset_color_8',
                'variable'   => '--tn-global-preset-color-8'
            ))
        );

        // tertiary preset link color
        $wp_customize->add_setting( 'preset_color_8', array(
            'default'   => TND\trendy_news_get_customizer_default( 'preset_color_8' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'trendy_news_sanitize_color_picker_control'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Preset_Color_Picker_Control( $wp_customize, 'preset_color_8', array(
                'label'       => esc_html__( 'Color 8', 'trendy-news' ),
                'section'     => 'colors',
                'settings'    => 'preset_color_8',
                'variable'   => '--tn-global-preset-color-8'
            ))
        );

        // tertiary preset link color
        $wp_customize->add_setting( 'preset_color_9', array(
            'default'   => TND\trendy_news_get_customizer_default( 'preset_color_9' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'trendy_news_sanitize_color_picker_control'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Preset_Color_Picker_Control( $wp_customize, 'preset_color_9', array(
                'label'       => esc_html__( 'Color 9', 'trendy-news' ),
                'section'     => 'colors',
                'settings'    => 'preset_color_9',
                'variable'   => '--tn-global-preset-color-9'
            ))
        );

        // tertiary preset link color
        $wp_customize->add_setting( 'preset_color_10', array(
            'default'   => TND\trendy_news_get_customizer_default( 'preset_color_10' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'trendy_news_sanitize_color_picker_control'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Preset_Color_Picker_Control( $wp_customize, 'preset_color_10', array(
                'label'       => esc_html__( 'Color 10', 'trendy-news' ),
                'section'     => 'colors',
                'settings'    => 'preset_color_10',
                'variable'   => '--tn-global-preset-color-10'
            ))
        );

        // tertiary preset link color
        $wp_customize->add_setting( 'preset_color_11', array(
            'default'   => TND\trendy_news_get_customizer_default( 'preset_color_11' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'trendy_news_sanitize_color_picker_control'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Preset_Color_Picker_Control( $wp_customize, 'preset_color_11', array(
                'label'       => esc_html__( 'Color 11', 'trendy-news' ),
                'section'     => 'colors',
                'settings'    => 'preset_color_11',
                'variable'   => '--tn-global-preset-color-11'
            ))
        );

        // tertiary preset link color
        $wp_customize->add_setting( 'preset_color_12', array(
            'default'   => TND\trendy_news_get_customizer_default( 'preset_color_12' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'trendy_news_sanitize_color_picker_control'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Preset_Color_Picker_Control( $wp_customize, 'preset_color_12', array(
                'label'       => esc_html__( 'Color 12', 'trendy-news' ),
                'section'     => 'colors',
                'settings'    => 'preset_color_12',
                'variable'   => '--tn-global-preset-color-12'
            ))
        );

        // gradient preset colors header
        $wp_customize->add_setting( 'gradient_preset_colors_heading', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Section_Heading_Control( $wp_customize, 'gradient_preset_colors_heading', array(
                'label'	      => esc_html__( 'Gradient Presets', 'trendy-news' ),
                'section'     => 'colors',
                'settings'    => 'gradient_preset_colors_heading'
            ))
        );

        // gradient color 1
        $wp_customize->add_setting( 'preset_gradient_1', array(
            'default'   => TND\trendy_news_get_customizer_default( 'preset_gradient_1' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Preset_Gradient_Picker_Control( $wp_customize, 'preset_gradient_1', array(
                'label'	      => esc_html__( 'Gradient 1', 'trendy-news' ),
                'section'     => 'colors',
                'settings'    => 'preset_gradient_1',
                'variable'   => '--tn-global-preset-gradient-color-1'
            ))
        );
        
        // gradient color 2
        $wp_customize->add_setting( 'preset_gradient_2', array(
            'default'   => TND\trendy_news_get_customizer_default( 'preset_gradient_2' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Preset_Gradient_Picker_Control( $wp_customize, 'preset_gradient_2', array(
                'label'	      => esc_html__( 'Gradient 2', 'trendy-news' ),
                'section'     => 'colors',
                'settings'    => 'preset_gradient_2',
                'variable'   => '--tn-global-preset-gradient-color-2'
            ))
        );

        // gradient color 3
        $wp_customize->add_setting( 'preset_gradient_3', array(
            'default'   => TND\trendy_news_get_customizer_default( 'preset_gradient_3' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Preset_Gradient_Picker_Control( $wp_customize, 'preset_gradient_3', array(
                'label'	      => esc_html__( 'Gradient 3', 'trendy-news' ),
                'section'     => 'colors',
                'settings'    => 'preset_gradient_3',
                'variable'   => '--tn-global-preset-gradient-color-3'
            ))
        );

        // gradient color 4
        $wp_customize->add_setting( 'preset_gradient_4', array(
            'default'   => TND\trendy_news_get_customizer_default( 'preset_gradient_4' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Preset_Gradient_Picker_Control( $wp_customize, 'preset_gradient_4', array(
                'label'	      => esc_html__( 'Gradient 4', 'trendy-news' ),
                'section'     => 'colors',
                'settings'    => 'preset_gradient_4',
                'variable'   => '--tn-global-preset-gradient-color-4'
            ))
        );

        // gradient color 5
        $wp_customize->add_setting( 'preset_gradient_5', array(
            'default'   => TND\trendy_news_get_customizer_default( 'preset_gradient_5' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Preset_Gradient_Picker_Control( $wp_customize, 'preset_gradient_5', array(
                'label'	      => esc_html__( 'Gradient 5', 'trendy-news' ),
                'section'     => 'colors',
                'settings'    => 'preset_gradient_5',
                'variable'   => '--tn-global-preset-gradient-color-5'
            ))
        );

        // gradient color 6
        $wp_customize->add_setting( 'preset_gradient_6', array(
            'default'   => TND\trendy_news_get_customizer_default( 'preset_gradient_6' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Preset_Gradient_Picker_Control( $wp_customize, 'preset_gradient_6', array(
                'label'	      => esc_html__( 'Gradient 6', 'trendy-news' ),
                'section'     => 'colors',
                'settings'    => 'preset_gradient_6',
                'variable'   => '--tn-global-preset-gradient-color-6'
            ))
        );

        // gradient color 7
        $wp_customize->add_setting( 'preset_gradient_7', array(
            'default'   => TND\trendy_news_get_customizer_default( 'preset_gradient_7' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Preset_Gradient_Picker_Control( $wp_customize, 'preset_gradient_7', array(
                'label'       => esc_html__( 'Gradient 7', 'trendy-news' ),
                'section'     => 'colors',
                'settings'    => 'preset_gradient_7',
                'variable'   => '--tn-global-preset-gradient-color-7'
            ))
        );

        // gradient color 8
        $wp_customize->add_setting( 'preset_gradient_8', array(
            'default'   => TND\trendy_news_get_customizer_default( 'preset_gradient_8' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Preset_Gradient_Picker_Control( $wp_customize, 'preset_gradient_8', array(
                'label'       => esc_html__( 'Gradient 8', 'trendy-news' ),
                'section'     => 'colors',
                'settings'    => 'preset_gradient_8',
                'variable'   => '--tn-global-preset-gradient-color-8'
            ))
        );

        // gradient color 9
        $wp_customize->add_setting( 'preset_gradient_9', array(
            'default'   => TND\trendy_news_get_customizer_default( 'preset_gradient_9' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Preset_Gradient_Picker_Control( $wp_customize, 'preset_gradient_9', array(
                'label'       => esc_html__( 'Gradient 9', 'trendy-news' ),
                'section'     => 'colors',
                'settings'    => 'preset_gradient_9',
                'variable'   => '--tn-global-preset-gradient-color-9'
            ))
        );

        // gradient color 10
        $wp_customize->add_setting( 'preset_gradient_10', array(
            'default'   => TND\trendy_news_get_customizer_default( 'preset_gradient_10' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Preset_Gradient_Picker_Control( $wp_customize, 'preset_gradient_10', array(
                'label'       => esc_html__( 'Gradient 10', 'trendy-news' ),
                'section'     => 'colors',
                'settings'    => 'preset_gradient_10',
                'variable'   => '--tn-global-preset-gradient-color-10'
            ))
        );

        // gradient color 11
        $wp_customize->add_setting( 'preset_gradient_11', array(
            'default'   => TND\trendy_news_get_customizer_default( 'preset_gradient_11' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Preset_Gradient_Picker_Control( $wp_customize, 'preset_gradient_11', array(
                'label'       => esc_html__( 'Gradient 11', 'trendy-news' ),
                'section'     => 'colors',
                'settings'    => 'preset_gradient_11',
                'variable'   => '--tn-global-preset-gradient-color-11'
            ))
        );

        // gradient color 12
        $wp_customize->add_setting( 'preset_gradient_12', array(
            'default'   => TND\trendy_news_get_customizer_default( 'preset_gradient_12' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Preset_Gradient_Picker_Control( $wp_customize, 'preset_gradient_12', array(
                'label'       => esc_html__( 'Gradient 12', 'trendy-news' ),
                'section'     => 'colors',
                'settings'    => 'preset_gradient_12',
                'variable'   => '--tn-global-preset-gradient-color-12'
            ))
        );

        // section- category colors section
        $wp_customize->add_section( 'trendy_news_category_colors_section', array(
            'title' => esc_html__( 'Category Colors', 'trendy-news' ),
            'priority'  => 40
        ));

        $totalCats = get_categories();
        if( $totalCats ) :
            foreach( $totalCats as $singleCat ) :
                // category colors control
                $wp_customize->add_setting( 'category_' .absint($singleCat->term_id). '_color', array(
                    'default'   => TND\trendy_news_get_customizer_default('category_' .absint($singleCat->term_id). '_color'),
                    'sanitize_callback' => 'trendy_news_sanitize_color_picker_control'
                ));
                $wp_customize->add_control(
                    new Trendy_News_WP_Color_Picker_Control( $wp_customize, 'category_' .absint($singleCat->term_id). '_color', array(
                        'label'     => esc_html($singleCat->name),
                        'section'   => 'trendy_news_category_colors_section',
                        'settings'  => 'category_' .absint($singleCat->term_id). '_color'
                    ))
                );
            endforeach;
        endif;
        
        // section- preloader section
        $wp_customize->add_section( 'trendy_news_preloader_section', array(
            'title' => esc_html__( 'Preloader', 'trendy-news' ),
            'panel' => 'trendy_news_global_panel'
        ));

        // preloader option
        $wp_customize->add_setting( 'preloader_option', array(
            'default'   => TND\trendy_news_get_customizer_default('preloader_option'),
            'sanitize_callback' => 'trendy_news_sanitize_toggle_control'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Simple_Toggle_Control( $wp_customize, 'preloader_option', array(
                'label'	      => esc_html__( 'Enable site preloader', 'trendy-news' ),
                'section'     => 'trendy_news_preloader_section',
                'settings'    => 'preloader_option'
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'preloader_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Info_Box_Control( $wp_customize, 'preloader_upgrade_info', array(
                'label'	      => esc_html__( '20 + Preloader', 'trendy-news' ),
                'description' => esc_html__( 'Dedicated technical support.', 'trendy-news' ),
                'section'     => TRENDY_NEWS_PREFIX . 'preloader_section',
                'settings'    => 'preloader_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'trendy-news' ),
                        'url'   => esc_url( '//blazethemes.com/theme/trendy-news-pro/' )
                    )
                )
            ))
        );
        
        // section- website layout section
        $wp_customize->add_section( 'trendy_news_website_layout_section', array(
            'title' => esc_html__( 'Website Layout', 'trendy-news' ),
            'panel' => 'trendy_news_global_panel'
        ));
        
        // website layout heading
        $wp_customize->add_setting( 'website_layout_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Section_Heading_Control( $wp_customize, 'website_layout_header', array(
                'label'	      => esc_html__( 'Website Layout', 'trendy-news' ),
                'section'     => 'trendy_news_website_layout_section',
                'settings'    => 'website_layout_header'
            ))
        );

        // website layout
        $wp_customize->add_setting( 'website_layout',
            array(
            'default'           => TND\trendy_news_get_customizer_default( 'website_layout' ),
            'sanitize_callback' => 'trendy_news_sanitize_select_control',
            )
        );
        $wp_customize->add_control( 
            new Trendy_News_WP_Radio_Image_Control( $wp_customize, 'website_layout',
            array(
                'section'  => 'trendy_news_website_layout_section',
                'choices'  => array(
                    'boxed--layout' => array(
                        'label' => esc_html__( 'Boxed', 'trendy-news' ),
                        'url'   => '%s/assets/images/customizer/boxed-width.jpg'
                    ),
                    'full-width--layout' => array(
                        'label' => esc_html__( 'Full Width', 'trendy-news' ),
                        'url'   => '%s/assets/images/customizer/full-width.jpg'
                    )
                )
            )
        ));

        // Block top border style
        $wp_customize->add_setting( 'website_block_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Section_Heading_Control( $wp_customize, 'website_block_header', array(
                'label'	      => esc_html__( 'Block Top Border Style', 'trendy-news' ),
                'section'     => 'trendy_news_website_layout_section',
                'settings'    => 'website_block_header'
            ))
        );

        // website block top border
        $wp_customize->add_setting( 'website_block_border_top_option', array(
            'default'   => TND\trendy_news_get_customizer_default('website_block_border_top_option'),
            'sanitize_callback' => 'trendy_news_sanitize_toggle_control',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Simple_Toggle_Control( $wp_customize, 'website_block_border_top_option', array(
                'label'	      => esc_html__( 'Website block top border', 'trendy-news' ),
                'section'     => 'trendy_news_website_layout_section',
                'settings'    => 'website_block_border_top_option'
            ))
        );

        // border color
        $wp_customize->add_setting( 'website_block_border_top_color', array(
            'default'   => TND\trendy_news_get_customizer_default( 'website_block_border_top_color' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Color_Group_Control( $wp_customize, 'website_block_border_top_color', array(
                'label'	      => esc_html__( 'Border Color', 'trendy-news' ),
                'section'     => 'trendy_news_website_layout_section',
                'settings'    => 'website_block_border_top_color'
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'website_layout_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Info_Box_Control( $wp_customize, 'website_layout_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'trendy-news' ),
                'description' => esc_html__( 'Block border top width, website frame width, color and dedicated technical support.', 'trendy-news' ),
                'section'     => TRENDY_NEWS_PREFIX . 'website_layout_section',
                'settings'    => 'website_layout_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'trendy-news' ),
                        'url'   => esc_url( '//blazethemes.com/theme/trendy-news-pro/' )
                    )
                )
            ))
        );

        // section- animation section
        $wp_customize->add_section( 'trendy_news_animation_section', array(
            'title' => esc_html__( 'Animation / Hover Effects', 'trendy-news' ),
            'panel' => 'trendy_news_global_panel'
        ));
        
        // post title animation effects 
        $wp_customize->add_setting( 'post_title_hover_effects', array(
            'sanitize_callback' => 'trendy_news_sanitize_select_control',
            'default'   => TND\trendy_news_get_customizer_default( 'post_title_hover_effects' ),
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 'post_title_hover_effects', array(
            'type'      => 'select',
            'section'   => 'trendy_news_animation_section',
            'label'     => esc_html__( 'Post title hover effects', 'trendy-news' ),
            'description' => esc_html__( 'Applied to post titles listed in archive pages.', 'trendy-news' ),
            'choices'   => array(
                'none' => esc_html__( 'None', 'trendy-news' ),
                'one'  => esc_html__( 'Effect One', 'trendy-news' )
            )
        ));

        // site image animation effects 
        $wp_customize->add_setting( 'site_image_hover_effects', array(
            'sanitize_callback' => 'trendy_news_sanitize_select_control',
            'default'   => TND\trendy_news_get_customizer_default( 'site_image_hover_effects' ),
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 'site_image_hover_effects', array(
            'type'      => 'select',
            'section'   => 'trendy_news_animation_section',
            'label'     => esc_html__( 'Image hover effects', 'trendy-news' ),
            'description' => esc_html__( 'Applied to post thumbanails listed in archive pages.', 'trendy-news' ),
            'choices'   => array(
                'none' => __( 'None', 'trendy-news' ),
                'one'  => __( 'Effect One', 'trendy-news' )
            )
        ));

        // upgrade info box
        $wp_customize->add_setting( 'website_animations_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Info_Box_Control( $wp_customize, 'website_animations_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'trendy-news' ),
                'description' => esc_html__( 'For more hover effects', 'trendy-news' ),
                'section'     => TRENDY_NEWS_PREFIX . 'animation_section',
                'settings'    => 'website_animations_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'trendy-news' ),
                        'url'   => esc_url( '//blazethemes.com/theme/trendy-news-pro/' )
                    )
                )
            ))
        );

        // section- social icons section
        $wp_customize->add_section( 'trendy_news_social_icons_section', array(
            'title' => esc_html__( 'Social Icons', 'trendy-news' ),
            'panel' => 'trendy_news_global_panel'
        ));
        
        // social icons setting heading
        $wp_customize->add_setting( 'social_icons_settings_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Section_Heading_Control( $wp_customize, 'social_icons_settings_header', array(
                'label'	      => esc_html__( 'Social Icons Settings', 'trendy-news' ),
                'section'     => 'trendy_news_social_icons_section',
                'settings'    => 'social_icons_settings_header'
            ))
        );

        // social icons target attribute value
        $wp_customize->add_setting( 'social_icons_target', array(
            'sanitize_callback' => 'trendy_news_sanitize_select_control',
            'default'   => TND\trendy_news_get_customizer_default( 'social_icons_target' ),
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 'social_icons_target', array(
            'type'      => 'select',
            'section'   => 'trendy_news_social_icons_section',
            'label'     => esc_html__( 'Social Icon Link Open in', 'trendy-news' ),
            'description' => esc_html__( 'Sets the target attribute according to the value.', 'trendy-news' ),
            'choices'   => array(
                '_blank' => __( 'Open link in new tab', 'trendy-news' ),
                '_self'  => __( 'Open link in same tab', 'trendy-news' )
            )
        ));

        // social icons items
        $wp_customize->add_setting( 'social_icons', array(
            'default'   => TND\trendy_news_get_customizer_default( 'social_icons' ),
            'sanitize_callback' => 'trendy_news_sanitize_repeater_control',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control(
            new Trendy_News_WP_Custom_Repeater( $wp_customize, 'social_icons', array(
                'label'         => esc_html__( 'Social Icons', 'trendy-news' ),
                'description'   => esc_html__( 'Hold bar icon and drag vertically to re-order the icons', 'trendy-news' ),
                'section'       => 'trendy_news_social_icons_section',
                'settings'      => 'social_icons',
                'row_label'     => 'inherit-icon_class',
                'add_new_label' => esc_html__( 'Add New Icon', 'trendy-news' ),
                'fields'        => array(
                    'icon_class'   => array(
                        'type'          => 'fontawesome-icon-picker',
                        'label'         => esc_html__( 'Social Icon', 'trendy-news' ),
                        'description'   => esc_html__( 'Select from dropdown.', 'trendy-news' ),
                        'default'       => esc_attr( 'fab fa-instagram' )

                    ),
                    'icon_url'  => array(
                        'type'      => 'url',
                        'label'     => esc_html__( 'URL for icon', 'trendy-news' ),
                        'default'   => ''
                    ),
                    'item_option'             => 'show'
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'social_icons_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Info_Box_Control( $wp_customize, 'social_icons_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'trendy-news' ),
                'description' => esc_html__( 'Unlimited social icons items with unlimited choices', 'trendy-news' ),
                'section'     => TRENDY_NEWS_PREFIX . 'social_icons_section',
                'settings'    => 'social_icons_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'trendy-news' ),
                        'url'   => esc_url( '//blazethemes.com/theme/trendy-news-pro/' )
                    )
                )
            ))
        );
        
        // section- sidebar options section
        $wp_customize->add_section( 'trendy_news_sidebar_options_section', array(
            'title' => esc_html__( 'Sidebar Options', 'trendy-news' ),
            'panel' => 'trendy_news_global_panel'
        ));

        // frontpage sidebar layout heading
        $wp_customize->add_setting( 'frontpage_sidebar_layout_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Section_Heading_Control( $wp_customize, 'frontpage_sidebar_layout_header', array(
                'label'	      => esc_html__( 'Frontpage Sidebar Layouts', 'trendy-news' ),
                'section'     => 'trendy_news_sidebar_options_section',
                'settings'    => 'frontpage_sidebar_layout_header'
            ))
        );

        // frontpage sidebar layout
        $wp_customize->add_setting( 'frontpage_sidebar_layout',
            array(
            'default'           => TND\trendy_news_get_customizer_default( 'frontpage_sidebar_layout' ),
            'sanitize_callback' => 'trendy_news_sanitize_select_control',
            )
        );
        $wp_customize->add_control( 
            new Trendy_News_WP_Radio_Image_Control( $wp_customize, 'frontpage_sidebar_layout',
            array(
                'section'  => 'trendy_news_sidebar_options_section',
                'choices'  => array(
                    'no-sidebar' => array(
                        'label' => esc_html__( 'No Sidebar', 'trendy-news' ),
                        'url'   => '%s/assets/images/customizer/no_sidebar.jpg'
                    ),
                    'left-sidebar' => array(
                        'label' => esc_html__( 'Left Sidebar', 'trendy-news' ),
                        'url'   => '%s/assets/images/customizer/left_sidebar.jpg'
                    ),
                    'right-sidebar' => array(
                        'label' => esc_html__( 'Right Sidebar', 'trendy-news' ),
                        'url'   => '%s/assets/images/customizer/right_sidebar.jpg'
                    ),
                    'both-sidebar' => array(
                        'label' => esc_html__( 'Both Sidebar', 'trendy-news' ),
                        'url'   => '%s/assets/images/customizer/both_sidebar.jpg'
                    )
                )
            )
        ));

        // frontpage sidebar sticky option
        $wp_customize->add_setting( 'frontpage_sidebar_sticky_option', array(
            'default'   => TND\trendy_news_get_customizer_default( 'frontpage_sidebar_sticky_option' ),
            'sanitize_callback' => 'trendy_news_sanitize_toggle_control',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Simple_Toggle_Control( $wp_customize, 'frontpage_sidebar_sticky_option', array(
                'label'	      => esc_html__( 'Enable sidebar sticky', 'trendy-news' ),
                'section'     => 'trendy_news_sidebar_options_section',
                'settings'    => 'frontpage_sidebar_sticky_option'
            ))
        );

        // archive sidebar layouts heading
        $wp_customize->add_setting( 'archive_sidebar_layout_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Section_Heading_Control( $wp_customize, 'archive_sidebar_layout_header', array(
                'label'	      => esc_html__( 'Archive/Blog Sidebar Layouts', 'trendy-news' ),
                'section'     => 'trendy_news_sidebar_options_section',
                'settings'    => 'archive_sidebar_layout_header'
            ))
        );

        // archive sidebar layout
        $wp_customize->add_setting( 'archive_sidebar_layout',
            array(
            'default'           => TND\trendy_news_get_customizer_default( 'archive_sidebar_layout' ),
            'sanitize_callback' => 'trendy_news_sanitize_select_control',
            )
        );
        $wp_customize->add_control( 
            new Trendy_News_WP_Radio_Image_Control( $wp_customize, 'archive_sidebar_layout',
            array(
                'section'  => 'trendy_news_sidebar_options_section',
                'choices'  => array(
                    'no-sidebar' => array(
                        'label' => esc_html__( 'No Sidebar', 'trendy-news' ),
                        'url'   => '%s/assets/images/customizer/no_sidebar.jpg'
                    ),
                    'left-sidebar' => array(
                        'label' => esc_html__( 'Left Sidebar', 'trendy-news' ),
                        'url'   => '%s/assets/images/customizer/left_sidebar.jpg'
                    ),
                    'right-sidebar' => array(
                        'label' => esc_html__( 'Right Sidebar', 'trendy-news' ),
                        'url'   => '%s/assets/images/customizer/right_sidebar.jpg'
                    ),
                    'both-sidebar' => array(
                        'label' => esc_html__( 'Both Sidebar', 'trendy-news' ),
                        'url'   => '%s/assets/images/customizer/both_sidebar.jpg'
                    )
                )
            )
        ));

        // archive sidebar sticky option
        $wp_customize->add_setting( 'archive_sidebar_sticky_option', array(
            'default'   => TND\trendy_news_get_customizer_default( 'archive_sidebar_sticky_option' ),
            'sanitize_callback' => 'trendy_news_sanitize_toggle_control',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Simple_Toggle_Control( $wp_customize, 'archive_sidebar_sticky_option', array(
                'label'	      => esc_html__( 'Enable sidebar sticky', 'trendy-news' ),
                'section'     => 'trendy_news_sidebar_options_section',
                'settings'    => 'archive_sidebar_sticky_option'
            ))
        );

        // single sidebar layouts heading
        $wp_customize->add_setting( 'single_sidebar_layout_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Section_Heading_Control( $wp_customize, 'single_sidebar_layout_header', array(
                'label'	      => esc_html__( 'Post Sidebar Layouts', 'trendy-news' ),
                'section'     => 'trendy_news_sidebar_options_section',
                'settings'    => 'single_sidebar_layout_header'
            ))
        );

        // single sidebar layout
        $wp_customize->add_setting( 'single_sidebar_layout',
            array(
            'default'           => TND\trendy_news_get_customizer_default( 'single_sidebar_layout' ),
            'sanitize_callback' => 'trendy_news_sanitize_select_control',
            )
        );
        $wp_customize->add_control( 
            new Trendy_News_WP_Radio_Image_Control( $wp_customize, 'single_sidebar_layout',
            array(
                'section'  => 'trendy_news_sidebar_options_section',
                'choices'  => array(
                    'no-sidebar' => array(
                        'label' => esc_html__( 'No Sidebar', 'trendy-news' ),
                        'url'   => '%s/assets/images/customizer/no_sidebar.jpg'
                    ),
                    'left-sidebar' => array(
                        'label' => esc_html__( 'Left Sidebar', 'trendy-news' ),
                        'url'   => '%s/assets/images/customizer/left_sidebar.jpg'
                    ),
                    'right-sidebar' => array(
                        'label' => esc_html__( 'Right Sidebar', 'trendy-news' ),
                        'url'   => '%s/assets/images/customizer/right_sidebar.jpg'
                    ),
                    'both-sidebar' => array(
                        'label' => esc_html__( 'Both Sidebar', 'trendy-news' ),
                        'url'   => '%s/assets/images/customizer/both_sidebar.jpg'
                    )
                )
            )
        ));

        // single sidebar sticky option
        $wp_customize->add_setting( 'single_sidebar_sticky_option', array(
            'default'   => TND\trendy_news_get_customizer_default( 'single_sidebar_sticky_option' ),
            'sanitize_callback' => 'trendy_news_sanitize_toggle_control',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Simple_Toggle_Control( $wp_customize, 'single_sidebar_sticky_option', array(
                'label'	      => esc_html__( 'Enable sidebar sticky', 'trendy-news' ),
                'section'     => 'trendy_news_sidebar_options_section',
                'settings'    => 'single_sidebar_sticky_option'
            ))
        );

        // page sidebar layouts heading
        $wp_customize->add_setting( 'page_sidebar_layout_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Section_Heading_Control( $wp_customize, 'page_sidebar_layout_header', array(
                'label'	      => esc_html__( 'Page Sidebar Layouts', 'trendy-news' ),
                'section'     => 'trendy_news_sidebar_options_section',
                'settings'    => 'page_sidebar_layout_header'
            ))
        );

        // page sidebar layout
        $wp_customize->add_setting( 'page_sidebar_layout',
            array(
            'default'           => TND\trendy_news_get_customizer_default( 'page_sidebar_layout' ),
            'sanitize_callback' => 'trendy_news_sanitize_select_control',
            )
        );
        $wp_customize->add_control( 
            new Trendy_News_WP_Radio_Image_Control( $wp_customize, 'page_sidebar_layout',
            array(
                'section'  => 'trendy_news_sidebar_options_section',
                'choices'  => array(
                    'no-sidebar' => array(
                        'label' => esc_html__( 'No Sidebar', 'trendy-news' ),
                        'url'   => '%s/assets/images/customizer/no_sidebar.jpg'
                    ),
                    'left-sidebar' => array(
                        'label' => esc_html__( 'Left Sidebar', 'trendy-news' ),
                        'url'   => '%s/assets/images/customizer/left_sidebar.jpg'
                    ),
                    'right-sidebar' => array(
                        'label' => esc_html__( 'Right Sidebar', 'trendy-news' ),
                        'url'   => '%s/assets/images/customizer/right_sidebar.jpg'
                    ),
                    'both-sidebar' => array(
                        'label' => esc_html__( 'Both Sidebar', 'trendy-news' ),
                        'url'   => '%s/assets/images/customizer/both_sidebar.jpg'
                    )
                )
            )
        ));

        // page sidebar sticky option
        $wp_customize->add_setting( 'page_sidebar_sticky_option', array(
            'default'   => TND\trendy_news_get_customizer_default( 'page_sidebar_sticky_option' ),
            'sanitize_callback' => 'trendy_news_sanitize_toggle_control',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Simple_Toggle_Control( $wp_customize, 'page_sidebar_sticky_option', array(
                'label'	      => esc_html__( 'Enable sidebar sticky', 'trendy-news' ),
                'section'     => 'trendy_news_sidebar_options_section',
                'settings'    => 'page_sidebar_sticky_option'
            ))
        );

        // section- breadcrumb options section
        $wp_customize->add_section( 'trendy_news_breadcrumb_options_section', array(
            'title' => esc_html__( 'Breadcrumb Options', 'trendy-news' ),
            'panel' => 'trendy_news_global_panel'
        ));

        // breadcrumb option
        $wp_customize->add_setting( 'site_breadcrumb_option', array(
            'default'   => TND\trendy_news_get_customizer_default( 'site_breadcrumb_option' ),
            'sanitize_callback' => 'trendy_news_sanitize_toggle_control'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Simple_Toggle_Control( $wp_customize, 'site_breadcrumb_option', array(
                'label'	      => esc_html__( 'Show breadcrumb trails', 'trendy-news' ),
                'section'     => 'trendy_news_breadcrumb_options_section',
                'settings'    => 'site_breadcrumb_option'
            ))
        );

        // breadcrumb type 
        $wp_customize->add_setting( 'site_breadcrumb_type', array(
            'sanitize_callback' => 'trendy_news_sanitize_select_control',
            'default'   => TND\trendy_news_get_customizer_default( 'site_breadcrumb_type' )
        ));
        $wp_customize->add_control( 'site_breadcrumb_type', array(
            'type'      => 'select',
            'section'   => 'trendy_news_breadcrumb_options_section',
            'label'     => esc_html__( 'Breadcrumb type', 'trendy-news' ),
            'description' => esc_html__( 'If you use other than "default" one you will need to install and activate respective plugins Breadcrumb NavXT, Yoast SEO and Rank Math SEO', 'trendy-news' ),
            'choices'   => array(
                'default' => __( 'Default', 'trendy-news' ),
                'bcn'  => __( 'NavXT', 'trendy-news' ),
                'yoast'  => __( 'Yoast SEO', 'trendy-news' ),
                'rankmath'  => __( 'Rank Math', 'trendy-news' )
            )
        ));
        
        // upgrade info box
        $wp_customize->add_setting( 'breadcrumb_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Info_Box_Control( $wp_customize, 'breadcrumb_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'trendy-news' ),
                'description' => esc_html__( 'Place breadcrumb inside or outside container choices.', 'trendy-news' ),
                'section'     => TRENDY_NEWS_PREFIX . 'breadcrumb_options_section',
                'settings'    => 'breadcrumb_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'trendy-news' ),
                        'url'   => esc_url( '//blazethemes.com/theme/trendy-news-pro/' )
                    )
                )
            ))
        );

        // section- scroll to top options
        $wp_customize->add_section( 'trendy_news_stt_options_section', array(
            'title' => esc_html__( 'Scroll To Top', 'trendy-news' ),
            'panel' => 'trendy_news_global_panel'
        ));

        // scroll to top section tab
        $wp_customize->add_setting( 'stt_section_tab', array(
            'sanitize_callback' => 'sanitize_text_field',
            'default'   => 'general'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Section_Tab_Control( $wp_customize, 'stt_section_tab', array(
                'section'     => 'trendy_news_stt_options_section',
                'choices'  => array(
                    array(
                        'name'  => 'general',
                        'title'  => esc_html__( 'General', 'trendy-news' )
                    ),
                    array(
                        'name'  => 'design',
                        'title'  => esc_html__( 'Design', 'trendy-news' )
                    )
                )
            ))
        );

        // Resposive vivibility option
        $wp_customize->add_setting( 'stt_responsive_option', array(
            'default' => TND\trendy_news_get_customizer_default( 'stt_responsive_option' ),
            'sanitize_callback' => 'trendy_news_sanitize_responsive_multiselect_control',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Responsive_Multiselect_Tab_Control( $wp_customize, 'stt_responsive_option', array(
                'label'	      => esc_html__( 'Scroll To Top Visibility', 'trendy-news' ),
                'section'     => 'trendy_news_stt_options_section',
                'settings'    => 'stt_responsive_option'
            ))
        );

        // stt font size
        $wp_customize->add_setting( 'stt_font_size', array(
            'default'   => TND\trendy_news_get_customizer_default( 'stt_font_size' ),
            'sanitize_callback' => 'trendy_news_sanitize_responsive_range',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control(
            new Trendy_News_WP_Responsive_Range_Control( $wp_customize, 'stt_font_size', array(
                    'label'	      => esc_html__( 'Font size (px)', 'trendy-news' ),
                    'section'     => 'trendy_news_stt_options_section',
                    'settings'    => 'stt_font_size',
                    'unit'        => 'px',
                    'input_attrs' => array(
                    'max'         => 200,
                    'min'         => 1,
                    'step'        => 1,
                    'reset' => true
                )
            ))
        );

        // archive pagination type
        $wp_customize->add_setting( 'stt_alignment', array(
            'default' => TND\trendy_news_get_customizer_default( 'stt_alignment' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Radio_Tab_Control( $wp_customize, 'stt_alignment', array(
                'label'	      => esc_html__( 'Button Align', 'trendy-news' ),
                'section'     => 'trendy_news_stt_options_section',
                'settings'    => 'stt_alignment',
                'choices' => array(
                    array(
                        'value' => 'left',
                        'label' => esc_html__('Left', 'trendy-news' )
                    ),
                    array(
                        'value' => 'center',
                        'label' => esc_html__('Center', 'trendy-news' )
                    ),
                    array(
                        'value' => 'right',
                        'label' => esc_html__('Right', 'trendy-news' )
                    )
                )
            ))
        );

        // stt border
        $wp_customize->add_setting( 'stt_border', array( 
            'default' => TND\trendy_news_get_customizer_default( 'stt_border' ),
            'sanitize_callback' => 'trendy_news_sanitize_array',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Border_Control( $wp_customize, 'stt_border', array(
                'label'       => esc_html__( 'Border', 'trendy-news' ),
                'section'     => 'trendy_news_stt_options_section',
                'settings'    => 'stt_border',
                'tab'   => 'design'
            ))
        );
        
        // stt padding
        $wp_customize->add_setting( 'stt_padding', array( 
            'default' => TND\trendy_news_get_customizer_default( 'stt_padding' ),
            'sanitize_callback' => 'trendy_news_sanitize_box_control',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Responsive_Box_Control( $wp_customize, 'stt_padding', array(
                'label'       => esc_html__( 'Padding', 'trendy-news' ),
                'section'     => 'trendy_news_stt_options_section',
                'settings'    => 'stt_padding',
                'tab'   => 'design'
            ))
        );

        // stt label color
        $wp_customize->add_setting( 'stt_color_group', array(
            'default'   => TND\trendy_news_get_customizer_default( 'stt_color_group' ),
            'sanitize_callback' => 'trendy_news_sanitize_color_group_picker_control',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control(
            new Trendy_News_WP_Color_Group_Picker_Control( $wp_customize, 'stt_color_group', array(
                'label'     => esc_html__( 'Icon Color', 'trendy-news' ),
                'section'   => 'trendy_news_stt_options_section',
                'settings'  => 'stt_color_group',
                'tab'   => 'design'
            ))
        );

        // breadcrumb link color
        $wp_customize->add_setting( 'stt_background_color_group', array(
            'default'   => TND\trendy_news_get_customizer_default( 'stt_background_color_group' ),
            'sanitize_callback' => 'trendy_news_sanitize_color_group_picker_control',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control(
            new Trendy_News_WP_Color_Group_Picker_Control( $wp_customize, 'stt_background_color_group', array(
                'label'     => esc_html__( 'Background', 'trendy-news' ),
                'section'   => 'trendy_news_stt_options_section',
                'settings'  => 'stt_background_color_group',
                'tab'   => 'design'
            ))
        );
    }
    add_action( 'customize_register', 'trendy_news_customizer_global_panel', 10 );
endif;

if( !function_exists( 'trendy_news_customizer_site_identity_panel' ) ) :
    /**
     * Register site identity settings
     * 
     */
    function trendy_news_customizer_site_identity_panel( $wp_customize ) {
        /**
         * Register "Site Identity Options" panel
         * 
         */
        $wp_customize->add_panel( 'trendy_news_site_identity_panel', array(
            'title' => esc_html__( 'Site Identity', 'trendy-news' ),
            'priority' => 5
        ));
        $wp_customize->get_section( 'title_tagline' )->panel = 'trendy_news_site_identity_panel'; // assing title tagline section to site identity panel
        $wp_customize->get_section( 'title_tagline' )->title = esc_html__( 'Logo & Site Icon', 'trendy-news' ); // modify site logo label

        /**
         * Site Title Section
         * 
         * panel - trendy_news_site_identity_panel
         */
        $wp_customize->add_section( 'trendy_news_site_title_section', array(
            'title' => esc_html__( 'Site Title & Tagline', 'trendy-news' ),
            'panel' => 'trendy_news_site_identity_panel',
            'priority'  => 30,
        ));
        $wp_customize->get_control( 'blogname' )->section = 'trendy_news_site_title_section';
        $wp_customize->get_control( 'display_header_text' )->section = 'trendy_news_site_title_section';
        $wp_customize->get_control( 'display_header_text' )->label = esc_html__( 'Display site title', 'trendy-news' );
        $wp_customize->get_control( 'blogdescription' )->section = 'trendy_news_site_title_section';
        
        // site logo width
        $wp_customize->add_setting( 'trendy_news_site_logo_width', array(
            'default'   => TND\trendy_news_get_customizer_default( 'trendy_news_site_logo_width' ),
            'sanitize_callback' => 'trendy_news_sanitize_responsive_range',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control(
            new Trendy_News_WP_Responsive_Range_Control( $wp_customize, 'trendy_news_site_logo_width', array(
                    'label'	      => esc_html__( 'Logo Width (px)', 'trendy-news' ),
                    'section'     => 'title_tagline',
                    'settings'    => 'trendy_news_site_logo_width',
                    'unit'        => 'px',
                    'input_attrs' => array(
                    'max'         => 400,
                    'min'         => 1,
                    'step'        => 1,
                    'reset' => true
                )
            ))
        );

        // site title section tab
        $wp_customize->add_setting( 'site_title_section_tab', array(
            'sanitize_callback' => 'sanitize_text_field',
            'default'   => 'general'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Section_Tab_Control( $wp_customize, 'site_title_section_tab', array(
                'section'     => 'trendy_news_site_title_section',
                'priority'  => 1,
                'choices'  => array(
                    array(
                        'name'  => 'general',
                        'title'  => esc_html__( 'General', 'trendy-news' )
                    ),
                    array(
                        'name'  => 'design',
                        'title'  => esc_html__( 'Design', 'trendy-news' )
                    )
                )
            ))
        );

        // blog description option
        $wp_customize->add_setting( 'blogdescription_option', array(
            'default'        => true,
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 'blogdescription_option', array(
            'label'    => esc_html__( 'Display site description', 'trendy-news' ),
            'section'  => 'trendy_news_site_title_section',
            'type'     => 'checkbox',
            'priority' => 50
        ));

        $wp_customize->get_control( 'header_textcolor' )->section = 'trendy_news_site_title_section';
        $wp_customize->get_control( 'header_textcolor' )->priority = 60;
        $wp_customize->get_control( 'header_textcolor' )->label = esc_html__( 'Site Title Color', 'trendy-news' );

        // header text hover color
        $wp_customize->add_setting( 'site_title_hover_textcolor', array(
            'default' => TND\trendy_news_get_customizer_default( 'site_title_hover_textcolor' ),
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Default_Color_Control( $wp_customize, 'site_title_hover_textcolor', array(
                'label'      => esc_html__( 'Site Title Hover Color', 'trendy-news' ),
                'section'    => 'trendy_news_site_title_section',
                'settings'   => 'site_title_hover_textcolor',
                'priority'    => 70,
                'tab'   => 'design'
            ))
        );

        // site description color
        $wp_customize->add_setting( 'site_description_color', array(
            'default' => TND\trendy_news_get_customizer_default( 'site_description_color' ),
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Default_Color_Control( $wp_customize, 'site_description_color', array(
                'label'      => esc_html__( 'Site Description Color', 'trendy-news' ),
                'section'    => 'trendy_news_site_title_section',
                'settings'   => 'site_description_color',
                'priority'    => 70,
                'tab'   => 'design'
            ))
        );

        // site title typo
        $wp_customize->add_setting( 'site_title_typo', array(
            'default'   => TND\trendy_news_get_customizer_default( 'site_title_typo' ),
            'sanitize_callback' => 'trendy_news_sanitize_typo_control',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Typography_Control( $wp_customize, 'site_title_typo', array(
                'label'	      => esc_html__( 'Site Title Typography', 'trendy-news' ),
                'section'     => 'trendy_news_site_title_section',
                'settings'    => 'site_title_typo',
                'tab'   => 'design',
                'fields'    => array( 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration')
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'site_title_typo_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Info_Box_Control( $wp_customize, 'site_title_typo_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'trendy-news' ),
                'description' => esc_html__( '600+ google font families.', 'trendy-news' ),
                'section'     => TRENDY_NEWS_PREFIX . 'site_title_section',
                'settings'    => 'site_title_typo_upgrade_info',
                'priority'  => 100,
                'tab'   => 'design',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'trendy-news' ),
                        'url'   => esc_url( '//blazethemes.com/theme/trendy-news-pro/' )
                    )
                )
            ))
        );
    }
    add_action( 'customize_register', 'trendy_news_customizer_site_identity_panel', 10 );
endif;

if( !function_exists( 'trendy_news_customizer_top_header_panel' ) ) :
    /**
     * Register header options settings
     * 
     */
    function trendy_news_customizer_top_header_panel( $wp_customize ) {
        /**
         * Top header section
         * 
         */
        $wp_customize->add_section( 'trendy_news_top_header_section', array(
            'title' => esc_html__( 'Top Header', 'trendy-news' ),
            'priority'  => 68
        ));
        
        // section tab
        $wp_customize->add_setting( 'top_header_section_tab', array(
            'sanitize_callback' => 'sanitize_text_field',
            'default'   => 'general'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Section_Tab_Control( $wp_customize, 'top_header_section_tab', array(
                'section'     => 'trendy_news_top_header_section',
                'choices'  => array(
                    array(
                        'name'  => 'general',
                        'title'  => esc_html__( 'General', 'trendy-news' )
                    ),
                    array(
                        'name'  => 'design',
                        'title'  => esc_html__( 'Design', 'trendy-news' )
                    )
                )
            ))
        );
        
        // Top header option
        $wp_customize->add_setting( 'top_header_option', array(
            'default'         => TND\trendy_news_get_customizer_default( 'top_header_option' ),
            'sanitize_callback' => 'trendy_news_sanitize_toggle_control',
            'transport' => 'postMessage'
        ));
    
        $wp_customize->add_control( 
            new Trendy_News_WP_Toggle_Control( $wp_customize, 'top_header_option', array(
                'label'	      => esc_html__( 'Show top header', 'trendy-news' ),
                'description' => esc_html__( 'Toggle to enable or disable top header bar', 'trendy-news' ),
                'section'     => 'trendy_news_top_header_section',
                'settings'    => 'top_header_option'
            ))
        );

        // Top header date time option
        $wp_customize->add_setting( 'top_header_date_time_option', array(
            'default'         => TND\trendy_news_get_customizer_default( 'top_header_date_time_option' ),
            'sanitize_callback' => 'trendy_news_sanitize_toggle_control'
        ));
    
        $wp_customize->add_control( 
            new Trendy_News_WP_Simple_Toggle_Control( $wp_customize, 'top_header_date_time_option', array(
                'label'	      => esc_html__( 'Show date and time', 'trendy-news' ),
                'section'     => 'trendy_news_top_header_section',
                'settings'    => 'top_header_date_time_option',
            ))
        );

        // Top header menu option
        $wp_customize->add_setting( 'top_header_menu_option', array(
            'default'         => TND\trendy_news_get_customizer_default( 'top_header_menu_option' ),
            'sanitize_callback' => 'trendy_news_sanitize_toggle_control',
            'transport' => 'postMessage'
        ));
    
        $wp_customize->add_control( 
            new Trendy_News_WP_Simple_Toggle_Control( $wp_customize, 'top_header_menu_option', array(
                'label'	      => esc_html__( 'Show menu items', 'trendy-news' ),
                'section'     => 'trendy_news_top_header_section',
                'settings'    => 'top_header_menu_option',
            ))
        );

        // Redirect top header menu link
        $wp_customize->add_setting( 'top_header_menu_redirects', array(
            'sanitize_callback' => 'trendy_news_sanitize_toggle_control',
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Redirect_Control( $wp_customize, 'top_header_menu_redirects', array(
                'section'     => 'trendy_news_top_header_section',
                'settings'    => 'top_header_menu_redirects',
                'choices'     => array(
                    'header-social-icons' => array(
                        'type'  => 'section',
                        'id'    => 'menu_locations',
                        'label' => esc_html__( 'Manage menu from here', 'trendy-news' )
                    )
                )
            ))
        );

        // top header social option
        $wp_customize->add_setting( 'top_header_social_option', array(
            'default'   => TND\trendy_news_get_customizer_default( 'top_header_social_option' ),
            'sanitize_callback' => 'trendy_news_sanitize_toggle_control',
            'transport' => 'postMessage'
        ));
    
        $wp_customize->add_control( 
            new Trendy_News_WP_Simple_Toggle_Control( $wp_customize, 'top_header_social_option', array(
                'label'	      => esc_html__( 'Show social icons', 'trendy-news' ),
                'section'     => 'trendy_news_top_header_section',
                'settings'    => 'top_header_social_option',
            ))
        );

        // Redirect header social icons link
        $wp_customize->add_setting( 'top_header_social_icons_redirects', array(
            'sanitize_callback' => 'trendy_news_sanitize_toggle_control',
        ));

        $wp_customize->add_control( 
            new Trendy_News_WP_Redirect_Control( $wp_customize, 'top_header_social_icons_redirects', array(
                'section'     => 'trendy_news_top_header_section',
                'settings'    => 'top_header_social_icons_redirects',
                'choices'     => array(
                    'header-social-icons' => array(
                        'type'  => 'section',
                        'id'    => 'trendy_news_social_icons_section',
                        'label' => esc_html__( 'Manage social icons', 'trendy-news' )
                    )
                )
            ))
        );

        // top header bottom border
        $wp_customize->add_setting( 'top_header_bottom_border', array( 
            'default' => TND\trendy_news_get_customizer_default('top_header_bottom_border'),
            'sanitize_callback' => 'trendy_news_sanitize_array',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Border_Control( $wp_customize, 'top_header_bottom_border', array(
                'label'       => esc_html__( 'Border Bottom', 'trendy-news' ),
                'section'     => 'trendy_news_top_header_section',
                'settings'    => 'top_header_bottom_border',
                'tab'   => 'design'
            ))
        );

        // Top header background colors group control
        $wp_customize->add_setting( 'top_header_background_color_group', array(
            'default'   => TND\trendy_news_get_customizer_default( 'top_header_background_color_group' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Color_Group_Control( $wp_customize, 'top_header_background_color_group', array(
                'label'	      => esc_html__( 'Background', 'trendy-news' ),
                'section'     => 'trendy_news_top_header_section',
                'settings'    => 'top_header_background_color_group',
                'tab'   => 'design'
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'top_header_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Info_Box_Control( $wp_customize, 'top_header_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'trendy-news' ),
                'description' => esc_html__( 'Date time color, menu color social icons color and hover colors.', 'trendy-news' ),
                'section'     => TRENDY_NEWS_PREFIX . 'top_header_section',
                'settings'    => 'top_header_upgrade_info',
                'priority'  => 100,
                'tab'   => 'design',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'trendy-news' ),
                        'url'   => esc_url( '//blazethemes.com/theme/trendy-news-pro/' )
                    )
                )
            ))
        );
    }
    add_action( 'customize_register', 'trendy_news_customizer_top_header_panel', 10 );
endif;

if( !function_exists( 'trendy_news_customizer_header_panel' ) ) :
    /**
     * Register header options settings
     * 
     */
    function trendy_news_customizer_header_panel( $wp_customize ) {
        /**
         * Header panel
         * 
         */
        $wp_customize->add_panel( 'trendy_news_header_panel', array(
            'title' => esc_html__( 'Theme Header', 'trendy-news' ),
            'priority'  => 69
        ));
        
        // Header ads banner section
        $wp_customize->add_section( 'trendy_news_header_ads_banner_section', array(
            'title' => esc_html__( 'Ads Banner', 'trendy-news' ),
            'panel' => 'trendy_news_header_panel',
            'priority'  => 5
        ));

        // Header Ads Banner setting heading
        $wp_customize->add_setting( 'trendy_news_header_ads_banner_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));

        $wp_customize->add_control( 
            new Trendy_News_WP_Section_Heading_Control( $wp_customize, 'trendy_news_header_ads_banner_header', array(
                'label'	      => esc_html__( 'Ads Banner Setting', 'trendy-news' ),
                'section'     => 'trendy_news_header_ads_banner_section',
                'settings'    => 'trendy_news_header_ads_banner_header'
            ))
        );

        // Resposive vivibility option
        $wp_customize->add_setting( 'header_ads_banner_responsive_option', array(
            'default' => TND\trendy_news_get_customizer_default( 'header_ads_banner_responsive_option' ),
            'sanitize_callback' => 'trendy_news_sanitize_responsive_multiselect_control'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Responsive_Multiselect_Tab_Control( $wp_customize, 'header_ads_banner_responsive_option', array(
                'label'	      => esc_html__( 'Ads Banner Visibility', 'trendy-news' ),
                'section'     => 'trendy_news_header_ads_banner_section',
                'settings'    => 'header_ads_banner_responsive_option'
            ))
        );

        // Header ads banner type
        $wp_customize->add_setting( 'header_ads_banner_type', array(
            'default' => TND\trendy_news_get_customizer_default( 'header_ads_banner_type' ),
            'sanitize_callback' => 'trendy_news_sanitize_select_control'
        ));
        $wp_customize->add_control( 'header_ads_banner_type', array(
            'type'      => 'select',
            'section'   => 'trendy_news_header_ads_banner_section',
            'label'     => __( 'Ads banner type', 'trendy-news' ),
            'description' => __( 'Choose to display ads content from.', 'trendy-news' ),
            'choices'   => array(
                'custom' => esc_html__( 'Custom', 'trendy-news' ),
                'sidebar' => esc_html__( 'Ads Banner Sidebar', 'trendy-news' )
            ),
        ));

        // ads image field
        $wp_customize->add_setting( 'header_ads_banner_custom_image', array(
            'default' => TND\trendy_news_get_customizer_default( 'header_ads_banner_custom_image' ),
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'header_ads_banner_custom_image', array(
            'section' => 'trendy_news_header_ads_banner_section',
            'mime_type' => 'image',
            'label' => esc_html__( 'Ads Image', 'trendy-news' ),
            'description' => esc_html__( 'Recommended size for ad image is 900 (width) * 350 (height)', 'trendy-news' ),
            'active_callback'   => function( $setting ) {
                if ( $setting->manager->get_setting( 'header_ads_banner_type' )->value() === 'custom' ) {
                    return true;
                }
                return false;
            }
        )));

        // ads url field
        $wp_customize->add_setting( 'header_ads_banner_custom_url', array(
            'default' => TND\trendy_news_get_customizer_default( 'header_ads_banner_custom_url' ),
            'sanitize_callback' => 'esc_url_raw',
        ));
          
        $wp_customize->add_control( 'header_ads_banner_custom_url', array(
            'type'  => 'url',
            'section'   => 'trendy_news_header_ads_banner_section',
            'label'     => esc_html__( 'Ads url', 'trendy-news' ),
            'active_callback'   => function( $setting ) {
                if ( $setting->manager->get_setting( 'header_ads_banner_type' )->value() === 'custom' ) {
                    return true;
                }
                return false;
            }
        ));

        // ads link show on
        $wp_customize->add_setting( 'header_ads_banner_custom_target', array(
            'default' => TND\trendy_news_get_customizer_default( 'header_ads_banner_custom_target' ),
            'sanitize_callback' => 'trendy_news_sanitize_select_control'
        ));
        
        $wp_customize->add_control( 'header_ads_banner_custom_target', array(
            'type'      => 'select',
            'section'   => 'trendy_news_header_ads_banner_section',
            'label'     => __( 'Open Ads link on', 'trendy-news' ),
            'choices'   => array(
                '_self' => esc_html__( 'Open in same tab', 'trendy-news' ),
                '_blank' => esc_html__( 'Open in new tab', 'trendy-news' )
            ),
            'active_callback'   => function( $setting ) {
                if ( $setting->manager->get_setting( 'header_ads_banner_type' )->value() === 'custom' ) {
                    return true;
                }
                return false;
            }
        ));

        // Redirect ads banner sidebar link
        $wp_customize->add_setting( 'header_ads_banner_sidebar_redirect', array(
            'sanitize_callback' => 'trendy_news_sanitize_toggle_control',
        ));

        $wp_customize->add_control( 
            new Trendy_News_WP_Redirect_Control( $wp_customize, 'header_ads_banner_sidebar_redirect', array(
                'section'     => 'trendy_news_header_ads_banner_section',
                'settings'    => 'header_ads_banner_sidebar_redirect',
                'choices'     => array(
                    'header-social-icons' => array(
                        'type'  => 'section',
                        'id'    => 'sidebar-widgets-ads-banner-sidebar',
                        'label' => esc_html__( 'Manage ads banner sidebar from here', 'trendy-news' )
                    )
                ),
                'active_callback'   => function( $setting ) {
                    if ( $setting->manager->get_setting( 'header_ads_banner_type' )->value() === 'sidebar' ) {
                        return true;
                    }
                    return false;
                }
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'header_ads_banner_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Info_Box_Control( $wp_customize, 'header_ads_banner_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'trendy-news' ),
                'description' => esc_html__( 'Embed ads shortcode field.', 'trendy-news' ),
                'section'     => TRENDY_NEWS_PREFIX . 'header_ads_banner_section',
                'settings'    => 'header_ads_banner_upgrade_info',
                'priority'  => 100,
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'trendy-news' ),
                        'url'   => esc_url( '//blazethemes.com/theme/trendy-news-pro/' )
                    )
                )
            ))
        );

        /**
         * Header content section
         * 
         */
        $wp_customize->add_section( 'trendy_news_main_header_section', array(
            'title' => esc_html__( 'Main Header', 'trendy-news' ),
            'panel' => 'trendy_news_header_panel',
            'priority'  => 10
        ));

        // section tab
        $wp_customize->add_setting( 'main_header_section_tab', array(
            'sanitize_callback' => 'sanitize_text_field',
            'default'   => 'general'
        ));
        
        $wp_customize->add_control( 
            new Trendy_News_WP_Section_Tab_Control( $wp_customize, 'main_header_section_tab', array(
                'section'     => 'trendy_news_main_header_section',
                'choices'  => array(
                    array(
                        'name'  => 'general',
                        'title'  => esc_html__( 'General', 'trendy-news' )
                    ),
                    array(
                        'name'  => 'design',
                        'title'  => esc_html__( 'Design', 'trendy-news' )
                    )
                )
            ))
        );

        // redirect site logo section
        $wp_customize->add_setting( 'header_site_logo_redirects', array(
            'sanitize_callback' => 'trendy_news_sanitize_toggle_control',
        ));

        $wp_customize->add_control( 
            new Trendy_News_WP_Redirect_Control( $wp_customize, 'header_site_logo_redirects', array(
                'section'     => 'trendy_news_main_header_section',
                'settings'    => 'header_site_logo_redirects',
                'choices'     => array(
                    'header-social-icons' => array(
                        'type'  => 'section',
                        'id'    => 'title_tagline',
                        'label' => esc_html__( 'Manage Site Logo', 'trendy-news' )
                    )
                )
            ))
        );

        // redirect site title section
        $wp_customize->add_setting( 'header_site_title_redirects', array(
            'sanitize_callback' => 'trendy_news_sanitize_toggle_control',
        ));

        $wp_customize->add_control( 
            new Trendy_News_WP_Redirect_Control( $wp_customize, 'header_site_title_redirects', array(
                'section'     => 'trendy_news_main_header_section',
                'settings'    => 'header_site_title_redirects',
                'choices'     => array(
                    'header-social-icons' => array(
                        'type'  => 'section',
                        'id'    => 'trendy_news_site_title_section',
                        'label' => esc_html__( 'Manage site & Tagline', 'trendy-news' )
                    )
                )
            ))
        );

        // header sidebar toggle button option
        $wp_customize->add_setting( 'header_sidebar_toggle_option', array(
            'default'         => TND\trendy_news_get_customizer_default( 'header_sidebar_toggle_option' ),
            'sanitize_callback' => 'trendy_news_sanitize_toggle_control',
            'transport' => 'postMessage'
        ));
    
        $wp_customize->add_control( 
            new Trendy_News_WP_Simple_Toggle_Control( $wp_customize, 'header_sidebar_toggle_option', array(
                'label'	      => esc_html__( 'Show sidebar toggle button', 'trendy-news' ),
                'section'     => 'trendy_news_main_header_section',
                'settings'    => 'header_sidebar_toggle_option'
            ))
        );

        // redirect sidebar toggle button link
        $wp_customize->add_setting( 'header_sidebar_toggle_button_redirects', array(
            'sanitize_callback' => 'trendy_news_sanitize_toggle_control',
        ));

        $wp_customize->add_control( 
            new Trendy_News_WP_Redirect_Control( $wp_customize, 'header_sidebar_toggle_button_redirects', array(
                'section'     => 'trendy_news_main_header_section',
                'settings'    => 'header_sidebar_toggle_button_redirects',
                'choices'     => array(
                    'header-social-icons' => array(
                        'type'  => 'section',
                        'id'    => 'sidebar-widgets-header-toggle-sidebar',
                        'label' => esc_html__( 'Manage sidebar from here', 'trendy-news' )
                    )
                )
            ))
        );

        // header search option
        $wp_customize->add_setting( 'header_search_option', array(
            'default'   => TND\trendy_news_get_customizer_default( 'header_search_option' ),
            'sanitize_callback' => 'trendy_news_sanitize_toggle_control',
            'transport' => 'postMessage'
        ));
    
        $wp_customize->add_control( 
            new Trendy_News_WP_Simple_Toggle_Control( $wp_customize, 'header_search_option', array(
                'label'	      => esc_html__( 'Show search icon', 'trendy-news' ),
                'section'     => 'trendy_news_main_header_section',
                'settings'    => 'header_search_option'
            ))
        );
        
        // header theme mode toggle option
        $wp_customize->add_setting( 'header_theme_mode_toggle_option', array(
            'default'   => TND\trendy_news_get_customizer_default( 'header_theme_mode_toggle_option' ),
            'sanitize_callback' => 'trendy_news_sanitize_toggle_control',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Simple_Toggle_Control( $wp_customize, 'header_theme_mode_toggle_option', array(
                'label'	      => esc_html__( 'Show dark/light toggle icon', 'trendy-news' ),
                'section'     => 'trendy_news_main_header_section',
                'settings'    => 'header_theme_mode_toggle_option'
            ))
        );

        // header sticky option
        $wp_customize->add_setting( 'theme_header_sticky', array(
            'default'   => TND\trendy_news_get_customizer_default( 'theme_header_sticky' ),
            'sanitize_callback' => 'trendy_news_sanitize_toggle_control'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Simple_Toggle_Control( $wp_customize, 'theme_header_sticky', array(
                'label'	      => esc_html__( 'Enable header section sticky', 'trendy-news' ),
                'section'     => 'trendy_news_main_header_section',
                'settings'    => 'theme_header_sticky'
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'theme_header_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Info_Box_Control( $wp_customize, 'theme_header_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'trendy-news' ),
                'description' => esc_html__( '2 layouts.', 'trendy-news' ),
                'section'     => TRENDY_NEWS_PREFIX . 'main_header_section',
                'settings'    => 'theme_header_upgrade_info',
                'priority'  => 100,
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'trendy-news' ),
                        'url'   => esc_url( '//blazethemes.com/theme/trendy-news-pro/' )
                    )
                )
            ))
        );

        // header top and bottom padding
        $wp_customize->add_setting( 'header_vertical_padding', array(
            'default'   => TND\trendy_news_get_customizer_default( 'header_vertical_padding' ),
            'sanitize_callback' => 'trendy_news_sanitize_responsive_range',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control(
            new Trendy_News_WP_Responsive_Range_Control( $wp_customize, 'header_vertical_padding', array(
                    'label'	      => esc_html__( 'Vertical Padding (px)', 'trendy-news' ),
                    'section'     => 'trendy_news_main_header_section',
                    'settings'    => 'header_vertical_padding',
                    'unit'        => 'px',
                    'tab'   => 'design',
                    'input_attrs' => array(
                    'max'         => 500,
                    'min'         => 1,
                    'step'        => 1,
                    'reset' => true
                )
            ))
        );

        // Header background colors setting
        $wp_customize->add_setting( 'header_background_color_group', array(
            'default'   => TND\trendy_news_get_customizer_default( 'header_background_color_group' ),
            'sanitize_callback' => 'trendy_news_sanitize_color_image_group_control',
            'transport' => 'postMessage'
        ));
        
        $wp_customize->add_control( 
            new Trendy_News_WP_Color_Image_Group_Control( $wp_customize, 'header_background_color_group', array(
                'label'	      => esc_html__( 'Background', 'trendy-news' ),
                'section'     => 'trendy_news_main_header_section',
                'settings'    => 'header_background_color_group',
                'tab'   => 'design'
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'theme_header_design_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Info_Box_Control( $wp_customize, 'theme_header_design_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'trendy-news' ),
                'description' => esc_html__( 'Toggle bar color and search icon color.', 'trendy-news' ),
                'section'     => TRENDY_NEWS_PREFIX . 'main_header_section',
                'settings'    => 'theme_header_design_upgrade_info',
                'priority'  => 100,
                'tab'  => 'design',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'trendy-news' ),
                        'url'   => esc_url( '//blazethemes.com/theme/trendy-news-pro/' )
                    )
                )
            ))
        );
        
        /**
         * Menu Options Section
         * 
         * panel - trendy_news_header_options_panel
         */
        $wp_customize->add_section( 'trendy_news_header_menu_option_section', array(
            'title' => esc_html__( 'Menu Options', 'trendy-news' ),
            'panel' => 'trendy_news_header_panel',
            'priority'  => 30,
        ));
        
        // header menu hover effect
        $wp_customize->add_setting( 'header_menu_hover_effect', array(
            'default' => TND\trendy_news_get_customizer_default( 'header_menu_hover_effect' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Radio_Tab_Control( $wp_customize, 'header_menu_hover_effect', array(
                'label'	      => esc_html__( 'Hover Effect', 'trendy-news' ),
                'section'     => 'trendy_news_header_menu_option_section',
                'settings'    => 'header_menu_hover_effect',
                'choices' => array(
                    array(
                        'value' => 'none',
                        'label' => esc_html__('None', 'trendy-news' )
                    ),
                    array(
                        'value' => 'one',
                        'label' => esc_html__('One', 'trendy-news' )
                    )
                )
            ))
        );

        // header menu background color group
        $wp_customize->add_setting( 'header_menu_background_color_group', array(
            'default'   => TND\trendy_news_get_customizer_default( 'header_menu_background_color_group' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Color_Group_Control( $wp_customize, 'header_menu_background_color_group', array(
                'label'	      => esc_html__( 'Background', 'trendy-news' ),
                'section'     => 'trendy_news_header_menu_option_section',
                'settings'    => 'header_menu_background_color_group'
            ))
        );

        // menu border top
        $wp_customize->add_setting( 'header_menu_top_border', array( 
            'default' => TND\trendy_news_get_customizer_default( 'header_menu_top_border' ),
            'sanitize_callback' => 'trendy_news_sanitize_array',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Border_Control( $wp_customize, 'header_menu_top_border', array(
                'label'       => esc_html__( 'Border Top', 'trendy-news' ),
                'section'     => 'trendy_news_header_menu_option_section',
                'settings'    => 'header_menu_top_border'
            ))
        );

        // menu border bottom
        $wp_customize->add_setting( 'header_menu_bottom_border', array( 
            'default' => TND\trendy_news_get_customizer_default( 'header_menu_bottom_border' ),
            'sanitize_callback' => 'trendy_news_sanitize_array',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Border_Control( $wp_customize, 'header_menu_bottom_border', array(
                'label'       => esc_html__( 'Border Bottom', 'trendy-news' ),
                'section'     => 'trendy_news_header_menu_option_section',
                'settings'    => 'header_menu_bottom_border'
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'header_menu_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Info_Box_Control( $wp_customize, 'header_menu_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'trendy-news' ),
                'description' => esc_html__( 'Menu color, active menu color, hover color, sub menu color, background color, border color and typography.', 'trendy-news' ),
                'section'     => TRENDY_NEWS_PREFIX . 'header_menu_option_section',
                'settings'    => 'header_menu_upgrade_info',
                'priority'  => 100,
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'trendy-news' ),
                        'url'   => esc_url( '//blazethemes.com/theme/trendy-news-pro/' )
                    )
                )
            ))
        );
    }
    add_action( 'customize_register', 'trendy_news_customizer_header_panel', 10 );
endif;

if( !function_exists( 'trendy_news_customizer_ticker_news_panel' ) ) :
    /**
     * Register header options settings
     * 
     */
    function trendy_news_customizer_ticker_news_panel( $wp_customize ) {
        // ticker news section
        $wp_customize->add_section( 'trendy_news_ticker_news_section', array(
            'title' => esc_html__( 'Ticker News', 'trendy-news' ),
            'priority'  => 20
        ));
        // preloader option
        $wp_customize->add_setting( 'ticker_news_option', array(
            'default'   => TND\trendy_news_get_customizer_default('ticker_news_option'),
            'sanitize_callback' => 'trendy_news_sanitize_toggle_control'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Simple_Toggle_Control( $wp_customize, 'ticker_news_option', array(
                'label'	      => esc_html__( 'Enable ticker news', 'trendy-news' ),
                'section'     => 'trendy_news_ticker_news_section',
                'settings'    => 'ticker_news_option'
            ))
        );

        // Ticker News title
        $wp_customize->add_setting( 'ticker_news_title', array(
            'default' => TND\trendy_news_get_customizer_default( 'ticker_news_title' ),
            'sanitize_callback' => 'trendy_news_sanitize_custom_text_control',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Icon_Text_Control( $wp_customize, 'ticker_news_title', array(
                'label'     => esc_html__( 'Ticker title', 'trendy-news' ),
                'section'     => 'trendy_news_ticker_news_section',
                'settings'    => 'ticker_news_title'
            ))
        );

        // Ticker News posts filter
        $wp_customize->add_setting( 'ticker_news_post_filter', array(
            'default' => TND\trendy_news_get_customizer_default( 'ticker_news_post_filter' ),
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Radio_Bubble_Control( $wp_customize, 'ticker_news_post_filter', array(
                'section'     => 'trendy_news_ticker_news_section',
                'settings'    => 'ticker_news_post_filter',
                'choices' => array(
                    array(
                        'value' => 'category',
                        'label' => esc_html__('By category', 'trendy-news' )
                    ),
                    array(
                        'value' => 'title',
                        'label' => esc_html__('By title', 'trendy-news' )
                    )
                )
            ))
        );

        // Ticker News categories
        $wp_customize->add_setting( 'ticker_news_categories', array(
            'default' => TND\trendy_news_get_customizer_default( 'ticker_news_categories' ),
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Multiselect_Control( $wp_customize, 'ticker_news_categories', array(
                'label'     => esc_html__( 'Posts Categories', 'trendy-news' ),
                'section'   => 'trendy_news_ticker_news_section',
                'settings'  => 'ticker_news_categories',
                'choices'   => trendy_news_get_multicheckbox_categories_simple_array(),
                'active_callback'   => function( $setting ) {
                    if ( $setting->manager->get_setting( 'ticker_news_post_filter' )->value() == 'category' ) {
                        return true;
                    }
                    return false;
                }
            ))
        );

        // Ticker News posts
        $wp_customize->add_setting( 'ticker_news_posts', array(
            'default' => TND\trendy_news_get_customizer_default( 'ticker_news_posts' ),
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Posts_Multiselect_Control( $wp_customize, 'ticker_news_posts', array(
                'label'     => esc_html__( 'Posts', 'trendy-news' ),
                'section'   => 'trendy_news_ticker_news_section',
                'settings'  => 'ticker_news_posts',
                'choices'   => trendy_news_get_multicheckbox_posts_simple_array(),
                'active_callback'   => function( $setting ) {
                    if ( $setting->manager->get_setting( 'ticker_news_post_filter' )->value() == 'title' ) {
                        return true;
                    }
                    return false;
                }
            ))
        );

        // Ticker News date filter
        $wp_customize->add_setting( 'ticker_news_date_filter', array(
            'default' => TND\trendy_news_get_customizer_default( 'ticker_news_date_filter' ),
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Radio_Bubble_Control( $wp_customize, 'ticker_news_date_filter', array(
                'section'     => 'trendy_news_ticker_news_section',
                'settings'    => 'ticker_news_date_filter',
                'choices' => trendy_news_get_date_filter_choices_array(),
                'active_callback'   => function( $setting ) {
                    if ( $setting->manager->get_setting( 'ticker_news_post_filter' )->value() == 'category' ) {
                        return true;
                    }
                    return false;
                }
            ))
        );
    }
    add_action( 'customize_register', 'trendy_news_customizer_ticker_news_panel', 10 );
endif;

if( !function_exists( 'trendy_news_customizer_main_banner_panel' ) ) :
    /**
     * Register main banner section settings
     * 
     */
    function trendy_news_customizer_main_banner_panel( $wp_customize ) {
        /**
         * Main Banner section
         * 
         */
        $wp_customize->add_section( 'trendy_news_main_banner_section', array(
            'title' => esc_html__( 'Main Banner', 'trendy-news' ),
            'priority'  => 70
        ));

        // main banner section tab
        $wp_customize->add_setting( 'main_banner_section_tab', array(
            'sanitize_callback' => 'sanitize_text_field',
            'default'   => 'general'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Section_Tab_Control( $wp_customize, 'main_banner_section_tab', array(
                'section'     => 'trendy_news_main_banner_section',
                'priority'  => 1,
                'choices'  => array(
                    array(
                        'name'  => 'general',
                        'title'  => esc_html__( 'General', 'trendy-news' )
                    ),
                    array(
                        'name'  => 'design',
                        'title'  => esc_html__( 'Design', 'trendy-news' )
                    )
                )
            ))
        );

        // Main Banner option
        $wp_customize->add_setting( 'main_banner_option', array(
            'default'   => TND\trendy_news_get_customizer_default( 'main_banner_option' ),
            'sanitize_callback' => 'trendy_news_sanitize_toggle_control'
        ));
    
        $wp_customize->add_control( 
            new Trendy_News_WP_Toggle_Control( $wp_customize, 'main_banner_option', array(
                'label'	      => esc_html__( 'Show main banner', 'trendy-news' ),
                'section'     => 'trendy_news_main_banner_section',
                'settings'    => 'main_banner_option'
            ))
        );

        // main banner slider setting heading
        $wp_customize->add_setting( 'main_banner_slider_settings_header', array(
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'postMessage'
        ));
        
        $wp_customize->add_control( 
            new Trendy_News_WP_Section_Heading_Control( $wp_customize, 'main_banner_slider_settings_header', array(
                'label'	      => esc_html__( 'Slider Setting', 'trendy-news' ),
                'section'     => 'trendy_news_main_banner_section',
                'settings'    => 'main_banner_slider_settings_header',
                'type'        => 'section-heading',
            ))
        );

        // Main Banner slider number of posts
        $wp_customize->add_setting( 'main_banner_slider_numbers', array(
            'default' => TND\trendy_news_get_customizer_default( 'main_banner_slider_numbers' ),
            'sanitize_callback' => 'absint'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Range_Control( $wp_customize, 'main_banner_slider_numbers', array(
                'label'	      => esc_html__( 'Number of posts to display', 'trendy-news' ),
                'section'     => 'trendy_news_main_banner_section',
                'settings'    => 'main_banner_slider_numbers',
                'input_attrs' => array(
                    'min'   => 1,
                    'max'   => 4,
                    'step'  => 1,
                    'reset' => false
                ),
                'active_callback'   => function( $setting ) {
                    if ( $setting->manager->get_setting( 'main_banner_post_filter' )->value() == 'category' ) {
                        return true;
                    }
                    return false;
                }
            ))
        );
        
        // main banner posts filter
        $wp_customize->add_setting( 'main_banner_post_filter', array(
            'default' => TND\trendy_news_get_customizer_default( 'main_banner_post_filter' ),
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Radio_Bubble_Control( $wp_customize, 'main_banner_post_filter', array(
                'section'     => 'trendy_news_main_banner_section',
                'settings'    => 'main_banner_post_filter',
                'choices' => array(
                    array(
                        'value' => 'category',
                        'label' => esc_html__('By category', 'trendy-news' )
                    ),
                    array(
                        'value' => 'title',
                        'label' => esc_html__('By title', 'trendy-news' )
                    )
                )
            ))
        );

        // Main Banner slider categories
        $wp_customize->add_setting( 'main_banner_slider_categories', array(
            'default' => TND\trendy_news_get_customizer_default( 'main_banner_slider_categories' ),
            'sanitize_callback' => 'sanitize_text_field'
        ));
        
        $wp_customize->add_control( 
            new Trendy_News_WP_Multiselect_Control( $wp_customize, 'main_banner_slider_categories', array(
                'label'     => esc_html__( 'Posts Categories', 'trendy-news' ),
                'section'   => 'trendy_news_main_banner_section',
                'settings'  => 'main_banner_slider_categories',
                'choices'   => trendy_news_get_multicheckbox_categories_simple_array(),
                'active_callback'   => function( $setting ) {
                    if ( $setting->manager->get_setting( 'main_banner_post_filter' )->value() == 'category' ) {
                        return true;
                    }
                    return false;
                }
            ))
        );

        // main banner date filter
        $wp_customize->add_setting( 'main_banner_date_filter', array(
            'default' => TND\trendy_news_get_customizer_default( 'main_banner_date_filter' ),
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Radio_Bubble_Control( $wp_customize, 'main_banner_date_filter', array(
                'section'     => 'trendy_news_main_banner_section',
                'settings'    => 'main_banner_date_filter',
                'choices' => trendy_news_get_date_filter_choices_array(),
                'active_callback'   => function( $setting ) {
                    if ( $setting->manager->get_setting( 'main_banner_post_filter' )->value() == 'category' ) {
                        return true;
                    }
                    return false;
                }
            ))
        );

        // main banner posts
        $wp_customize->add_setting( 'main_banner_posts', array(
            'default' => TND\trendy_news_get_customizer_default( 'main_banner_posts' ),
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Posts_Multiselect_Control( $wp_customize, 'main_banner_posts', array(
                'label'     => esc_html__( 'Posts', 'trendy-news' ),
                'section'   => 'trendy_news_main_banner_section',
                'settings'  => 'main_banner_posts',
                'choices'   => trendy_news_get_multicheckbox_posts_simple_array(),
                'active_callback'   => function( $setting ) {
                    if ( $setting->manager->get_setting( 'main_banner_post_filter' )->value() == 'title' ) {
                        return true;
                    }
                    return false;
                }
            ))
        );

        // Main Banner slider categories option
        $wp_customize->add_setting( 'main_banner_slider_categories_option', array(
            'default'   => TND\trendy_news_get_customizer_default( 'main_banner_slider_categories_option' ),
            'sanitize_callback' => 'trendy_news_sanitize_toggle_control'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Simple_Toggle_Control( $wp_customize, 'main_banner_slider_categories_option', array(
                'label'	      => esc_html__( 'Show post categories', 'trendy-news' ),
                'section'     => 'trendy_news_main_banner_section',
                'settings'    => 'main_banner_slider_categories_option'
            ))
        );

        // Main Banner slider date option
        $wp_customize->add_setting( 'main_banner_slider_date_option', array(
            'default'   => TND\trendy_news_get_customizer_default( 'main_banner_slider_date_option' ),
            'sanitize_callback' => 'trendy_news_sanitize_toggle_control'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Simple_Toggle_Control( $wp_customize, 'main_banner_slider_date_option', array(
                'label'	      => esc_html__( 'Show post date', 'trendy-news' ),
                'section'     => 'trendy_news_main_banner_section',
                'settings'    => 'main_banner_slider_date_option'
            ))
        );

        // Main Banner slider excerpt option
        $wp_customize->add_setting( 'main_banner_slider_excerpt_option', array(
            'default'   => TND\trendy_news_get_customizer_default( 'main_banner_slider_excerpt_option' ),
            'sanitize_callback' => 'trendy_news_sanitize_toggle_control'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Simple_Toggle_Control( $wp_customize, 'main_banner_slider_excerpt_option', array(
                'label'	      => esc_html__( 'Show post excerpt', 'trendy-news' ),
                'section'     => 'trendy_news_main_banner_section',
                'settings'    => 'main_banner_slider_excerpt_option'
            ))
        );

        // Main banner block posts setting heading
        $wp_customize->add_setting( 'main_banner_block_posts_settings_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Section_Heading_Control( $wp_customize, 'main_banner_block_posts_settings_header', array(
                'label'	      => esc_html__( 'Block Posts Setting', 'trendy-news' ),
                'section'     => 'trendy_news_main_banner_section',
                'settings'    => 'main_banner_block_posts_settings_header',
                'type'        => 'section-heading'
            ))
        );

        // Main Banner block posts slider orderby
        $wp_customize->add_setting( 'main_banner_block_posts_order_by', array(
            'default' => TND\trendy_news_get_customizer_default( 'main_banner_block_posts_order_by' ),
            'sanitize_callback' => 'trendy_news_sanitize_select_control'
        ));
        $wp_customize->add_control( 'main_banner_block_posts_order_by', array(
            'type'      => 'select',
            'section'   => 'trendy_news_main_banner_section',
            'label'     => esc_html__( 'Orderby', 'trendy-news' ),
            'choices'   => array(
                'date-desc' => esc_html__( 'Newest - Oldest', 'trendy-news' ),
                'date-asc' => esc_html__( 'Oldest - Newest', 'trendy-news' ),
                'title-asc' => esc_html__( 'A - Z', 'trendy-news' ),
                'title-desc' => esc_html__( 'Z - A', 'trendy-news' ),
                'rand-desc' => esc_html__( 'Random', 'trendy-news' )
            )
        ));

        // Main Banner block posts categories
        $wp_customize->add_setting( 'main_banner_block_posts_categories', array(
            'default' => TND\trendy_news_get_customizer_default( 'main_banner_block_posts_categories' ),
            'sanitize_callback' => 'sanitize_text_field'
        ));
        
        $wp_customize->add_control( 
            new Trendy_News_WP_Multiselect_Control( $wp_customize, 'main_banner_block_posts_categories', array(
                'label'     => esc_html__( 'Block posts categories', 'trendy-news' ),
                'section'   => 'trendy_news_main_banner_section',
                'settings'  => 'main_banner_block_posts_categories',
                'choices'   => trendy_news_get_multicheckbox_categories_simple_array()
            ))
        );

        // Main Banner number of block posts
        $wp_customize->add_setting( 'main_banner_block_posts_numbers', array(
            'default' => TND\trendy_news_get_customizer_default( 'main_banner_block_posts_numbers' ),
            'sanitize_callback' => 'absint'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Range_Control( $wp_customize, 'main_banner_block_posts_numbers', array(
                'label'	      => esc_html__( 'Number of posts to display', 'trendy-news' ),
                'section'     => 'trendy_news_main_banner_section',
                'settings'    => 'main_banner_block_posts_numbers',
                'input_attrs' => array(
                    'min'   => 1,
                    'max'   => 100,
                    'step'  => 1,
                    'reset' => false
                )
            ))
        );

        // Main Banner block posts categories option
        $wp_customize->add_setting( 'main_banner_block_posts_categories_option', array(
            'default'   => TND\trendy_news_get_customizer_default( 'main_banner_block_posts_categories_option' ),
            'sanitize_callback' => 'trendy_news_sanitize_toggle_control'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Simple_Toggle_Control( $wp_customize, 'main_banner_block_posts_categories_option', array(
                'label'	      => esc_html__( 'Show post categories', 'trendy-news' ),
                'section'     => 'trendy_news_main_banner_section',
                'settings'    => 'main_banner_block_posts_categories_option'
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'main_banner_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Info_Box_Control( $wp_customize, 'main_banner_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'trendy-news' ),
                'description' => esc_html__( '3 layouts, banner elements show/hide, slider auto, arrows, and pager dots show/hide.', 'trendy-news' ),
                'section'     => TRENDY_NEWS_PREFIX . 'main_banner_section',
                'settings'    => 'main_banner_upgrade_info',
                'priority'  => 100,
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'trendy-news' ),
                        'url'   => esc_url( '//blazethemes.com/theme/trendy-news-pro/' )
                    )
                )
            ))
        );

        // banner section order
        $wp_customize->add_setting( 'banner_section_order', array(
            'default'   => TND\trendy_news_get_customizer_default( 'banner_section_order' ),
            'sanitize_callback' => 'trendy_news_sanitize_sortable_control'
        ));
        $wp_customize->add_control(
            new Trendy_News_WP_Item_Sortable_Control( $wp_customize, 'banner_section_order', array(
                'label'         => esc_html__( 'Column Re-order', 'trendy-news' ),
                'description'   => esc_html__( 'Hold the item and drag vertically to re-order', 'trendy-news' ),
                'section'       => 'trendy_news_main_banner_section',
                'settings'      => 'banner_section_order',
                'tab'   => 'design',
                'fields'    => array(
                    'banner_slider'  => array(
                        'label' => esc_html__( 'Banner Slider Column', 'trendy-news' )
                    ),
                    'tab_slider'  => array(
                        'label' => esc_html__( 'Tabbed Posts Column', 'trendy-news' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'main_banner_design_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Info_Box_Control( $wp_customize, 'main_banner_design_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'trendy-news' ),
                'description' => esc_html__( 'Content background color, gradient and image.', 'trendy-news' ),
                'section'     => TRENDY_NEWS_PREFIX . 'main_banner_section',
                'settings'    => 'main_banner_design_upgrade_info',
                'priority'  => 100,
                'tab'  => 'design',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'trendy-news' ),
                        'url'   => esc_url( '//blazethemes.com/theme/trendy-news-pro/' )
                    )
                )
            ))
        );
    }
    add_action( 'customize_register', 'trendy_news_customizer_main_banner_panel', 10 );
endif;

if( !function_exists( 'trendy_news_customizer_footer_panel' ) ) :
    /**
     * Register footer options settings
     * 
     */
    function trendy_news_customizer_footer_panel( $wp_customize ) {
        /**
         * Theme Footer Section
         * 
         * panel - trendy_news_footer_panel
         */
        $wp_customize->add_section( 'trendy_news_footer_section', array(
            'title' => esc_html__( 'Theme Footer', 'trendy-news' ),
            'priority'  => 74
        ));
        
        // section tab
        $wp_customize->add_setting( 'footer_section_tab', array(
            'sanitize_callback' => 'sanitize_text_field',
            'default'   => 'general'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Section_Tab_Control( $wp_customize, 'footer_section_tab', array(
                'section'     => 'trendy_news_footer_section',
                'choices'  => array(
                    array(
                        'name'  => 'general',
                        'title'  => esc_html__( 'General', 'trendy-news' )
                    ),
                    array(
                        'name'  => 'design',
                        'title'  => esc_html__( 'Design', 'trendy-news' )
                    )
                )
            ))
        );

        // Footer Option
        $wp_customize->add_setting( 'footer_option', array(
            'default'   => TND\trendy_news_get_customizer_default( 'footer_option' ),
            'sanitize_callback' => 'trendy_news_sanitize_toggle_control',
            'transport'   => 'postMessage'
        ));
    
        $wp_customize->add_control( 
            new Trendy_News_WP_Toggle_Control( $wp_customize, 'footer_option', array(
                'label'	      => esc_html__( 'Enable footer section', 'trendy-news' ),
                'section'     => 'trendy_news_footer_section',
                'settings'    => 'footer_option',
                'tab'   => 'general'
            ))
        );

        /// Add the footer layout control.
        $wp_customize->add_setting( 'footer_widget_column', array(
            'default'           => TND\trendy_news_get_customizer_default( 'footer_widget_column' ),
            'sanitize_callback' => 'trendy_news_sanitize_select_control',
            'transport'   => 'postMessage'
            )
        );
        $wp_customize->add_control( new Trendy_News_WP_Radio_Image_Control(
            $wp_customize,
            'footer_widget_column',
            array(
                'section'  => 'trendy_news_footer_section',
                'tab'   => 'general',
                'choices'  => array(
                    'column-one' => array(
                        'label' => esc_html__( 'Column One', 'trendy-news' ),
                        'url'   => '%s/assets/images/customizer/footer_column_one.jpg'
                    ),
                    'column-two' => array(
                        'label' => esc_html__( 'Column Two', 'trendy-news' ),
                        'url'   => '%s/assets/images/customizer/footer_column_two.jpg'
                    ),
                    'column-three' => array(
                        'label' => esc_html__( 'Column Three', 'trendy-news' ),
                        'url'   => '%s/assets/images/customizer/footer_column_three.jpg'
                    ),
                    'column-four' => array(
                        'label' => esc_html__( 'Column Four', 'trendy-news' ),
                        'url'   => '%s/assets/images/customizer/footer_column_four.jpg'
                    )
                )
            )
        ));
        
        // Redirect widgets link
        $wp_customize->add_setting( 'footer_widgets_redirects', array(
            'sanitize_callback' => 'trendy_news_sanitize_toggle_control',
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Redirect_Control( $wp_customize, 'footer_widgets_redirects', array(
                'label'	      => esc_html__( 'Widgets', 'trendy-news' ),
                'section'     => 'trendy_news_footer_section',
                'settings'    => 'footer_widgets_redirects',
                'tab'   => 'general',
                'choices'     => array(
                    'footer-column-one' => array(
                        'type'  => 'section',
                        'id'    => 'sidebar-widgets-footer-sidebar--column-1',
                        'label' => esc_html__( 'Manage footer widget one', 'trendy-news' )
                    ),
                    'footer-column-two' => array(
                        'type'  => 'section',
                        'id'    => 'sidebar-widgets-footer-sidebar--column-2',
                        'label' => esc_html__( 'Manage footer widget two', 'trendy-news' )
                    ),
                    'footer-column-three' => array(
                        'type'  => 'section',
                        'id'    => 'sidebar-widgets-footer-sidebar--column-3',
                        'label' => esc_html__( 'Manage footer widget three', 'trendy-news' )
                    ),
                    'footer-column-four' => array(
                        'type'  => 'section',
                        'id'    => 'sidebar-widgets-footer-sidebar--column-4',
                        'label' => esc_html__( 'Manage footer widget four', 'trendy-news' )
                    )
                )
            ))
        );

        // footer border top
        $wp_customize->add_setting( 'footer_top_border', array( 
            'default' => TND\trendy_news_get_customizer_default( 'footer_top_border' ),
            'sanitize_callback' => 'trendy_news_sanitize_array',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Border_Control( $wp_customize, 'footer_top_border', array(
                'label'       => esc_html__( 'Border Top', 'trendy-news' ),
                'section'     => 'trendy_news_footer_section',
                'settings'    => 'footer_top_border',
                'tab'   => 'design'
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'footer_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Info_Box_Control( $wp_customize, 'footer_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'trendy-news' ),
                'description' => esc_html__( 'Text color and background color, image, gradient colors.', 'trendy-news' ),
                'section'     => TRENDY_NEWS_PREFIX . 'footer_section',
                'settings'    => 'footer_upgrade_info',
                'priority'  => 100,
                'tab'  => 'design',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'trendy-news' ),
                        'url'   => esc_url( '//blazethemes.com/theme/trendy-news-pro/' )
                    )
                )
            ))
        );
    }
    add_action( 'customize_register', 'trendy_news_customizer_footer_panel', 10 );
endif;

if( !function_exists( 'trendy_news_customizer_bottom_footer_panel' ) ) :
    /**
     * Register bottom footer options settings
     * 
     */
    function trendy_news_customizer_bottom_footer_panel( $wp_customize ) {
        /**
         * Bottom Footer Section
         * 
         * panel - trendy_news_footer_panel
         */
        $wp_customize->add_section( 'trendy_news_bottom_footer_section', array(
            'title' => esc_html__( 'Bottom Footer', 'trendy-news' ),
            'priority'  => 75
        ));

        // Bottom Footer Option
        $wp_customize->add_setting( 'bottom_footer_option', array(
            'default'         => TND\trendy_news_get_customizer_default( 'bottom_footer_option' ),
            'sanitize_callback' => 'trendy_news_sanitize_toggle_control',
            'transport' => 'postMessage'
        ));
    
        $wp_customize->add_control( 
            new Trendy_News_WP_Toggle_Control( $wp_customize, 'bottom_footer_option', array(
                'label'	      => esc_html__( 'Enable bottom footer', 'trendy-news' ),
                'section'     => 'trendy_news_bottom_footer_section',
                'settings'    => 'bottom_footer_option'
            ))
        );

        // Main Banner slider categories option
        $wp_customize->add_setting( 'bottom_footer_social_option', array(
            'default'   => TND\trendy_news_get_customizer_default( 'bottom_footer_social_option' ),
            'sanitize_callback' => 'trendy_news_sanitize_toggle_control',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Simple_Toggle_Control( $wp_customize, 'bottom_footer_social_option', array(
                'label'	      => esc_html__( 'Show bottom social icons', 'trendy-news' ),
                'section'     => 'trendy_news_bottom_footer_section',
                'settings'    => 'bottom_footer_social_option'
            ))
        );

        // Main Banner slider categories option
        $wp_customize->add_setting( 'bottom_footer_menu_option', array(
            'default'   => TND\trendy_news_get_customizer_default( 'bottom_footer_menu_option' ),
            'sanitize_callback' => 'trendy_news_sanitize_toggle_control',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Simple_Toggle_Control( $wp_customize, 'bottom_footer_menu_option', array(
                'label'	      => esc_html__( 'Show bottom footer menu', 'trendy-news' ),
                'section'     => 'trendy_news_bottom_footer_section',
                'settings'    => 'bottom_footer_menu_option'
            ))
        );
        // copyright text
        $wp_customize->add_setting( 'bottom_footer_site_info', array(
            'default'    => TND\trendy_news_get_customizer_default( 'bottom_footer_site_info' ),
            'sanitize_callback' => 'wp_kses_post'
        ));
        $wp_customize->add_control( 'bottom_footer_site_info', array(
                'label'	      => esc_html__( 'Copyright Text', 'trendy-news' ),
                'type'  => 'textarea',
                'description' => esc_html__( 'Add %year% to retrieve current year.', 'trendy-news' ),
                'section'     => 'trendy_news_bottom_footer_section'
            )
        );

        // upgrade info box
        $wp_customize->add_setting( 'bottom_footer_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Info_Box_Control( $wp_customize, 'bottom_footer_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'trendy-news' ),
                'description' => esc_html__( 'Copyright editor, Text color, link color and background color, gradient colors.', 'trendy-news' ),
                'section'     => TRENDY_NEWS_PREFIX . 'bottom_footer_section',
                'settings'    => 'bottom_footer_upgrade_info',
                'priority'  => 100,
                'tab'  => 'design',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'trendy-news' ),
                        'url'   => esc_url( '//blazethemes.com/theme/trendy-news-pro/' )
                    )
                )
            ))
        );
    }
    add_action( 'customize_register', 'trendy_news_customizer_bottom_footer_panel', 10 );
endif;

if( !function_exists( 'trendy_news_customizer_front_sections_panel' ) ) :
    /**
     * Register front sections settings
     * 
     */
    function trendy_news_customizer_front_sections_panel( $wp_customize ) {
        // Front sections panel
        $wp_customize->add_panel( 'trendy_news_front_sections_panel', array(
            'title' => esc_html__( 'Front sections', 'trendy-news' ),
            'priority'  => 71
        ));

        // full width content section
        $wp_customize->add_section( 'trendy_news_full_width_section', array(
            'title' => esc_html__( 'Full Width', 'trendy-news' ),
            'panel' => 'trendy_news_front_sections_panel',
            'priority'  => 10
        ));

        // full width repeater control
        $wp_customize->add_setting( 'full_width_blocks', array(
            'default'   => TND\trendy_news_get_customizer_default( 'full_width_blocks' ),
            'sanitize_callback' => 'trendy_news_sanitize_repeater_control',
            'transport' => 'postMessage'
        ));
        
        $wp_customize->add_control( 
            new Trendy_News_WP_Block_Repeater_Control( $wp_customize, 'full_width_blocks', array(
                'label'	      => esc_html__( 'Blocks to show in this section', 'trendy-news' ),
                'description' => esc_html__( 'Hold item and drag vertically to re-order blocks', 'trendy-news' ),
                'section'     => 'trendy_news_full_width_section',
                'settings'    => 'full_width_blocks'
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'full_width_blocks_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Info_Box_Control( $wp_customize, 'full_width_blocks_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'trendy-news' ),
                'description' => esc_html__( 'Unlimited news section, advertisement block, shortcode block, content background, section background color, gradient and image. Margin and padding control', 'trendy-news' ),
                'section'     => TRENDY_NEWS_PREFIX . 'full_width_section',
                'settings'    => 'full_width_blocks_upgrade_info',
                'priority'  => 100,
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'trendy-news' ),
                        'url'   => esc_url( '//blazethemes.com/theme/trendy-news-pro/' )
                    )
                )
            ))
        );

        // Left content -right sidebar section
        $wp_customize->add_section( 'trendy_news_leftc_rights_section', array(
            'title' => esc_html__( 'Left Content  - Right Sidebar', 'trendy-news' ),
            'panel' => 'trendy_news_front_sections_panel',
            'priority'  => 10
        ));

        // redirect to manage sidebar
        $wp_customize->add_setting( 'leftc_rights_section_sidebar_redirect', array(
            'sanitize_callback' => 'trendy_news_sanitize_toggle_control',
        ));
    
        $wp_customize->add_control( 
            new Trendy_News_WP_Redirect_Control( $wp_customize, 'leftc_rights_section_sidebar_redirect', array(
                'label'	      => esc_html__( 'Widgets', 'trendy-news' ),
                'section'     => 'trendy_news_leftc_rights_section',
                'settings'    => 'leftc_rights_section_sidebar_redirect',
                'tab'   => 'general',
                'choices'     => array(
                    'footer-column-one' => array(
                        'type'  => 'section',
                        'id'    => 'sidebar-widgets-front-right-sidebar',
                        'label' => esc_html__( 'Manage right sidebar', 'trendy-news' )
                    )
                )
            ))
        );

        // Block Repeater control
        $wp_customize->add_setting( 'leftc_rights_blocks', array(
            'sanitize_callback' => 'trendy_news_sanitize_repeater_control',
            'default'   => TND\trendy_news_get_customizer_default( 'leftc_rights_blocks' ),
            'transport' => 'postMessage'
        ));
        
        $wp_customize->add_control( 
            new Trendy_News_WP_Block_Repeater_Control( $wp_customize, 'leftc_rights_blocks', array(
                'label'	      => esc_html__( 'Blocks to show in this section', 'trendy-news' ),
                'description' => esc_html__( 'Hold item and drag vertically to re-order blocks', 'trendy-news' ),
                'section'     => 'trendy_news_leftc_rights_section',
                'settings'    => 'leftc_rights_blocks'
            ))
        );

        /**
         * Left sidebar - Right content section
         * 
         */
        $wp_customize->add_section( 'trendy_news_lefts_rightc_section', array(
            'title' => esc_html__( 'Left Sidebar - Right Content', 'trendy-news' ),
            'panel' => 'trendy_news_front_sections_panel',
            'priority'  => 10
        ));

        // redirect to manage sidebar
        $wp_customize->add_setting( 'lefts_rightc_section_sidebar_redirect', array(
            'sanitize_callback' => 'trendy_news_sanitize_toggle_control',
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Redirect_Control( $wp_customize, 'lefts_rightc_section_sidebar_redirect', array(
                'label'	      => esc_html__( 'Widgets', 'trendy-news' ),
                'section'     => 'trendy_news_lefts_rightc_section',
                'settings'    => 'lefts_rightc_section_sidebar_redirect',
                'tab'   => 'general',
                'choices'     => array(
                    'footer-column-one' => array(
                        'type'  => 'section',
                        'id'    => 'sidebar-widgets-front-left-sidebar',
                        'label' => esc_html__( 'Manage left sidebar', 'trendy-news' )
                    )
                )
            ))
        );

        // Block Repeater control
        $wp_customize->add_setting( 'lefts_rightc_blocks', array(
            'sanitize_callback' => 'trendy_news_sanitize_repeater_control',
            'default'   => TND\trendy_news_get_customizer_default( 'lefts_rightc_blocks' ),
            'transport' => 'postMessage'
        ));
        
        $wp_customize->add_control( 
            new Trendy_News_WP_Block_Repeater_Control( $wp_customize, 'lefts_rightc_blocks', array(
                'label'	      => esc_html__( 'Blocks to show in this section', 'trendy-news' ),
                'description' => esc_html__( 'Hold item and drag vertically to re-order blocks', 'trendy-news' ),
                'section'     => 'trendy_news_lefts_rightc_section',
                'settings'    => 'lefts_rightc_blocks'
            ))
        );

        /**
         * Bottom Full Width content section
         * 
         */
        $wp_customize->add_section( 'trendy_news_bottom_full_width_section', array(
            'title' => esc_html__( 'Bottom Full Width', 'trendy-news' ),
            'panel' => 'trendy_news_front_sections_panel',
            'priority'  => 50
        ));

        // bottom full width blocks control
        $wp_customize->add_setting( 'bottom_full_width_blocks', array(
            'sanitize_callback' => 'trendy_news_sanitize_repeater_control',
            'default'   => TND\trendy_news_get_customizer_default( 'bottom_full_width_blocks' ),
            'transport' => 'postMessage'
        ));
        
        $wp_customize->add_control( 
            new Trendy_News_WP_Block_Repeater_Control( $wp_customize, 'bottom_full_width_blocks', array(
                'label'	      => esc_html__( 'Blocks to show in this section', 'trendy-news' ),
                'description' => esc_html__( 'Hold item and drag vertically to re-order blocks', 'trendy-news' ),
                'section'     => 'trendy_news_bottom_full_width_section',
                'settings'    => 'bottom_full_width_blocks'
            ))
        );

        // front sections reorder section
        $wp_customize->add_section( 'trendy_news_front_sections_reorder_section', array(
            'title' => esc_html__( 'Reorder sections', 'trendy-news' ),
            'panel' => 'trendy_news_front_sections_panel',
            'priority'  => 60
        ));
        
        /**
         * Frontpage sections options
         * 
         * @package Trendy News
         * @since 1.0.0
         */
        $wp_customize->add_setting( 'homepage_content_order', array(
            'default'   => TND\trendy_news_get_customizer_default( 'homepage_content_order' ),
            'sanitize_callback' => 'trendy_news_sanitize_sortable_control'
        ));
        $wp_customize->add_control(
            new Trendy_News_WP_Item_Sortable_Control( $wp_customize, 'homepage_content_order', array(
                'label'         => esc_html__( 'Section Re-order', 'trendy-news' ),
                'description'   => esc_html__( 'Hold item and drag vertically to re-order the section.', 'trendy-news' ),
                'section'       => 'trendy_news_front_sections_reorder_section',
                'settings'      => 'homepage_content_order',
                'fields'    => array(
                    'full_width_section'  => array(
                        'label' => esc_html__( 'Full width Section', 'trendy-news' )
                    ),
                    'leftc_rights_section'  => array(
                        'label' => esc_html__( 'Left Content - Right Sidebar', 'trendy-news' )
                    ),
                    'lefts_rightc_section'  => array(
                        'label' => esc_html__( 'Left Sidebar - Right Content', 'trendy-news' )
                    ),
                    'bottom_full_width_section'  => array(
                        'label' => esc_html__( 'Bottom Full width Section', 'trendy-news' )
                    ),
                    'latest_posts'  => array(
                        'label' => esc_html__( 'Latest Posts / Page Content', 'trendy-news' )
                    )
                )
            ))
        );
    }
    add_action( 'customize_register', 'trendy_news_customizer_front_sections_panel', 10 );
endif;

if( !function_exists( 'trendy_news_customizer_blog_post_archive_panel' ) ) :
    /**
     * Register global options settings
     * 
     */
    function trendy_news_customizer_blog_post_archive_panel( $wp_customize ) {
        // Blog/Archive/Single panel
        $wp_customize->add_panel( 'trendy_news_blog_post_archive_panel', array(
            'title' => esc_html__( 'Blog / Archive / Single', 'trendy-news' ),
            'priority'  => 72
        ));
        
        // blog / archive section
        $wp_customize->add_section( 'trendy_news_blog_archive_section', array(
            'title' => esc_html__( 'Blog / Archive', 'trendy-news' ),
            'panel' => 'trendy_news_blog_post_archive_panel',
            'priority'  => 10
        ));

        // archive title prefix option
        $wp_customize->add_setting( 'archive_page_title_prefix', array(
            'default' => TND\trendy_news_get_customizer_default( 'archive_page_title_prefix' ),
            'sanitize_callback' => 'trendy_news_sanitize_toggle_control'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Simple_Toggle_Control( $wp_customize, 'archive_page_title_prefix', array(
                'label'	      => esc_html__( 'Show archive title prefix', 'trendy-news' ),
                'section'     => 'trendy_news_blog_archive_section',
                'settings'    => 'archive_page_title_prefix'
            ))
        );

        // archive excerpt length
        $wp_customize->add_setting( 'archive_excerpt_length', array(
            'default' => TND\trendy_news_get_customizer_default( 'archive_excerpt_length' ),
            'sanitize_callback' => 'absint'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Range_Control( $wp_customize, 'archive_excerpt_length', array(
                'label'	      => esc_html__( 'No.  of words in excerpt', 'trendy-news' ),
                'section'     => 'trendy_news_blog_archive_section',
                'settings'    => 'archive_excerpt_length',
                'input_attrs' => array(
                    'min'   => 1,
                    'max'   => 100,
                    'step'  => 1,
                    'reset' => true
                )
            ))
        );
        
        // archive elements sort
        $wp_customize->add_setting( 'archive_post_element_order', array(
            'default'   => TND\trendy_news_get_customizer_default( 'archive_post_element_order' ),
            'sanitize_callback' => 'trendy_news_sanitize_sortable_control'
        ));
        $wp_customize->add_control(
            new Trendy_News_WP_Item_Sortable_Control( $wp_customize, 'archive_post_element_order', array(
                'label'         => esc_html__( 'Elements show/hide', 'trendy-news' ),
                'section'       => 'trendy_news_blog_archive_section',
                'settings'      => 'archive_post_element_order',
                'tab'   => 'general',
                'fields'    => array(
                    'title'  => array(
                        'label' => esc_html__( 'Title', 'trendy-news' )
                    ),
                    'meta'  => array(
                        'label' => esc_html__( 'Meta', 'trendy-news' )
                    ),
                    'excerpt'  => array(
                        'label' => esc_html__( 'Excerpt', 'trendy-news' )
                    ),
                    'button'  => array(
                        'label' => esc_html__( 'Button', 'trendy-news' )
                    ),
                )
            ))
        );

        // archive meta sort
        $wp_customize->add_setting( 'archive_post_meta_order', array(
            'default'   => TND\trendy_news_get_customizer_default( 'archive_post_meta_order' ),
            'sanitize_callback' => 'trendy_news_sanitize_sortable_control'
        ));
        $wp_customize->add_control(
            new Trendy_News_WP_Item_Sortable_Control( $wp_customize, 'archive_post_meta_order', array(
                'label'         => esc_html__( 'Meta show/hide', 'trendy-news' ),
                'section'       => 'trendy_news_blog_archive_section',
                'settings'      => 'archive_post_meta_order',
                'tab'   => 'general',
                'fields'    => array(
                    'author'  => array(
                        'label' => esc_html__( 'Author Name', 'trendy-news' )
                    ),
                    'date'  => array(
                        'label' => esc_html__( 'Published/Modified Date', 'trendy-news' )
                    ),
                    'comments'  => array(
                        'label' => esc_html__( 'Comments Number', 'trendy-news' )
                    ),
                    'read-time'  => array(
                        'label' => esc_html__( 'Read Time', 'trendy-news' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'archive_post_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Info_Box_Control( $wp_customize, 'archive_post_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'trendy-news' ),
                'description' => esc_html__( 'AJAX pagination, list and grid layout, element reorder and content background, ', 'trendy-news' ),
                'section'     => TRENDY_NEWS_PREFIX . 'blog_archive_section',
                'settings'    => 'archive_post_upgrade_info',
                'priority'  => 100,
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'trendy-news' ),
                        'url'   => esc_url( '//blazethemes.com/theme/trendy-news-pro/' )
                    )
                )
            ))
        );

        //  single post section
        $wp_customize->add_section( 'trendy_news_single_post_section', array(
            'title' => esc_html__( 'Single Post', 'trendy-news' ),
            'panel' => 'trendy_news_blog_post_archive_panel',
            'priority'  => 20
        ));
        
        // single elements sort
        $wp_customize->add_setting( 'single_post_element_order', array(
            'default'   => TND\trendy_news_get_customizer_default( 'single_post_element_order' ),
            'sanitize_callback' => 'trendy_news_sanitize_sortable_control'
        ));
        $wp_customize->add_control(
            new Trendy_News_WP_Item_Sortable_Control( $wp_customize, 'single_post_element_order', array(
                'label'         => esc_html__( 'Elements show/hide', 'trendy-news' ),
                'section'       => 'trendy_news_single_post_section',
                'settings'      => 'single_post_element_order',
                'tab'   => 'general',
                'fields'    => array(
                    'categories'  => array(
                        'label' => esc_html__( 'Categories', 'trendy-news' )
                    ),
                    'title'  => array(
                        'label' => esc_html__( 'Title', 'trendy-news' )
                    ),
                    'meta'  => array(
                        'label' => esc_html__( 'Meta', 'trendy-news' )
                    ),
                    'thumbnail'  => array(
                        'label' => esc_html__( 'Featured Image', 'trendy-news' )
                    )
                )
            ))
        );

        // single meta sort
        $wp_customize->add_setting( 'single_post_meta_order', array(
            'default'   => TND\trendy_news_get_customizer_default( 'single_post_meta_order' ),
            'sanitize_callback' => 'trendy_news_sanitize_sortable_control'
        ));
        $wp_customize->add_control(
            new Trendy_News_WP_Item_Sortable_Control( $wp_customize, 'single_post_meta_order', array(
                'label'         => esc_html__( 'Meta show/hide', 'trendy-news' ),
                'section'       => 'trendy_news_single_post_section',
                'settings'      => 'single_post_meta_order',
                'tab'   => 'general',
                'fields'    => array(
                    'author'  => array(
                        'label' => esc_html__( 'Author Name', 'trendy-news' )
                    ),
                    'date'  => array(
                        'label' => esc_html__( 'Published/Modified Date', 'trendy-news' )
                    ),
                    'comments'  => array(
                        'label' => esc_html__( 'Comments Number', 'trendy-news' )
                    ),
                    'read-time'  => array(
                        'label' => esc_html__( 'Read Time', 'trendy-news' )
                    )
                )
            ))
        );

        // single post related news heading
        $wp_customize->add_setting( 'single_post_related_posts_header', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Section_Heading_Control( $wp_customize, 'single_post_related_posts_header', array(
                'label'	      => esc_html__( 'Related News', 'trendy-news' ),
                'section'     => 'trendy_news_single_post_section',
                'settings'    => 'single_post_related_posts_header'
            ))
        );

        // related news option
        $wp_customize->add_setting( 'single_post_related_posts_option', array(
            'default'   => TND\trendy_news_get_customizer_default( 'single_post_related_posts_option' ),
            'sanitize_callback' => 'trendy_news_sanitize_toggle_control',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Simple_Toggle_Control( $wp_customize, 'single_post_related_posts_option', array(
                'label'	      => esc_html__( 'Show related news', 'trendy-news' ),
                'section'     => 'trendy_news_single_post_section',
                'settings'    => 'single_post_related_posts_option'
            ))
        );

        // related news title
        $wp_customize->add_setting( 'single_post_related_posts_title', array(
            'default' => TND\trendy_news_get_customizer_default( 'single_post_related_posts_title' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 'single_post_related_posts_title', array(
            'type'      => 'text',
            'section'   => 'trendy_news_single_post_section',
            'label'     => esc_html__( 'Related news title', 'trendy-news' )
        ));

        // show related posts on popup
        $wp_customize->add_setting( 'single_post_related_posts_popup_option', array(
            'default'   => TND\trendy_news_get_customizer_default( 'single_post_related_posts_popup_option' ),
            'sanitize_callback' => 'trendy_news_sanitize_toggle_control'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Checkbox_Control( $wp_customize, 'single_post_related_posts_popup_option', array(
                'label'	      => esc_html__( 'Show related post on popup box', 'trendy-news' ),
                'section'     => 'trendy_news_single_post_section',
                'settings'    => 'single_post_related_posts_popup_option'
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'single_post_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Trendy_News_WP_Info_Box_Control( $wp_customize, 'single_post_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'trendy-news' ),
                'description' => esc_html__( 'List and grid layout, element reorder, typography and content background, ', 'trendy-news' ),
                'section'     => TRENDY_NEWS_PREFIX . 'single_post_section',
                'settings'    => 'single_post_upgrade_info',
                'priority'  => 100,
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'trendy-news' ),
                        'url'   => esc_url( '//blazethemes.com/theme/trendy-news-pro/' )
                    )
                )
            ))
        );
    }
    add_action( 'customize_register', 'trendy_news_customizer_blog_post_archive_panel', 10 );
endif;

// extract to the customizer js
$trendyNewsAddAction = function() {
    $action_prefix = "wp_ajax_" . "trendy_news_";
    // retrieve posts with search key
    add_action( $action_prefix . 'get_multicheckbox_posts_simple_array', function() {
        check_ajax_referer( 'trendy-news-customizer-controls-live-nonce', 'security' );
        $searchKey = isset($_POST['search']) ? sanitize_text_field(wp_unslash($_POST['search'])): '';
        $posts_list = get_posts(array('numberposts'=>-1, 's'=>esc_html($searchKey)));
        foreach( $posts_list as $postItem ) :
            $posts_array[] = array( 
                'value'	=> esc_html( $postItem->post_name ),
                'label'	=> esc_html(str_replace(array('\'', '"'), '', $postItem->post_title))
            );
        endforeach;
        wp_send_json_success($posts_array);
        wp_die();
    });
    // site background color
    add_action( $action_prefix . 'site_background_color', function() {
        check_ajax_referer( 'trendy-news-customizer-nonce', 'security' );
		// enqueue inline style
		ob_start();
            trendy_news_get_background_style_var('--site-bk-color', 'site_background_color');
		$site_background_color = ob_get_clean();
		echo apply_filters( 'trendy_news_site_background_color', wp_strip_all_tags($site_background_color) );
		wp_die();
	});
    // site border top
    add_action( $action_prefix . 'customizer_site_block_border_top', function() {
        check_ajax_referer( 'trendy-news-customizer-nonce', 'security' );
        ob_start();
            trendy_news_assign_var( "--theme-block-top-border-color", "website_block_border_top_color" );
        $site_block_border_top = ob_get_clean();
        echo apply_filters( 'site_block_border_top', wp_strip_all_tags($site_block_border_top) );
        wp_die();
    });
    // site logo styles
    add_action( $action_prefix . 'site_logo_styles', function() {
        check_ajax_referer( 'trendy-news-customizer-nonce', 'security' );
		// enqueue inline style
		ob_start();
            trendy_news_site_logo_width_fnc("body .site-branding img.custom-logo", 'trendy_news_site_logo_width');
		$site_logo_styles = ob_get_clean();
		echo apply_filters( 'trendy_news_site_logo_styles', wp_strip_all_tags($site_logo_styles) );
		wp_die();
	});
    // site title typo
    add_action( $action_prefix . 'site_title_typo', function() {
        check_ajax_referer( 'trendy-news-customizer-nonce', 'security' );
		// enqueue inline style
		ob_start();
            trendy_news_get_typo_style( "--site-title", 'site_title_typo' );
		$site_title_typo = ob_get_clean();
		echo apply_filters( 'trendy_news_site_title_typo', wp_strip_all_tags($site_title_typo) );
		wp_die();
	});
    // top header styles
    add_action( $action_prefix . 'top_header_styles', function() {
        check_ajax_referer( 'trendy-news-customizer-nonce', 'security' );
		// enqueue inline style
		ob_start();
            trendy_news_border_option('body .site-header.layout--default .top-header','top_header_bottom_border', 'border-bottom');
            trendy_news_get_background_style('.tn_main_body .site-header.layout--default .top-header','top_header_background_color_group');
		$top_header_styles = ob_get_clean();
		echo apply_filters( 'trendy_news_top_header_styles', wp_strip_all_tags($top_header_styles) );
		wp_die();
	});
    // header styles
    add_action( $action_prefix . 'header_styles', function() {
        check_ajax_referer( 'trendy-news-customizer-nonce', 'security' );
		// enqueue inline style
		ob_start();
            trendy_news_get_background_style('body .site-header.layout--default .site-branding-section', 'header_background_color_group');
			trendy_news_header_padding('--header-padding', 'header_vertical_padding');
		$header_styles = ob_get_clean();
		echo apply_filters( 'trendy_news_header_styles', wp_strip_all_tags($header_styles) );
		wp_die();
	});
    // header menu styles
    add_action( $action_prefix . 'header_menu_styles', function() {
        check_ajax_referer( 'trendy-news-customizer-nonce', 'security' );
		// enqueue inline style
		ob_start();
            trendy_news_get_background_style('.tn_main_body .site-header.layout--default .menu-section','header_menu_background_color_group');
		$header_menu_styles = ob_get_clean();
		echo apply_filters( 'trendy_news_header_menu_styles', wp_strip_all_tags($header_menu_styles) );
		wp_die();
	});
    // header border styles
    add_action( $action_prefix . 'header_border_styles', function() {
        check_ajax_referer( 'trendy-news-customizer-nonce', 'security' );
		// enqueue inline style
		ob_start();
            trendy_news_border_option('body .site-header.layout--default .menu-section .row', 'header_menu_top_border', 'border-top');
            trendy_news_border_option('body .menu-section', 'header_menu_bottom_border', 'border-bottom');
        $header_border_bottom_styles = ob_get_clean();
		echo apply_filters( 'trendy_news_header_border_styles', wp_strip_all_tags($header_border_bottom_styles) );
		wp_die();
	});
    // stt buttons styles
    add_action( $action_prefix . 'stt_buttons__styles', function() {
        check_ajax_referer( 'trendy-news-customizer-nonce', 'security' );
		// enqueue inline style
		ob_start();
			trendy_news_visibility_options('body #tn-scroll-to-top.show','stt_responsive_option');
			trendy_news_font_size_style("--move-to-top-font-size", 'stt_font_size');
			trendy_news_border_option('body #tn-scroll-to-top', 'stt_border');
			trendy_news_get_responsive_spacing_style( 'body #tn-scroll-to-top' , 'stt_padding', 'padding' );
			trendy_news_text_color_var('--move-to-top-color','stt_color_group');
			trendy_news_text_color_var('--move-to-top-background-color','stt_background_color_group');
        $trendy_news_stt_buttons__styles = ob_get_clean();
		echo apply_filters( 'trendy_news_stt_buttons__styles', wp_strip_all_tags($trendy_news_stt_buttons__styles) );
		wp_die();
	});
    // footer styles
    add_action( $action_prefix . 'footer__styles', function() {
        check_ajax_referer( 'trendy-news-customizer-nonce', 'security' );
		// enqueue inline style
		ob_start();
			trendy_news_border_option('body .site-footer.dark_bk','footer_top_border', 'border-top');
        $trendy_news_footer__styles = ob_get_clean();
		echo apply_filters( 'trendy_news_footer__styles', wp_strip_all_tags($trendy_news_footer__styles) );
		wp_die();
	});
    // typography fonts url
    add_action( $action_prefix . 'typography_fonts_url', function() {
        check_ajax_referer( 'trendy-news-customizer-nonce', 'security' );
		// enqueue inline style
		ob_start();
			echo esc_url( trendy_news_typo_fonts_url() );
        $trendy_news_typography_fonts_url = ob_get_clean();
		echo apply_filters( 'trendy_news_typography_fonts_url', esc_url($trendy_news_typography_fonts_url) );
		wp_die();
	});
};
$trendyNewsAddAction();

add_action( 'wp_ajax_trendy_news_customizer_reset_to_default', function () {
    check_ajax_referer( 'trendy-news-customizer-controls-nonce', 'security' );
    /**
     * Filter the settings that will be removed.
     *
     * @param array $settings Theme modifications.
     * @return array
     * @since 1.1.0
     */
    remove_theme_mods();
    wp_send_json_success();
});