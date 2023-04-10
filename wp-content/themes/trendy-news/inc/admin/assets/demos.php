<?php
/**
 * List of demos json
 *
 * @package Trendy News
 * @since 1.0.0
 */
$demos_array = array(
    'trendy-news' => array(
        'name' => 'Default',
        'type' => 'free',
        'external_url' => 'https://demo.blazethemes.com/import-files/trendy-news/trendy-news.zip',
        'image' => 'https://blazethemes.com/wp-content/uploads/2022/10/Trendy-News-main-demo-free.jpg',
        'preview_url' => 'https://demo.blazethemes.com/trendy-news-one/',
        'menu_array' => array(
            'menu-1' => 'Top Header Menu',
            'menu-2' => 'Header Menu',
            'menu-3' => 'Bottom Footer Menu'
        ),
        'home_slug' => '',
        'blog_slug' => '',
        'plugins' => array(
            'email-subscribers' => array(
                'name' => 'Email Subscribers',
                'source' => 'wordpress',
                'file_path' => 'email-subscribers/email-subscribers.php'
            )
        ),
        'tags' => array(
            'free' => 'Free'
        )
    ),
    'trendy-news-two' => array(
        'name' => 'Demo Two',
        'type' => 'free',
        'external_url' => 'https://demo.blazethemes.com/import-files/trendy-news/trendy-news-two.zip',
        'image' => 'https://blazethemes.com/wp-content/uploads/2022/11/Trendy-News-two.jpg',
        'preview_url' => 'https://demo.blazethemes.com/trendy-news-two/',
        'menu_array' => array(
            'menu-2' => 'Header',
            'menu-3' => 'Bottom Footer'
        ),
        'home_slug' => '',
        'blog_slug' => '',
        'plugins' => array(),
        'tags' => array(
            'free' => 'Free'
        )
    ),
    'trendy-news-pro' => array(
        'name' => 'Default',
        'type' => 'pro',
        'buy_url'=> 'https://blazethemes.com/theme/trendy-news-pro/',
        'external_url' => 'https://demo.blazethemes.com/import-files/trendy-news/trendy-news-pro.zip',
        'image' => 'https://blazethemes.com/wp-content/uploads/2022/10/Trendy-News-One.jpg',
        'preview_url' => 'https://demo.blazethemes.com/trendy-news-pro-one/',
        'menu_array' => array(
            'menu-1' => 'Top Header Menu',
            'menu-2' => 'Header Menu',
            'menu-3' => 'Bottom Footer Menu'
        ),
        'home_slug' => '',
        'blog_slug' => '',
        'plugins' => array(),
        'tags' => array(
            'pro' => 'Pro'
        )
    ),
    'trendy-news-pro-two' => array(
        'name' => 'Demo Two',
        'type' => 'pro',
        'buy_url'=> 'https://blazethemes.com/theme/trendy-news-pro/',
        'external_url' => 'https://demo.blazethemes.com/import-files/trendy-news/trendy-news-pro-two.zip',
        'image' => 'https://blazethemes.com/wp-content/uploads/2022/10/Trendy-news-demo-preview-two.jpg',
        'preview_url' => 'https://demo.blazethemes.com/trendy-news-pro-two/',
        'menu_array' => array(
            'menu-2' => 'Header Menu',
            'menu-3' => 'Bottom Menu'
        ),
        'home_slug' => '',
        'blog_slug' => '',
        'plugins' => array(),
        'tags' => array(
            'pro' => 'Pro'
        )
    ),
    'trendy-news-pro-three' => array(
        'name' => 'World News',
        'type' => 'pro',
        'buy_url'=> 'https://blazethemes.com/theme/trendy-news-pro/',
        'external_url' => 'https://demo.blazethemes.com/import-files/trendy-news/trendy-news-pro-three.zip',
        'image' => 'https://blazethemes.com/wp-content/uploads/2022/10/Trendy-News-Demo-Preview-Three.jpg',
        'preview_url' => 'https://demo.blazethemes.com/trendy-news-pro-three/',
        'menu_array' => array(
            'menu-2' => 'Top Menu',
            'menu-2' => 'Header Menu',
            'menu-3' => 'Bottom menu'
        ),
        'home_slug' => '',
        'blog_slug' => '',
        'plugins' => array(),
        'tags' => array(
            'pro' => 'Pro'
        )
    ),
    'trendy-news-pro-four' => array(
        'name' => 'Color News',
        'type' => 'pro',
        'buy_url'=> 'https://blazethemes.com/theme/trendy-news-pro/',
        'external_url' => 'https://demo.blazethemes.com/import-files/trendy-news/trendy-news-pro-four.zip',
        'image' => 'https://blazethemes.com/wp-content/uploads/2022/10/Trendy-News-demo-preview-four.jpg',
        'preview_url' => 'https://demo.blazethemes.com/trendy-news-pro-four/',
        'menu_array' => array(
            'menu-2' => 'Top Header',
            'menu-2' => 'Header',
            'menu-3' => 'Bottom Footer'
        ),
        'home_slug' => '',
        'blog_slug' => '',
        'plugins' => array(),
        'tags' => array(
            'pro' => 'Pro'
        )
    ),
    'trendy-news-pro-five' => array(
        'name' => 'Arabic News',
        'type' => 'pro',
        'buy_url'=> 'https://blazethemes.com/theme/trendy-news-pro/',
        'external_url' => 'https://demo.blazethemes.com/import-files/trendy-news/trendy-news-pro-five.zip',
        'image' => 'https://blazethemes.com/wp-content/uploads/2022/11/Trendy-demo-preview-arabic.jpg',
        'preview_url' => 'https://demo.blazethemes.com/trendy-news-pro-five/',
        'menu_array' => array(
            'menu-2' => 'Top Menu',
            'menu-2' => 'Header Menu',
            'menu-3' => 'Bottom Footer Menu'
        ),
        'home_slug' => '',
        'blog_slug' => '',
        'plugins' => array(),
        'tags' => array(
            'pro' => 'Pro'
        )
    )
);
return apply_filters( 'trendy_news__demos_array_filter', $demos_array );