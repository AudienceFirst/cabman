<?php
/**
 * Adds gg_Contact_Widget widget.
 */
class gg_Flickr_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'gg_flickr_widget', // Base ID
			__('Flickr Widget', 'okthemes'), // Name
			array( 'description' => __( 'Display up to 20 of your latest Flickr submissions', 'okthemes' ), 'classname' => 'flickr-widget', ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 */
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );

		$username = ! empty( $instance['username'] ) ? $instance['username'] : '';
		$count = ! empty( $instance['count'] ) ? $instance['count'] : '';

		echo $args['before_widget'];

		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
				

		echo '<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count='. $count . '&amp;display=latest&amp;size=s&amp;layout=x&amp;source=user&amp;user='. $username .'"></script>';
		echo '<p class="flickr_stream_wrap"><a class="wpb_follow_btn wpb_flickr_stream" href="http://www.flickr.com/photos/'. $username .'"><i class="social_flickr"></i>'.__("View stream on flickr", "okthemes").'</a></p>';

		echo $args['after_widget'];
	}
	

	/**
	 * Back-end widget form.
	 */
	public function form( $instance ) {
		
		$title = isset( $instance['title'] ) ? $instance['title'] : __( 'Photostream', 'okthemes' );
		$username = isset( $instance['username'] ) ? $instance['username'] : '';
		$count = isset( $instance['count'] ) ? absint( $instance['count'] ) : 10;

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:','okthemes' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php _e( 'Flickr ID (To find your flickID visit <a href="http://idgettr.com/" target="_blank">idGettr</a>)' ); ?> </label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" type="text" value="<?php echo esc_attr( $username ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Count:','okthemes' ); ?></label><br />
			<input type="number" min="1" max="20" value="<?php echo esc_attr( $count ); ?>" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" />
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
		$instance['count'] = ( ! empty( $new_instance['count'] ) ) ? absint( $new_instance['count'] ) : '';
		
		return $instance;
	}


} // class gg_Flickr_Widget

// register gg_Flickr_Widget 
function register_gg_flickr_widget() {
    register_widget( 'gg_Flickr_Widget' );
}
add_action( 'widgets_init', 'register_gg_flickr_widget' );