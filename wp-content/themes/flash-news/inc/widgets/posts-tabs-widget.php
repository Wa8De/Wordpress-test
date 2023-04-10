<?php
if ( ! class_exists( 'Flash_News_Posts_Tabs_Widget' ) ) {
	/**
	 * Adds Flash_News_Posts_Tabs_Widget Widget.
	 */
	class Flash_News_Posts_Tabs_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		public function __construct() {
			$flash_news_posts_tabs_widget_ops = array(
				'classname'   => 'ascendoor-widget magazine-tabs-section',
				'description' => __( 'Retrive Posts Tabs Widgets', 'flash-news' ),
			);
			parent::__construct(
				'flash_news_magazine_tabs_widget',
				__( 'Ascendoor Posts Tabs Widget', 'flash-news' ),
				$flash_news_posts_tabs_widget_ops
			);
		}

		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 *
		 * @param array $args     Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget( $args, $instance ) {
			if ( ! isset( $args['widget_id'] ) ) {
				$args['widget_id'] = $this->id;
			}
			$tab_post_offset = isset( $instance['offset'] ) ? absint( $instance['offset'] ) : '';

			echo $args['before_widget'];
			?>
			<div class="magazine-tabs-wrapper">
				<div class="magazine-tabs-head">
					<ul class="magazine-tabs">
						<?php
						for ( $i = 1; $i <= 2; $i++ ) {
							$tab_category_id = isset( $instance[ 'category_' . $i ] ) ? absint( $instance[ 'category_' . $i ] ) : '';
							$tab_category    = get_category( $tab_category_id );
							$tab_name        = ! empty( $tab_category->name ) ? $tab_category->name : sprintf( __( 'Tab Title %d', 'flash-news' ), $i );
							$tab_slug        = ! empty( $tab_category->slug ) ? $tab_category->slug : 'tab-' . $i;
							$tab_title       = ( ! empty( $instance[ 'title_' . $i ] ) ) ? ( $instance[ 'title_' . $i ] ) : $tab_name;
							$tab_title       = apply_filters( 'widget_title_' . $i, $tab_title, $instance, $this->id_base );
							?>
							<li><a href="#<?php echo esc_attr( $tab_slug ); ?>" class="latest"><span><?php echo esc_html( $tab_title ); ?></span></a></li>
							<?php
						}
						?>
					</ul>
				</div>
				<div class="magazine-tab-content-wrapper">
					<?php
					for ( $i = 1; $i <= 2; $i++ ) {
						$tab_category_id = isset( $instance[ 'category_' . $i ] ) ? absint( $instance[ 'category_' . $i ] ) : '';
						$tab_category    = get_category( $tab_category_id );
						$tab_slug        = ! empty( $tab_category->slug ) ? $tab_category->slug : 'tab-' . $i;
						?>
						<div class="magazine-tab-container" id="<?php echo esc_attr( $tab_slug ); ?>">
							<?php
							$posts_tabs_widgets_args = array(
								'post_type'      => 'post',
								'posts_per_page' => absint( 4 ),
								'offset'         => absint( $tab_post_offset ),
								'orderby'        => 'date',
								'order'          => 'desc',
								'cat'            => absint( $tab_category_id ),
							);

							$query = new WP_Query( $posts_tabs_widgets_args );
							if ( $query->have_posts() ) :
								while ( $query->have_posts() ) :
									$query->the_post();
									?>
									<div class="mag-post-single has-image list-design">
										<div class="mag-post-img">
											<a href="<?php the_permalink(); ?>">
												<?php the_post_thumbnail(); ?>
											</a>
										</div>
										<div class="mag-post-detail">
											<div class="mag-post-category">
												<?php flash_news_categories_list(); ?>
											</div>
											<h3 class="mag-post-title">
												<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
											</h3>
											<div class="mag-post-meta">
												<span class="post-author">
													<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><i class="fas fa-user"></i><?php echo esc_html( get_the_author() ); ?></a>
												</span>
												<span class="post-date">
													<a href="<?php the_permalink(); ?>"><i class="far fa-clock"></i><?php echo esc_html( get_the_date() ); ?></a>
												</span>
											</div>
											<div class="mag-post-excerpt">
												<p><?php echo esc_html( wp_trim_words( get_the_content(), 30 ) ); ?></p>
											</div>
										</div>
									</div>
									<?php
								endwhile;
								wp_reset_postdata();
							endif;
							?>
						</div>
						<?php
					}
					?>
				</div>
			</div>
			<?php
			echo $args['after_widget'];
		}

		/**
		 * Back-end widget form.
		 *
		 * @see WP_Widget::form()
		 *
		 * @param array $instance Previously saved values from database.
		 */
		public function form( $instance ) {
			$tab_post_offset = isset( $instance['offset'] ) ? absint( $instance['offset'] ) : '';
			?>
			<?php
			for ( $i = 1; $i <= 2; $i++ ) {
				$tab_title    = isset( $instance[ 'title_' . $i ] ) ? ( $instance[ 'title_' . $i ] ) : '';
				$tab_category = isset( $instance[ 'category_' . $i ] ) ? absint( $instance[ 'category_' . $i ] ) : '';
				?>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'title_' . $i ) ); ?>"><?php echo sprintf( esc_html__( 'Section Title %d:', 'flash-news' ), $i ); ?></label>
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title_' . $i ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_' . $i ) ); ?>" type="text" value="<?php echo esc_attr( $tab_title ); ?>" />
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'category_' . $i ) ); ?>"><?php echo sprintf( esc_html__( 'Select the category %d to show posts:', 'flash-news' ), $i ); ?></label>
					<select id="<?php echo esc_attr( $this->get_field_id( 'category_' . $i ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'category_' . $i ) ); ?>" class="widefat" style="width:100%;">
						<?php
						$categories = flash_news_get_post_cat_choices();
						foreach ( $categories as $category => $value ) {
							?>
							<option value="<?php echo absint( $category ); ?>" <?php selected( $tab_category, $category ); ?>><?php echo esc_html( $value ); ?></option>
							<?php
						}
						?>
					</select>
				</p>
				<?php
			}
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>"><?php esc_html_e( 'Number of posts to displace or pass over:', 'flash-news' ); ?></label>
				<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'offset' ) ); ?>" type="number" step="1" min="0" value="<?php echo absint( $tab_post_offset ); ?>" size="3" />
			</p>
			<?php
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @see WP_Widget::update()
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			for ( $i = 1; $i <= 2;$i++ ) {
				$instance[ 'title_' . $i ]    = sanitize_text_field( $new_instance[ 'title_' . $i ] );
				$instance[ 'category_' . $i ] = (int) $new_instance[ 'category_' . $i ];
			}
			$instance['offset'] = (int) $new_instance['offset'];
			return $instance;
		}

	}
}
