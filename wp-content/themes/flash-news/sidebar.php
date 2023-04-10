<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Flash_News
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area">
	<div class="secondary-widgets-section-inside">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</div>	
</aside><!-- #secondary -->
