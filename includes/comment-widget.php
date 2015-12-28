<?php
// Foo_Widget ウィジェットを登録
function register_foo_widget() {
    register_widget( 'Foo_Widget' );
}
add_action( 'widgets_init', 'register_foo_widget' );
add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );
function theme_name_scripts() {
	wp_enqueue_script( 'script-name', plugin_dir_url( __FILE__ ).'/comment-widget.js', array(), '1.0.0', true );
}
/**
 * Adds Foo_Widget widget.
 */
class Foo_Widget extends WP_Widget {

	/**
	 * WordPress でウィジェットを登録
	 */
	function __construct() {
		parent::__construct(
			'foo_widget', // Base ID
			__( 'ウィジェットのタイトル', 'text_domain' ), // Name
			array( 'description' => __( 'サンプルのウィジェット「Foo Widget」です。', 'text_domain' ), ) // Args
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

		$html = $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			$html .= $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}

		$the_id = get_the_ID();
		if ( comments_open( $the_id ) ) {

			$api_url ='http://rest-api.dev/wp-json/wp/v2/comments';
			$author  = __( '名前：', 'text_domain' );
			$mailaddress = __( 'メールアドレス：', 'text_domain' );
			$content  = __( 'コメント：', 'text_domain' );
			$send_btn = __( '送信', 'text_domain' );

			$html .= "<form action={$api_url} method='post' id='json-comment'>";
			$html .= '<dl>';
			$html .= "<dt>{$author}</dt><dd><input name='author_name' value=''></dd>";
			$html .= "<dt>{$mailaddress}</dt><dd><input name='author_email' value=''></dd>";
			$html .= "<dt>{$content}</dt><dd><textarea name='content' id=' cols='30' rows='10'></textarea></dd>";
			$html .= '</dl>';
			$html .= "<input type='hidden' name='post' value='{$the_id}'></label>";
			$html .= "<button>{$send_btn}</button>";
			$html .= '</form>';

		} else {
			$html .= __( 'この記事のコメント欄は閉じられています。', 'text_domain' );
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
