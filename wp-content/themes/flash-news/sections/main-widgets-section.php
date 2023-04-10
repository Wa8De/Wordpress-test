<?php

$sidebar_position = get_theme_mod( 'flash_news_frontpage_sidebar_position', 'frontpage-right-sidebar' );
$no_sidebar       = is_active_sidebar( 'secondary-widgets-section' ) ? '' : 'main-full-width';
$classes          = implode( ' ', array( $sidebar_position, $no_sidebar ) );

if ( is_active_sidebar( 'primary-widgets-section' ) || is_active_sidebar( 'secondary-widgets-section' ) ) {
	?>
	<div class="main-widget-section">
		<div class="ascendoor-wrapper">
			<div class="main-widget-section-wrap <?php echo esc_attr( $classes ); ?>">
				<?php if ( is_active_sidebar( 'primary-widgets-section' ) ) { ?>
					<div class="primary-widgets-section">
						<?php dynamic_sidebar( 'primary-widgets-section' ); ?>
					</div>
					<?php
				}
				if ( is_active_sidebar( 'secondary-widgets-section' ) && $sidebar_position !== 'no-frontpage-sidebar' ) {
					?>
					<div class="secondary-widgets-section">
						<div class="secondary-widgets-section-inside">
							<?php dynamic_sidebar( 'secondary-widgets-section' ); ?>
						</div>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</div>
	<?php
}
?>
