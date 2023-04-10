<?php
/**
 * Theme setup functions.
 *
 * @package ThinkUpThemes
 */


//----------------------------------------------------------------------------------
//	ADD CUSTOM HOOKS
//----------------------------------------------------------------------------------

// Used at top of header.php
function thinkup_hook_header() { 
	do_action('thinkup_hook_header');
}

// Used at top of header.php within the body tag
function thinkup_bodystyle() { 
	do_action('thinkup_bodystyle');
}

// Used after <body> tag in header.php
function thinkup_hook_bodyhtml() { 
	do_action('thinkup_hook_bodyhtml');
}


//----------------------------------------------------------------------------------
//	ADD PAGE TITLE
//----------------------------------------------------------------------------------

function thinkup_title_select() {
	global $post;

	if ( is_page() ) {
		printf( '%s', esc_html( get_the_title() ) );
	} elseif ( is_attachment() ) {
		printf( esc_html__( 'Blog Post Image: ', 'sento' ) . '%s', esc_html( get_the_title( $post->post_parent ) ) );
	} else if ( is_single() ) {
		printf( '%s', html_entity_decode( esc_html( get_the_title() ) ) );
	} else if ( is_search() ) {
		printf( esc_html__( 'Search Results: ', 'sento' ) . '%s', esc_html( get_search_query() ) );
	} else if ( is_404() ) {
		printf( esc_html__( 'Page Not Found', 'sento' ) );
	} else if ( is_category() ) {
		printf( esc_html__( 'Category Archives: ', 'sento' ) . '%s', single_cat_title( '', false ) );
	} elseif ( is_tag() ) {
		printf( esc_html__( 'Tag Archives: ', 'sento' ) . '%s', single_tag_title( '', false ) );
	} elseif ( is_author() ) {
		the_post();
		printf( esc_html__( 'Author Archives: ', 'sento' ) . '%s', get_the_author() );
		rewind_posts();
	} elseif ( is_day() ) {
		printf( esc_html__( 'Daily Archives: ', 'sento' ) . '%s', get_the_date() );
	} elseif ( is_month() ) {
		printf( esc_html__( 'Monthly Archives: ', 'sento' ) . '%s', get_the_date( 'F Y' ) );
	} elseif ( is_year() ) {
		printf( esc_html__( 'Yearly Archives: ', 'sento' ) . '%s', get_the_date( 'Y' ) );
	} elseif ( is_archive() ) {
		printf( get_the_archive_title() );
	} elseif ( is_tax() ) {
		printf( esc_html( get_queried_object()->name ) );
	} elseif ( thinkup_check_isblog() ) {
		printf( esc_html__( 'Blog', 'sento' ) );
	} else {
		printf( '%s', html_entity_decode( esc_html( get_the_title() ) ) );
	}
}

// Remove "archive" text from custom post type archive pages
function thinkup_title_select_cpt($title) {
    if ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	}
	return $title;
};
add_filter( 'get_the_archive_title', 'thinkup_title_select_cpt' );


//----------------------------------------------------------------------------------
//	ADD BREADCRUMBS FUNCTIONALITY
//----------------------------------------------------------------------------------

function thinkup_input_breadcrumb() {

	$output           = NULL;
	$count_loop       = NULL;
	$count_categories = NULL;

	$delimiter = '<span class="delimiter">/</span>';

	$delimiter_inner   =   '<span class="delimiter_core"> &bull; </span>';
	$main              =   __( 'Home', 'sento' );
	$maxLength         =   30;

	/* Archive variables */
	$arc_year       =   get_the_time('Y');
	$arc_month      =   get_the_time('F');
	$arc_day        =   get_the_time('d');
	$arc_day_full   =   get_the_time('l');  

	/* URL variables */
	$url_year    =   get_year_link($arc_year);
	$url_month   =   get_month_link($arc_year,$arc_month);

	/* Display breadcumbs if NOT the home page */
	if ( ! is_front_page() ) {
		$output .= '<div id="breadcrumbs"><div id="breadcrumbs-core">';
		global $post, $cat;
		$homeLink = esc_url( home_url( '/' ) );
		$output .= '<a href="' . esc_url( $homeLink ) . '">' . esc_html( $main ) . '</a>' . $delimiter;    

		/* Display breadcrumbs for single post */
		if ( is_single() ) {
			$category = get_the_category();
			$num_cat = count($category);
			if ($num_cat <=1) {
				$output .= ' ' . html_entity_decode( esc_html( get_the_title() ) );
			} else {

				// Count Total categories
				foreach( get_the_category() as $category) {
					$count_categories++;
				}
				
				// Output Categories
				foreach( get_the_category() as $category) {
					$count_loop++;

					if ( $count_loop < $count_categories ) {
						$output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->cat_name ) . '</a>' . $delimiter_inner; 
					} else {
						$output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->cat_name ) . '</a>'; 
					}
				}
				
				if (strlen(get_the_title()) >= $maxLength) {
					$output .=  ' ' . $delimiter . esc_html( trim( substr( get_the_title(), 0, $maxLength ) ) ) . ' &hellip;';
				} else {
					$output .=  ' ' . $delimiter . esc_html( get_the_title() );
				}
			}
		} elseif (is_category()) {
			$output .= '<span class="breadcrumbs-cat">' . esc_html__( 'Archive Category: ', 'sento' ) . '</span>' . esc_html( single_cat_title("", false) );
		} elseif ( is_tag() ) {
			$output .= '<span class="breadcrumbs-tag">' . esc_html__( 'Posts Tagged: ', 'sento' ) . '</span>' . single_tag_title("", false);
		} elseif ( is_day()) {
			$output .=  '<a href="' . esc_url( $url_year ) . '">' . esc_html( $arc_year ) . '</a> ' . $delimiter . ' ';
			$output .=  '<a href="' . esc_url( $url_month ) . '">' . esc_html( $arc_month ) . '</a> ' . $delimiter . esc_html( $arc_day ) . ' (' . esc_html( $arc_day_full ) . ')';
		} elseif ( is_month() ) {
			$output .=  '<a href="' . esc_url( $url_year ) . '">' . esc_html( $arc_year ) . '</a> ' . $delimiter . esc_html( $arc_month );
		} elseif ( is_year() ) {
			$output .= esc_html( $arc_year );
		} elseif ( is_search() ) {
			$output .= esc_html__( 'Search Results for: ', 'sento' ) . esc_html( get_search_query() ) . '"';
		} elseif ( is_page() && !$post->post_parent ) {
			$output .=  esc_html( get_the_title() );
		} elseif ( is_page() && $post->post_parent ) {
			$post_array = get_post_ancestors( $post );
			krsort( $post_array ); 
			foreach( $post_array as $key=>$postid ){
				$post_ids = get_post( $postid );
				$title = $post_ids->post_title;
				$output  .= '<a href="' . esc_url( get_permalink( $post_ids ) ) . '">' . esc_html( $title ) . '</a>' . $delimiter;
			}
			$output .= esc_html( get_the_title() );
		} elseif ( is_author() ) {
			global $author;
			$user_info = get_userdata($author);
			$output .= esc_html__( 'Archived Article(s) by Author: ', 'sento' ) . esc_html( $user_info->display_name );
		} elseif ( is_404() ) {
			$output .= esc_html__( 'Error 404 - Not Found.', 'sento' );
		} elseif ( is_archive() ) {
			$output .= get_the_archive_title();
		} elseif( is_tax() ) {
			$output .= esc_html( get_queried_object()->name );
		} elseif ( thinkup_check_isblog() ) {
			$output .= esc_html__( 'Blog', 'sento' );
		} else {
			$output .= html_entity_decode( esc_html( get_the_title() ) );
		}

		$output .=  '</div></div>';
	   
		return $output;
    }
}


/* ----------------------------------------------------------------------------------
	ADD MENU DESCRIPTION FEATURE
---------------------------------------------------------------------------------- */

class thinkup_menudescription extends Walker_Nav_Menu {

	function start_el(&$output, $item, $depth=0, $args=array(), $id = 0) {
		global $wp_query;
		
		$item_output = NULL;
		
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
 
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';
 
		$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

		$attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) .'"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) .'"' : '';
		$attributes .= ! empty( $item->url ) ? ' href="' . esc_url( $item->url ) .'"' : ' href="' . esc_url( get_permalink( $item->ID ) ) . '"';

        // Insert title for top level
		if ( has_nav_menu( 'header_menu' ) ) {
			$title = ( $depth == 0 )
				? '<span>' . apply_filters( 'the_title', $item->title, $item->ID ) . '</span>' : apply_filters( 'the_title', $item->title, $item->ID );
		} else {
			$title = ( $depth == 0 )
				? '<span>' . apply_filters( 'the_title', get_the_title($item->ID), $item->ID ) . '</span>' : apply_filters( 'the_title', get_the_title($item->ID), $item->ID );
		}

        // Structure of output
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $title;
		$item_output .= '</a>';

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}


//----------------------------------------------------------------------------------
//	ADD CUSTOM FEATURED IMAGE SIZES
//----------------------------------------------------------------------------------

if ( ! function_exists( 'thinkup_input_addimagesizes' ) ) {
	function thinkup_input_addimagesizes() {

		// Image size for testimonial shortcode
		add_image_size( 'sc-testimonial-1', 53, 53, true );
		add_image_size( 'sc-testimonial-2', 85, 85, true );

		/* 1 Column Layout */
		add_image_size( 'column1-1/2', 1140, 570, true );
		add_image_size( 'column1-1/3', 1140, 380, true );
		add_image_size( 'column1-1/4', 1140, 285, true );
		add_image_size( 'column1-2/5', 1140, 456, true );

		/* 2 Column Layout */
		add_image_size( 'column2-1/1', 570, 570, true );
		add_image_size( 'column2-1/4', 570, 142, true );
		add_image_size( 'column2-1/2', 570, 285, true );
		add_image_size( 'column2-2/3', 570, 380, true );
		add_image_size( 'column2-3/5', 570, 342, true );

		/* 3 Column Layout */
		add_image_size( 'column3-1/1', 380, 380, true );
		add_image_size( 'column3-1/3', 380, 107, true );
		add_image_size( 'column3-2/5', 380, 152, true );	
		add_image_size( 'column3-2/3', 380, 254, true );
		add_image_size( 'column3-3/4', 380, 285, true );

		/* 4 Column Layout */
		add_image_size( 'column4-1/1', 285, 285, true );
		add_image_size( 'column4-2/3', 285, 190, true );
		add_image_size( 'column4-3/4', 285, 214, true );
	}
	add_action( 'after_setup_theme', 'thinkup_input_addimagesizes' );
}

if ( ! function_exists( 'thinkup_input_showimagesizes' ) ) { 
	function thinkup_input_showimagesizes($sizes) {

		// 1 Column Layout
		$sizes['column1-1/2'] = __( 'Full - 1:2', 'sento' );
		$sizes['column1-1/3'] = __( 'Full - 1:3', 'sento' );
		$sizes['column1-1/4'] = __( 'Full - 1:4', 'sento' );
		$sizes['column1-2/5'] = __( 'Full - 2:5', 'sento' );

		// 2 Column Layout
		$sizes['column2-1/1'] = __( 'Half - 1:1', 'sento' );
		$sizes['column2-1/2'] = __( 'Half - 1:2', 'sento' );
		$sizes['column2-2/3'] = __( 'Half - 2:3', 'sento' );
		$sizes['column2-3/5'] = __( 'Half - 3:5', 'sento' );

		// 3 Column Layout
		$sizes['column3-1/1'] = __( 'Third - 1:1', 'sento' );
		$sizes['column3-2/5'] = __( 'Third - 2:5', 'sento' );
		$sizes['column3-2/3'] = __( 'Third - 2:3', 'sento' );
		$sizes['column3-3/4'] = __( 'Third - 3:4', 'sento' );

		// 4 Column Layout
		$sizes['column4-1/1'] = __( 'Quarter - 1:1', 'sento' );
		$sizes['column4-2/3'] = __( 'Quarter - 2:3', 'sento' );
		$sizes['column4-3/4'] = __( 'Quarter - 3:4', 'sento' );

		return $sizes;
	}
	add_filter('image_size_names_choose', 'thinkup_input_showimagesizes');
}


//----------------------------------------------------------------------------------
//	CHANGE FALLBACK WP_PAGE_MENU CLASSES TO MATCH WP_NAV_MENU CLASSES
//----------------------------------------------------------------------------------

function thinkup_input_menuclass( $ulclass ) {

	// Add menu class to list
	$ulclass = preg_replace( '/<ul>/', '<ul class="menu">', $ulclass, 1 );
	$ulclass = str_replace( 'children', 'sub-menu', $ulclass );

	// Remove div wrapper
	$ulclass = str_replace( '<div class="menu">', '', $ulclass );
	$ulclass = str_replace( '</div>', '', $ulclass );

	return preg_replace('/<div (.*)>(.*)<\/div>/iU', '$2', $ulclass );
}
add_filter( 'wp_page_menu', 'thinkup_input_menuclass' );


//----------------------------------------------------------------------------------
//	DETERMINE IF THE PAGE IS A BLOG - USEFUL FOR HOMEPAGE BLOG.
//----------------------------------------------------------------------------------

// Credit to: http://www.poseidonwebstudios.com/web-development/wordpress-is_blog-function/
function thinkup_check_isblog() {
 
    global $post;
 
    //Post type must be 'post'.
    $post_type = get_post_type($post);
 
    //Check all blog-related conditional tags, as well as the current post type,
    //to determine if we're viewing a blog page.
    return (
        ( is_home() || is_archive() )
        && ($post_type == 'post')
    ) ? true : false ;
 
}


//----------------------------------------------------------------------------------
//	ADD GOOGLE FONT - OPEN SANS. (http://themeshaper.com/2014/08/13/how-to-add-google-fonts-to-wordpress-themes/)
//----------------------------------------------------------------------------------

function thinkup_googlefonts_url() {
    $fonts_url = '';

    // Translators: Translate this to 'off' if there are characters in your language that are not supported by Open Sans
    $font_translate = _x( 'on', 'Open Sans font: on or off', 'sento' );
 
    if ( 'off' !== $font_translate ) {
        $font_families = array();
  
        if ( 'off' !== $font_translate ) {
            $font_families[] = 'Open Sans:300,400,600,700';
        }
 
        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );
 
        $fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
    }
 
    return $fonts_url;
}

function thinkup_googlefonts_scripts() {
   wp_enqueue_style( 'thinkup-google-fonts', thinkup_googlefonts_url(), array(), null );
}
add_action( 'wp_enqueue_scripts', 'thinkup_googlefonts_scripts' );


//----------------------------------------------------------------------------------
//	ADD THEMEBUTTON2 CLASS TO COMMENT CANCEL REPLY BUTTON
//----------------------------------------------------------------------------------

function thinkup_input_cancelreplyclass($class){
    $class = str_replace( 'id="cancel-comment-reply-link"', 'id="cancel-comment-reply-link" class="themebutton2"', $class);
    return $class;
}
add_filter('cancel_comment_reply_link', 'thinkup_input_cancelreplyclass');


//----------------------------------------------------------------------------------
//	FIX JETPACK PHOTON IMAGE LOAD ISSUE - DISABLE CACHING FOR SPECIFIC IMAGES 
//----------------------------------------------------------------------------------

function thinkup_photon_exception( $val, $src, $tag ) {
        if ( $src == get_template_directory_uri() . '/images/transparent.png' ) {
                return true;
        }
        return $val;
}
add_filter( 'jetpack_photon_skip_image', 'thinkup_photon_exception', 10, 3 );


//----------------------------------------------------------------------------------
//	CHECK PERMISSIONS
//----------------------------------------------------------------------------------

function thinkup_check_permission() {
	return true;
}

