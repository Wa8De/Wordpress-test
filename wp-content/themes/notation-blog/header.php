<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Notation Blog
 */
/**
* Hook - notation_blog_action_doctype.
*
* @hooked notation_blog_doctype -  10
*/
do_action( 'notation_blog_action_doctype' );
?>
<head>
<?php
/**
* Hook - notation_blog_action_head.
*
* @hooked notation_blog_head -  10
*/
do_action( 'notation_blog_action_head' );
?>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'wp_body_open' ); ?>

<?php

/**
* Hook - notation_blog_action_before.
*
* @hooked notation_blog_page_start - 10
*/
do_action( 'notation_blog_action_before' );

/**
*
* @hooked notation_blog_header_start - 10
*/
do_action( 'notation_blog_action_before_header' );

/**
*
*@hooked notation_blog_site_branding - 10
*@hooked notation_blog_header_end - 15 
*/
do_action('notation_blog_action_header');

/**
*
* @hooked notation_blog_content_start - 10
*/
do_action( 'notation_blog_action_before_content' );

/**
 * Banner start
 * 
 * @hooked notation_blog_banner_header - 10
*/
do_action( 'notation_blog_banner_header' );  
