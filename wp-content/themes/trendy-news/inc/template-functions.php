<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Trendy News
 */
use TrendyNews\CustomizerDefault as TND;
/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function trendy_news_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}
	
	$classes[] = esc_attr( 'trendy-news-title-' . TND\trendy_news_get_customizer_option( 'post_title_hover_effects'  ) ); // post title hover effects
	$classes[] = esc_attr( 'trendy-news-image-hover--effect-' . TND\trendy_news_get_customizer_option( 'site_image_hover_effects' ) ); // site image hover effects
	$classes[] = esc_attr( 'site-' . TND\trendy_news_get_customizer_option( 'website_layout' ) ); // site layout
	if( TND\trendy_news_get_customizer_option( 'website_block_border_top_option' ) ) $classes[] = esc_attr( 'tn_site_block_border_top' ); // block border top
	
	// page layout
	if( is_page() || is_404() || is_search() ) :
		if( is_front_page() ) {
			$frontpage_sidebar_layout = TND\trendy_news_get_customizer_option( 'frontpage_sidebar_layout' );
			$frontpage_sidebar_sticky_option = TND\trendy_news_get_customizer_option( 'frontpage_sidebar_sticky_option' );
			if( $frontpage_sidebar_sticky_option ) $classes[] = esc_attr( 'sidebar-sticky' );
			$classes[] = esc_attr( $frontpage_sidebar_layout );
		} else {
			$page_sidebar_layout = TND\trendy_news_get_customizer_option( 'page_sidebar_layout' );
			$page_sidebar_sticky_option = TND\trendy_news_get_customizer_option( 'page_sidebar_sticky_option' );
			if( $page_sidebar_sticky_option ) $classes[] = esc_attr( 'sidebar-sticky' );
			$classes[] = esc_attr( $page_sidebar_layout );
		}
	endif;

	// single post layout
	if( is_single() ) :
		$single_sidebar_layout = TND\trendy_news_get_customizer_option( 'single_sidebar_layout' );
		$single_sidebar_sticky_option = TND\trendy_news_get_customizer_option( 'single_sidebar_sticky_option' );
		if( $single_sidebar_sticky_option ) $classes[] = esc_attr( 'sidebar-sticky' );
		$classes[] = esc_attr( $single_sidebar_layout );
	endif;

	// archive layout
	if( is_archive() || is_home() ) :
		$archive_sidebar_layout = TND\trendy_news_get_customizer_option( 'archive_sidebar_layout' );
		$archive_sidebar_sticky_option = TND\trendy_news_get_customizer_option( 'archive_sidebar_sticky_option' );
		if( $archive_sidebar_sticky_option ) $classes[] = esc_attr( 'sidebar-sticky' );
		$classes[] = 'post-layout--one';
		$classes[] = esc_attr( $archive_sidebar_layout );
	endif;
	
	$classes[] = 'tn_main_body tn_font_typography';
	return $classes;
}
add_filter( 'body_class', 'trendy_news_body_classes' );


/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function trendy_news_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'trendy_news_pingback_header' );

//define constant
define( 'TRENDY_NEWS_INCLUDES_PATH', get_template_directory() . '/inc/' );

/**
 * Enqueue theme scripts and styles.
 */
function trendy_news_scripts() {
	global $wp_query;
	require_once get_theme_file_path( 'inc/wptt-webfont-loader.php' );
	wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/assets/lib/fontawesome/css/all.min.css', array(), '5.15.3', 'all' );
	wp_enqueue_style( 'slick', get_template_directory_uri() . '/assets/lib/slick/slick.css', array(), '1.8.1', 'all' );
	wp_enqueue_style( 'trendy-news-typo-fonts', wptt_get_webfont_url( trendy_news_typo_fonts_url() ), array(), null );
	wp_enqueue_style( 'trendy-news-style', get_stylesheet_uri(), array(), TRENDY_NEWS_VERSION );
	wp_enqueue_style( 'trendy-news-main-style', get_template_directory_uri().'/assets/css/main.css', array(), TRENDY_NEWS_VERSION );
	wp_enqueue_style( 'trendy-news-loader-style', get_template_directory_uri().'/assets/css/loader.css', array(), TRENDY_NEWS_VERSION );
	wp_enqueue_style( 'trendy-news-responsive-style', get_template_directory_uri().'/assets/css/responsive.css', array(), TRENDY_NEWS_VERSION );
	wp_style_add_data( 'trendy-news-style', 'rtl', 'replace' );
	
	// enqueue inline style
	wp_add_inline_style( 'trendy-news-style', trendy_news_current_styles() );
	wp_enqueue_script( 'slick', get_template_directory_uri() . '/assets/lib/slick/slick.min.js', array( 'jquery' ), '1.8.1', true );
	wp_enqueue_script( 'js-marquee', get_template_directory_uri() . '/assets/lib/js-marquee/jquery.marquee.min.js', array( 'jquery' ), '1.6.0', true );
	wp_enqueue_script( 'trendy-news-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), TRENDY_NEWS_VERSION, true );
	wp_enqueue_script( 'trendy-news-theme', get_template_directory_uri() . '/assets/js/theme.js', array( 'jquery' ), TRENDY_NEWS_VERSION, true );
	wp_enqueue_script( 'waypoint', get_template_directory_uri() . '/assets/lib/waypoint/jquery.waypoint.min.js', array( 'jquery' ), '4.0.1', true );

	$scriptVars['_wpnonce'] = wp_create_nonce( 'trendy-news-nonce' );
	$scriptVars['ajaxUrl'] 	= admin_url('admin-ajax.php');
	$scriptVars['stt']	= TND\trendy_news_get_multiselect_tab_option('stt_responsive_option');
	$scriptVars['stickey_header']= TND\trendy_news_get_customizer_option('theme_header_sticky');

	// localize scripts
	wp_localize_script( 'trendy-news-theme', 'trendyNewsObject' , $scriptVars);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'trendy_news_scripts' );

if( ! function_exists( 'trendy_news_current_styles' ) ) :
	/**
	 * Generates the current changes in styling of the theme.
	 * 
	 * @package Trendy News
	 * @since 1.0.0
	 */
	function trendy_news_current_styles() {
		// enqueue inline style
		ob_start();
			// inline style call
			$tnPresetCode = function($var,$id) {
				trendy_news_assign_preset_var($var,$id);
			};
			$tnPresetCode( "--tn-global-preset-color-1", "preset_color_1" );
			$tnPresetCode( "--tn-global-preset-color-2", "preset_color_2" );
			$tnPresetCode( "--tn-global-preset-color-3", "preset_color_3" );
			$tnPresetCode( "--tn-global-preset-color-4", "preset_color_4" );
			$tnPresetCode( "--tn-global-preset-color-5", "preset_color_5" );
			$tnPresetCode( "--tn-global-preset-color-6", "preset_color_6" );
			$tnPresetCode( "--tn-global-preset-gradient-color-1", "preset_gradient_1" );
			$tnPresetCode( "--tn-global-preset-gradient-color-2", "preset_gradient_2" );
			$tnPresetCode( "--tn-global-preset-gradient-color-3", "preset_gradient_3" );
			$tnPresetCode( "--tn-global-preset-gradient-color-4", "preset_gradient_4" );
			$tnPresetCode( "--tn-global-preset-gradient-color-5", "preset_gradient_5" );
			$tnPresetCode( "--tn-global-preset-gradient-color-6", "preset_gradient_6" );
			trendy_news_header_padding('--header-padding', 'header_vertical_padding');
			if( TND\trendy_news_get_customizer_option('website_block_border_top_option') ) :
				trendy_news_assign_var( "--theme-block-top-border-color", "website_block_border_top_color" );
			endif;
			$tnBackgroundCode = function($identifier,$id) {
				trendy_news_get_background_style($identifier,$id);
			};
			trendy_news_border_option('body .site-header.layout--default .top-header','top_header_bottom_border', 'border-bottom');
			$tnBackgroundCode('.tn_main_body .site-header.layout--default .top-header','top_header_background_color_group');
			$tnBackgroundCode('.tn_main_body .site-header.layout--default .menu-section, .tn_main_body .main-navigation ul.menu ul, .tn_main_body .main-navigation ul.nav-menu ul ','header_menu_background_color_group');
			$tnSpacingCode = function($identifier,$id, $property = 'margin') {
				trendy_news_get_responsive_spacing_style($identifier,$id, $property);
			};
			$tnTypoCode = function($identifier,$id) {
				trendy_news_get_typo_style($identifier,$id);
			};
			$tnTypoCode( "--site-title", 'site_title_typo' );
			trendy_news_site_logo_width_fnc("body .site-branding img.custom-logo", 'trendy_news_site_logo_width');
			$tnColorGroupCode = function($identifier,$id,$property='color') {
				trendy_news_color_options_one($identifier,$id,$property);
			};
			$tnColorCode = function($identifier,$id) {
				trendy_news_text_color_var($identifier,$id);
			};
			trendy_news_get_background_style_var('--site-bk-color', 'site_background_color');
			$tnColorCode('--move-to-top-background-color','stt_background_color_group');
			$tnColorCode('--move-to-top-color','stt_color_group');
			trendy_news_visibility_options('.ads-banner','header_ads_banner_responsive_option');
			$tnSpacingCode( 'body #tn-scroll-to-top' , 'stt_padding', 'padding' );
			trendy_news_visibility_options('body #tn-scroll-to-top.show','stt_responsive_option');
			trendy_news_border_option('body #tn-scroll-to-top', 'stt_border');
			trendy_news_border_option('body .menu-section .row', 'header_menu_bottom_border', 'border-bottom');
			trendy_news_border_option('body .site-header.layout--default .menu-section .row', 'header_menu_top_border', 'border-top');
			trendy_news_font_size_style("--move-to-top-font-size", 'stt_font_size');
			trendy_news_border_option('body .site-footer.dark_bk','footer_top_border', 'border-top');
			$tnBackgroundCode('body .site-header.layout--default .site-branding-section', 'header_background_color_group');
			trendy_news_theme_color('--theme-color-red','theme_color');
		
			trendy_news_top_border_color('.tn_main_body .main-navigation ul.menu ul li, .tn_main_body  .main-navigation ul.nav-menu ul li a, .tn_main_body .main-navigation ul.menu ul, .tn_main_body .main-navigation ul.nav-menu ul','header_menu_background_color_group');
			trendy_news_get_background_style_responsive('.tn_main_body nav.main-navigation ul.menu, .tn_main_body nav.main-navigation ul.nav-menu', 'header_menu_background_color_group');
			trendy_news_category_colors_styles();
			$current_styles = ob_get_clean();
		return apply_filters( 'trendy_news_current_styles', wp_strip_all_tags($current_styles) );
	}
endif;

if( ! function_exists( 'trendy_news_customizer_social_icons' ) ) :
	/**
	 * Functions get social icons
	 * 
	 */
	function trendy_news_customizer_social_icons() {
		$social_icons = TND\trendy_news_get_customizer_option( 'social_icons' );
		$social_icons_target = TND\trendy_news_get_customizer_option( 'social_icons_target' );
		$decoded_social_icons = json_decode( $social_icons );
		echo '<div class="social-icons">';
			foreach( $decoded_social_icons as $icon ) :
				if( $icon->item_option === 'show' ) {
		?>
					<a class="social-icon" href="<?php echo esc_url( $icon->icon_url ); ?>" target="<?php echo esc_attr( $social_icons_target ); ?>"><i class="<?php echo esc_attr( $icon->icon_class ); ?>"></i></a>
		<?php
				}
			endforeach;
		echo '</div>';
	}
endif;

if( ! function_exists( 'trendy_news_get_multicheckbox_categories_array' ) ) :
	/**
	 * Return array of categories prepended with "*" key.
	 * 
	 */
	function trendy_news_get_multicheckbox_categories_array() {
		$categories_list = get_categories();
		foreach( $categories_list as $cat ) :
			$cats_array[esc_html( $cat->slug )]= esc_html( $cat->name )  . ' (' .absint( $cat->count ). ')';
		endforeach;
		return $cats_array;
	}
endif;

if( ! function_exists( 'trendy_news_get_multicheckbox_categories_simple_array' ) ) :
	/**
	 * Return array of categories prepended with "*" key.
	 * 
	 */
	function trendy_news_get_multicheckbox_categories_simple_array() {
		$categories_list = get_categories();
		foreach( $categories_list as $cat ) :
			$cats_array[] = array( 
				'value'	=> esc_html( $cat->slug ),
				'label'	=> esc_html(str_replace(array('\'', '"'), '', $cat->name))  . ' (' .absint( $cat->count ). ')'
			);
		endforeach;
		return $cats_array;
	}
endif;

if( ! function_exists( 'trendy_news_get_multicheckbox_posts_simple_array' ) ) :
	/**
	 * Return array of posts prepended with "*" key.
	 * 
	 */
	function trendy_news_get_multicheckbox_posts_simple_array() {
		$posts_list = get_posts(array('numberposts'=>4));
		foreach( $posts_list as $postItem ) :
			$posts_array[] = array( 
				'value'	=> esc_html( $postItem->post_name ),
				'label'	=> esc_html(str_replace(array('\'', '"'), '', $postItem->post_title))
			);
		endforeach;
		return $posts_array;
	}
endif;

if( ! function_exists( 'trendy_news_get_date_filter_choices_array' ) ) :
	/**
	 * Return array of date filter choices.
	 * 
	 */
	function trendy_news_get_date_filter_choices_array() {
		return apply_filters( 'trendy_news_get_date_filter_choices_array_filter', array(
			array(
				'value' => 'all',
				'label' => esc_html__('All', 'trendy-news' )
			),
			array(
				'value' => 'last-seven-days',
				'label' => esc_html__('Last 7 days', 'trendy-news' )
			),
			array(
				'value' => 'today',
				'label' => esc_html__('Today', 'trendy-news' )
			),
			array(
				'value' => 'this-week',
				'label' => esc_html__('This Week', 'trendy-news' )
			),
			array(
				'value' => 'last-week',
				'label' => esc_html__('Last Week', 'trendy-news' )
			),
			array(
				'value' => 'this-month',
				'label' => esc_html__('This Month', 'trendy-news' )
			),
			array(
				'value' => 'last-month',
				'label' => esc_html__('Last Month', 'trendy-news' )
			)
		));
	}
endif;

if( ! function_exists( 'trendy_news_get_array_key_string_to_int' ) ) :
	/**
	 * Return array of int values.
	 * 
	 */
	function trendy_news_get_array_key_string_to_int( $array ) {
		if( ! isset( $array ) || empty( $array ) ) return;
		$filtered_array = array_map( function($arr) {
			if( is_numeric( $arr ) ) return (int) $arr;
		}, $array);
		return apply_filters( 'trendy_news_array_with_int_values', $filtered_array );
	}
endif;

/**
 * Return string with "implode" execution in param
 * 
 */
 function trendy_news_get_categories_for_args($array) {
	if( ! $array ) return apply_filters( 'trendy_news_categories_for_argument', '' );
	foreach( $array as $value ) {
		$string_array[] = $value->value;
	}
	return apply_filters( 'trendy_news_categories_for_argument', implode( ',', $string_array ) );
}

/**
 * Return array with execution in param
 * 
 */
function trendy_news_get_post_slugs_for_args($array) {
	if( ! $array ) return apply_filters( 'trendy_news_posts_slugs_for_argument', '' );
	foreach( $array as $value ) {
		$string_array[] = $value->value;
	}
	return apply_filters( 'trendy_news_posts_slugs_for_argument', $string_array );
}

if( !function_exists( 'trendy_news_typo_fonts_url' ) ) :
	/**
	 * Filter and Enqueue typography fonts
	 * 
	 * @package Trendy News
	 * @since 1.0.0
	 */
	function trendy_news_typo_fonts_url() {
		$filter = TRENDY_NEWS_PREFIX . 'typo_combine_filter';
		$action = function($filter,$id) {
			return apply_filters(
				$filter,
				$id
			);
		};
		$site_title_typo_value = $action($filter,'site_title_typo');
		$typo1 = "Open Sans:400,500,600,700";
		$typo2 = "Encode Sans Condensed:300,400,500,600,700";
		$typo3 = "Poppins:300,400,500,600,700";
		$typo4 = "Cabin:400,500,600,700";

		$get_fonts = apply_filters( 'trendy_news_get_fonts_toparse', [$site_title_typo_value, $typo1, $typo2, $typo3, $typo4] );
		$font_weight_array = array();

		foreach ( $get_fonts as $fonts ) {
			$each_font = explode( ':', $fonts );
			if ( ! isset ( $font_weight_array[$each_font[0]] ) ) {
				$font_weight_array[$each_font[0]][] = $each_font[1];
			} else {
				if ( ! in_array( $each_font[1], $font_weight_array[$each_font[0]] ) ) {
					$font_weight_array[$each_font[0]][] = $each_font[1];
				}
			}
		}
		$final_font_array = array();
		foreach ( $font_weight_array as $font => $font_weight ) {
			$each_font_string = $font.':'.implode( ',', $font_weight );
			$final_font_array[] = $each_font_string;
		}

		$final_font_string = implode( '|', $final_font_array );
		$google_fonts_url = '';
		$subsets   = 'cyrillic,cyrillic-ext';
		if ( $final_font_string ) {
			$query_args = array(
				'family' => urlencode( $final_font_string ),
				'subset' => urlencode( $subsets )
			);
			$google_fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
		}
		return $google_fonts_url;
	}
endif;

if(! function_exists('trendy_news_get_color_format')):
    function trendy_news_get_color_format($color){
      if( str_contains( $color, '--tn-global-preset' ) || str_contains( $color, '--theme-color-red' ) ) {
        return( 'var( ' .esc_html( $color ). ' )' );
      }else{
        return $color;
      }
    }
endif;

require get_template_directory() . '/inc/theme-starter.php'; // theme starter functions.
require get_template_directory() . '/inc/customizer/customizer.php'; // Customizer additions.
require get_template_directory() . '/inc/extras/helpers.php'; // helpers files.
require get_template_directory() . '/inc/extras/extras.php'; // extras files.
require get_template_directory() . '/inc/widgets/widgets.php'; // widget handlers
include get_template_directory() . '/inc/styles.php';
include get_template_directory() . '/inc/admin/class-theme-info.php';
/**
 * Wrap last word with span
 * 
 * @package Trendy News
 * @since 1.0.0
 */
function trendy_news_wrap_last_word($string) {
    // Breaks string to pieces
    $pieces = explode(" ", $string);
    // Modifies the last word
    $pieces[count($pieces)-1] = '<sub>' . $pieces[count($pieces)-1] . '</sub>';
    // Returns the glued pieces
    return implode(" ", $pieces);
}

/**
 * Filter posts ajax function
 *
 * @package Trendy News
 * @since 1.0.0
 */
function trendy_news_filter_posts_load_tab_content() {
	check_ajax_referer( 'trendy-news-nonce', 'security' );
	$options = isset( $_GET['options'] ) ? json_decode( wp_unslash( $_GET['options'] ) ): '';
	if( empty( $options ) ) return;
	$query = $options->query;
	$orderArray = explode( '-', $query->order );
	$posts_args = array(
		'post_status'	=> 'publish',
		'posts_per_page'   => absint( $query->count ),
		'order' => esc_html( $orderArray[1] ),
		'orderby' => esc_html( $orderArray[0] ),
		'category_name' => esc_html( $options->category_name )
	);
	if( $query->ids ) $post_args['post__not_in'] = trendy_news_get_array_key_string_to_int( $query->ids );
	$tn_posts = new WP_Query( $posts_args );
	$total_posts = $tn_posts->post_count;
	if( $tn_posts -> have_posts() ):
			ob_start();
			echo '<div class="tab-content content-' .esc_html( $options->category_name ). '">';
				while( $tn_posts->have_posts() ) : $tn_posts->the_post();
					$res['loaded'] = true;
					$current_post = $tn_posts->current_post;
					if( ($current_post % 5) === 0 ) echo '<div class="row-wrap">';
						if( $current_post === 0 ) echo '<div class="featured-post">';
							if( $current_post === 1 || $current_post === 5 ) {
								?>
								<div class="trailing-post <?php if($current_post === 5) echo esc_attr('bottom-trailing-post'); ?>">
								<?php
							}
								// get template file w.r.t par
								get_template_part( 'template-parts/news-filter/content', 'one', $options );
							if( $current_post === 4 || ( $total_posts === $current_post + 1 ) ) echo '</div><!-- .trailing-post -->';
						if( $current_post === 0 ) echo '</div><!-- .featured-post-->';
					if( ($current_post % 5) === 4 || ( $total_posts === $current_post + 1 ) ) echo '</div><!-- .row-wrap -->';
				endwhile;
			echo '</div>';	
			$res['posts'] = ob_get_clean();
		else :
			$res['loaded'] = false;
			$res['posts'] = esc_html__( 'No posts found', 'trendy-news' );
		endif;
		echo json_encode( $res );
		wp_die();
}
add_action( 'wp_ajax_trendy_news_filter_posts_load_tab_content', 'trendy_news_filter_posts_load_tab_content');
add_action( 'wp_ajax_nopriv_trendy_news_filter_posts_load_tab_content', 'trendy_news_filter_posts_load_tab_content' );

if( ! function_exists( 'trendy_news_lazy_load_value' ) ) :
	/**
	 * Echos lazy load attribute value.
	 * 
	 * @package Trendy News
	 * @since 1.0.0
	 */
	function trendy_news_lazy_load_value() {
		echo esc_attr( apply_filters( 'trendy_news_lazy_load_value', 'lazy' ) );
	}
endif;

if( ! function_exists( 'trendy_news_add_menu_description' ) ) :
	// merge menu description element to the menu 
	function trendy_news_add_menu_description( $item_output, $item, $depth, $args ) {
		if($args->theme_location != 'menu-2') return $item_output;
		
		if ( !empty( $item->description ) ) {
			$item_output = str_replace( $args->link_after . '</a>', '<span class="menu-item-description">' . $item->description . '</span>' . $args->link_after . '</a>', $item_output );
		}
		return $item_output;
	}
	add_filter( 'walker_nav_menu_start_el', 'trendy_news_add_menu_description', 10, 4 );
endif;

if( ! function_exists( 'trendy_news_bool_to_string' ) ) :
	// boolean value to string 
	function trendy_news_bool_to_string( $bool ) {
		$string = ( $bool ) ? '1' : '0';
		return $string;
	}
endif;