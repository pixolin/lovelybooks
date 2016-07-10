<?php
/**
 * Widget Class
 */

class LBWidget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {

		$widget_ops = array(
			'classname' => 'lovelbooks_widget',
			'description' => 'LovelyBooks-Widget',
		);
		parent::__construct( 'lb_widget', 'LovelyBooks', $widget_ops );

	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		// outputs the content of the widget
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		} ?>
			<div class="lvlybksWidgetReadingState"></div>
		<?php
		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title    = sanitize_text_field( $instance['title'] );
		$settings_page = '<a href="options-general.php?page=lovelybooks">'. __( 'settings page', 'lovelybooks' ) . '</a>';
		?>

		<p>

		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'lovelybooks' ); ?></label>

		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />

		</p>

		<p>
			<?php printf( __( 'Please don\'t forget to set your user ID and other settings on the <strong>%s</strong>', 'lovelybooks' ), $settings_page ); ?>
		</p>
		<?php
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}
}

add_action( 'widgets_init', function(){
	register_widget( 'LBWidget' );
});
