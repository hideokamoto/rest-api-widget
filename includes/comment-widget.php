<?php
// Rest_Comment_Widget ウィジェットを登録
function register_rest_comment_widget() {
    register_widget( 'Rest_Comment_Widget' );
}
add_action( 'widgets_init', 'register_rest_comment_widget' );

/**
 * Adds Rest_Comment_Widget widget.
 */
class Rest_Comment_Widget extends WP_Widget {

	/**
	 * WordPress でウィジェットを登録
	 */
	function __construct() {
		parent::__construct(
			'Rest_Comment_Widget', // Base ID
			__( 'REST Comment Form Widget', 'text_domain' ), // Name
			array( 'description' => __( 'Comment Form Widget Using WP REST API', 'text_domain' ), ) // Args
		);
	}

	/**
	 * ウィジェットのフロントエンド表示
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     ウィジェットの引数
	 * @param array $instance データベースの保存値
	 */
	public function widget( $args, $instance ) {
		if ( ! is_singular() ) {
			return;
		}

		$the_id = get_the_ID();
		if ( ! comments_open( $the_id ) ) {
			return;
		} else {
			$html = $args['before_widget'];
			if ( ! empty( $instance['title'] ) ) {
				$html .= $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
			}
			$api_url = esc_url( home_url( '/' ) ). 'wp-json/wp/v2/comments';
			$author  = __( 'NAME:', 'text_domain' );
			$mailaddress = __( 'MAIL:', 'text_domain' );
			$content  = __( 'COMMENTS:', 'text_domain' );
			$send_btn = __( 'SEND', 'text_domain' );
			$success_text = __( 'Success! Reload now.', 'text_domain' );
			$fail_text = __( 'Fail :(', 'text_domain' );

			$html .= "<form action={$api_url} method='post' id='rest-api-widgets-comment'>";
			$html .= '<dl>';
			$html .= "<dt>{$author}</dt><dd><input name='author_name' value=''></dd>";
			$html .= "<dt>{$mailaddress}</dt><dd><input name='author_email' value=''></dd>";
			$html .= "<dt>{$content}</dt><dd><textarea name='content' id=' cols='30' rows='10'></textarea></dd>";
			$html .= '</dl>';
			$html .= "<input type='hidden' name='post' value='{$the_id}'>";
			$html .= "<input type='hidden' name='success_text' value='{$success_text}'>";
			$html .= "<input type='hidden' name='fail_text' value='{$fail_text}'>";
			$html .= "<button>{$send_btn}</button>";
			$html .= '</form>';
		}

		echo $html. $args['after_widget'];
	}

	/**
	 * バックエンドのウィジェットフォーム
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance データベースからの前回保存された値
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'REST API Comment Widget', 'text_domain' );
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Widget Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
	}

	/**
	 * ウィジェットフォームの値を保存用にサニタイズ
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance 保存用に送信された値
	 * @param array $old_instance データベースからの以前保存された値
	 *
	 * @return array 保存される更新された安全な値
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

}
