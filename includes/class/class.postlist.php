<?php
class Rest_Post_List_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'Rest_Post_List_Widget',
			__( 'REST Post List Widget', 'rest-api-widgets' ),
			array( 'description' => __( 'Post List Widget Using WP REST API', 'rest-api-widgets' ), )
		);
	}

	public function widget( $args, $instance ) {
		$html = $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			$html .= $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		$api_url = home_url( '/' ). 'wp-json/wp/v2/posts';
		$api_url = apply_filters( 'rest-widgets-postlist-query' , $api_url );
		$api_url = esc_url( $api_url );
		$fail_text = __( 'Fail :(', 'rest-api-widgets' );
		$data = "data-postlist-url='{$api_url}' data-fail-text='{$fail_text}'";
		$html .= "<div id='rest-api-widgets-postlist' {$data}></div>";
		echo $html. $args['after_widget'];
	}

	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'REST API Comment Widget', 'rest-api-widgets' );
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Widget Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

}
