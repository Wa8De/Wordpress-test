<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Notation Blog
 */

/**
 *
 * @hooked notation_blog_footer_start
 */
do_action( 'notation_blog_action_before_footer' );

/**
 * Hooked - notation_blog_footer_top_section -10
 * Hooked - notation_blog_footer_section -20
 */
do_action( 'notation_blog_action_footer' );

/**
 * Hooked - notation_blog_footer_end. 
 */
do_action( 'notation_blog_action_after_footer' );

wp_footer(); ?>

</body>  
</html>