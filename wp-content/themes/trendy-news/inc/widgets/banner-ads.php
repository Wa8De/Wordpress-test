<?php
/**
 * Adds Trendy_News_Banner_Ads_Widget widget.
 * 
 * @package Trendy News
 * @since 1.0.0
 */
class Trendy_News_Banner_Ads_Widget extends WP_Widget {
    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'trendy_news_banner_ads_widget',
            esc_html__( 'TN : Banner Ads', 'trendy-news' ),
            array( 'description' => __( 'The details of advertisement.', 'trendy-news' ) )
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
        extract( $args );
        $widget_title = isset( $instance['widget_title'] ) ? $instance['widget_title'] : '';
        $ad_image = isset( $instance['ad_image'] ) ? $instance['ad_image'] : '';
        $target_url = isset( $instance['target_url'] ) ? $instance['target_url'] : '';
        $target_attr = isset( $instance['target_attr'] ) ? $instance['target_attr'] : '_blank';
        $rel_attr = isset( $instance['rel_attr'] ) ? $instance['rel_attr'] : 'nofollow';

        echo wp_kses_post( $before_widget );
            echo '<div class="tn-advertisement-block">';
                if( $widget_title ) echo '<h2 class="tn-block-title">' .esc_html( $widget_title ). '</h2>';
                if( $ad_image ) {
                ?>
                    <figure class="inner-ad-block">
                        <a href="<?php echo esc_url( $target_url ); ?>" target="<?php echo esc_attr( $target_attr ); ?>" rel="<?php echo esc_attr( $rel_attr ); ?>"><img src="<?php echo esc_url( $ad_image ); ?>"></a>
                    </figure>
                <?php
                }
            echo '</div>';
        echo wp_kses_post( $after_widget );
    }

    /**
     * Widgets fields
     * 
     */
    function widget_fields() {
        return array(
                array(
                    'name'      => 'widget_title',
                    'type'      => 'text',
                    'title'     => esc_html__( 'Banner Title', 'trendy-news' ),
                    'description'=> esc_html__( 'Add the widget title here', 'trendy-news' )
                ),
                array(
                    'name'      => 'ad_image',
                    'type'      => 'upload',
                    'title'     => esc_html__( 'Banner Image', 'trendy-news' )
                ),
                array(
                    'name'      => 'target_url',
                    'type'      => 'url',
                    'title'     => esc_html__( 'Ad URL', 'trendy-news' ),
                ),
                array(
                    'name'      => 'target_attr',
                    'type'      => 'select',
                    'title'     => esc_html__( 'Ad link open in', 'trendy-news' ),
                    'default'   => '_blank',
                    'options'   => array(
                        '_blank'    => esc_html__( 'Open link in new tab', 'trendy-news' ),
                        '_self'    => esc_html__( 'Open link in same tab', 'trendy-news' )
                    )
                ),
                array(
                    'name'      => 'rel_attr',
                    'type'      => 'select',
                    'title'     => esc_html__( 'Link rel attribute value', 'trendy-news' ),
                    'default'   => 'nofollow',
                    'options'   => array(
                        'nofollow'  => 'nofollow',
                        'noopener'  => 'noopener',
                        'noreferrer'    => 'noreferrer'
                    )
                )
            );
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        $widget_fields = $this->widget_fields();
        foreach( $widget_fields as $widget_field ) :
            if ( isset( $instance[ $widget_field['name'] ] ) ) {
                $field_value = $instance[ $widget_field['name'] ];
            } else if( isset( $widget_field['default'] ) ) {
                $field_value = $widget_field['default'];
            } else {
                $field_value = '';
            }
            trendy_news_widget_fields( $this, $widget_field, $field_value );
        endforeach;
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
        $widget_fields = $this->widget_fields();
        if( ! is_array( $widget_fields ) ) {
            return $instance;
        }
        foreach( $widget_fields as $widget_field ) :
            $instance[$widget_field['name']] = trendy_news_sanitize_widget_fields( $widget_field, $new_instance );
        endforeach;

        return $instance;
    }
 
} // class Trendy_News_Banner_Ads_Widget