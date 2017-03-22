<?php
/**
 * Adds gg_Twitter_Widget widget.
 */
require_once PARENT_DIR . '/lib/twitter.php';

class gg_Twitter_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'gg_twitter_widget', // Base ID
			__('Twitter Widget', 'okthemes'), // Name
			array( 'description' => __( 'Display your latest tweets.', 'okthemes' ), 'classname' => 'twitter-widget', ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 */
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );

		$username = ! empty( $instance['username'] ) ? $instance['username'] : '';
		$posts = ! empty( $instance['posts'] ) ? $instance['posts'] : '';

		echo $args['before_widget'];

		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
				
		echo gg_get_tweets( $username, $posts );

		echo $args['after_widget'];
	}
	

	/**
	 * Back-end widget form.
	 */
	public function form( $instance ) {
		
		$title = isset( $instance['title'] ) ? $instance['title'] : __( 'Contact us', 'okthemes' );
		$username = isset( $instance['username'] ) ? $instance['username'] : '';
		$posts = isset( $instance['posts'] ) ? $instance['posts'] : '';

		?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
				<input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>">
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('username'); ?>">Your Twitter username:</label>
				<input class="widefat" type="text" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" value="<?php echo $instance['username']; ?>">
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('posts'); ?>">Number of posts to display</label>
				<input class="widefat" type="text" id="<?php echo $this->get_field_id('posts'); ?>" name="<?php echo $this->get_field_name('posts'); ?>" value="<?php echo $instance['posts']; ?>">
			</p>
		<?php 
	}


	/**
	 * Sanitize widget form values as they are saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();

		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['username'] = ( ! empty( $new_instance['username'] ) ) ? strip_tags( $new_instance['username'] ) : '';
		$instance['posts'] = ( ! empty( $new_instance['posts'] ) ) ? strip_tags( $new_instance['posts'] ) : '';
		
		return $instance;
	}


} // class gg_Twitter_Widget

// register gg_Twitter_Widget 
function register_gg_twitter_widget() {
    register_widget( 'gg_Twitter_Widget' );
}
add_action( 'widgets_init', 'register_gg_twitter_widget' );